<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Listing;
use App\PepoBackup;
use App\EnquiryCategory;
use Carbon\Carbon;

class UpdatePepoBackupTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $activity;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $activity = $this->activity;
        $on = $activity->subject;
        $by = $activity->causer;
        // the case should give back 2 fields. Email and all the tags that have to be added
        $fields = [];
        \Log::info('Event: '.$activity->description);
        switch ($activity->description) {
            case 'contact-request-created':
                $email = $by->getPrimaryEmail();
                $fields['userType'] = ['Contact Request'];
                if(get_class($by) == 'App\Lead'){
                    $fields['signUpType'] = 'Guest';
                    $fields['name'] = $by->name;
                    $fields['userSubType'] = unserialize($by->user_details_meta)['describes_best'];
                    $config = config('helper_generate_html_config.enquiry_popup_display');
                    foreach ($fields['userSubType'] as &$detail) {
                        $detail = $config[$detail]['title'];
                    }
                }
                break;
            case 'enquiry-created':
                $email = $by->getPrimaryEmail();
                if(get_class($by) == 'App\Lead'){
                    $fields['name'] = $by->name;
                    $fields['signUpType'] = 'Guest';
                    $fields['userSubType'] = unserialize($by->user_details_meta)['describes_best'];
                    $config = config('helper_generate_html_config.enquiry_popup_display');
                    foreach ($fields['userSubType'] as &$detail) {
                        $detail = $config[$detail]['title'];
                    }
                }
                $fields['userType'] = ['Enquiry'];
                $fields['enquiryCategories'] = json_decode(EnquiryCategory::getCategoryJsonTag($on->id),true);
                $fields['area'] = array_unique($on->areas()->with('city')->get()->pluck('city')->pluck('name')->toArray());
                break;
            case 'enquiry-updated':
                $email = $by->getPrimaryEmail();
                $fields['enquiryCategories'] = json_decode(EnquiryCategory::getCategoryJsonTag($on->id),true);
                $fields['area'] = array_unique($on->areas()->with('city')->get()->pluck('city')->pluck('name')->toArray());
                break;
            case 'email_signup':
                $email = $by->getPrimaryEmail();
                $fields['signUpType'] = 'Email';
                $fields['name'] = $by->name;
                $details = $by->getUserDetails->getSavedUserSubTypes();
                $fields['userSubType'] = array_values($details);
                $fields['stateID'] =  $by->getUserCity();
                $fields['state'] = $by->getUserCity(true);
                $fields['area'] = [$by->getUserCity() => $by->getUserCity(true)];
                break;
            case 'listing_created':
                $email = $by->getPrimaryEmail();
                $fields['area'] = [$on->location->city->id => $on->location->city->name];
                $fields['userType'] = ['Listing'];
                $fields['listingStatus'] = [$on->reference => Listing::listing_status[$on->status]];
                $fields['listingType'] = [Listing::listing_business_type[$on->type]];
                break;
            case 'listing_publish':
                $by = $on->owner;
                $email = $by->getPrimaryEmail();
                // $fields['listingType'] = ['Published'];
                break;
            case 'job_created':
                $email = $on->createdBy->getPrimaryEmail();
                $fields['userType'] = ['Job Poster'];
                $fields['jobCategory'] =  [$on->getJobCategoryName()];
                $fields['jobRole'] = explode(",", $on->getAllJobKeywords());
                $fields['jobStatus'] = [$on->reference_id => $on->getJobStatus()];
                $fields['jobArea'] = $on->getJobLocationNames('city');
                break;
            case 'job-status-change':
                $email = $on->createdBy->getPrimaryEmail();
                $fields['jobStatus'] = [$on->reference_id => $on->getJobStatus()];
                break;
            case 'profile_updated':
                $email = $on->getPrimaryEmail();
                $fields['stateID'] =  $on->getUserCity();
                $fields['state'] = $on->getUserCity(true);
                $fields['area'] = [$on->getUserCity() => $on->getUserCity(true)];
                $fields['name'] = $on->name;
                $details = $on->getUserDetails->getSavedUserSubTypes();
                $fields['userSubType'] = array_values($details);
                break;
            case 'user_requirements':
                $email = $by->getPrimaryEmail();
                $fields['stateID'] =  $by->getUserCity();
                $fields['state'] = $by->getUserCity(true);
                $fields['area'] = [$by->getUserCity() => $by->getUserCity(true)];
                $fields['name'] = $by->name;
                $details = $by->getUserDetails->getSavedUserSubTypes();
                $fields['userSubType'] = array_values($details);
                break;
            case 'orphan_created':
                $email = $on->getPrimaryEmail();
                $fields['stateID'] =  $on->getUserCity();
                $fields['state'] = $on->getUserCity(true);
                $fields['area'] = [$on->getUserCity() => $on->getUserCity(true)];
                $fields['signUpType'] = 'Listing';
                break;
            case 'user_confirmation':
                $email = $on->getPrimaryEmail();
                $fields['active'] = "True";
                break;
            case 'social_signup':
                $email = $on->getPrimaryEmail();
                $fields['active'] = "True";
                $fields['name'] = $on->name;
                $fields['signUpType']=ucfirst($activity->getExtraProperty('provider'));
                break;
            case 'listing_categories':
                $by = $on->owner;
                $email = $by->getPrimaryEmail();
                $fields['listingCategories'] = json_decode($activity->getExtraProperty('categories'),true);
                break;
            case 'listing_areas':
                $by = $on->owner;
                $email = $by->getPrimaryEmail();
                $fields['area'] = json_decode($activity->getExtraProperty('areas'),true);
                break;
            case 'newsletter':
                $email = $by->getPrimaryEmail();
                $fields['subscribed'] = $activity->getExtraProperty('subscribe');
                break;
            case 'listing-status-change':
                if($by!=null){
                    $email = $by->getPrimaryEmail();
                    $fields['listingStatus'] = [$on->reference => Listing::listing_status[$on->status]];
                }
                break;
            default:
            \Log::error($activity->description." cannot be handled");
                return;
                break;
        }

        $backup =  PepoBackup::where('email',$email)->first();

        if($backup == null){
            $backup = new PepoBackup;
            $backup['email'] = $email;  
        } 
        foreach ($fields as $key => $value) {

            switch ($key) {
                case 'name':
                case 'stateID':
                case 'state':
                case 'active':
                case 'subscribed':
                case 'signUpType':
                    $backup[$key] = $value;
                    break;
                case 'userSubType':
                    $backup[$key] = json_encode($value);
                    break;
                case 'userType':
                case 'listingType':
                case 'listingStatus':
                case 'enquiryCategories':
                case 'listingCategories':
                case 'jobStatus':
                case 'jobRole':
                case 'jobCategory':
                case 'jobArea':
                case 'area':
                    $oldVal = ($backup[$key] != null)? json_decode($backup[$key],true) : [];
                    $newVal = unique_array(array_merge($oldVal,$value));
                    $backup[$key] = json_encode($newVal);
                    \Log::info($key.'=>'.$backup[$key]);
                    break;
                default:
                    # code...
                    break;
            }
            \Log::info($key.'=>'.gettype($backup[$key]));
        }

        $listID = '3616';
        $url = '/api/v1/list/'.$listID.'/add-contact/';
        $pepoKey = '653cab790618ef33e954dcc4a2701528';
        $pepoSecret='08f4de7f8a8c6d2fa2dd5fb059abc4c8';
        $time = Carbon::now()->toRfc3339String();
        $string_to_sign = $url.'::'.$time;
        $signature = hash_hmac('sha256', $string_to_sign, $pepoSecret, false);
        

        $parameters = [
            'api-key' => $pepoKey,
            'signature' => $signature,
            'request-time' => $time,
            'email' => $backup->email,
            'attributes[name]' => ($backup->name != null) ? $backup->name : "",
            // 'attributes[stateID]' => ($backup->stateID != null) ? $backup->stateID : "0",
            'attributes[state]' => ($backup->state != null) ? $backup->state : "null",
            'attributes[active]' => ($backup->active != null) ? $backup->active : "False",
            'attributes[subscribed]' => ($backup->subscribed != null) ? $backup->subscribed : "True",
            'attributes[signUpType]' => ($backup->signUpType != null) ? $backup->signUpType : "null",
            'attributes[userType]' => ($backup->userType != null) ? $backup->userType : "null",
            'attributes[userSubType]' => ($backup->userSubType != null) ? $backup->userSubType : "null",
            'attributes[userSubType]' =>($backup->userSubType != null) ? $backup->userSubType : "null",
            'attributes[listingType]' => ($backup->listingType != null) ? $backup->listingType : "null",
            'attributes[listingStatus]' => ($backup->listingStatus != null) ? json_encode(unique_array(array_values(json_decode($backup->listingStatus,true)))) : "null",
            'attributes[listingCategories]' => ($backup->listingCategories != null) ? json_encode(unique_array(array_values(json_decode($backup->listingCategories,true)))) : "null",
            'attributes[enquiryCategories]' => ($backup->enquiryCategories != null) ? json_encode(unique_array(array_values(json_decode($backup->enquiryCategories,true)))) : "null",
            'attributes[area]' => ($backup->area != null) ? json_encode(unique_array(array_values(json_decode($backup->area,true)))) : "null",
        ];
       
        $fields_string = http_build_query($parameters);
        $ch = curl_init();
            $url1= 'https://pepocampaigns.com'.$url;
            $curl_options = array(
              CURLOPT_URL => $url1,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_SSLVERSION => 6,
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => $fields_string,
              );
            curl_setopt_array($ch, $curl_options);
           $backup->response = serialize(['response' => curl_exec($ch)]);
        curl_close($ch);
        $backup->save();
    }
}
