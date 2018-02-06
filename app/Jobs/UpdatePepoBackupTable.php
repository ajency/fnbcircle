<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        switch ($activity->description) {
            case 'contact-request-created':
                $email = $by->getPrimaryEmail();
                if(gettype($by) == 'App\Lead'){
                    $fields['signUpType'] = ['Guest'];
                    $fields['userType'] = ['Contact Request'];
                    $fields['userSubType'] = unserialize($by->user_details_meta)['describes_best'];
                    $config = config('helper_generate_html_config.enquiry_popup_display');
                    foreach ($fields['userSubType'] as &$detail) {
                        $detail = $config[$detail]['title'];
                    }
                }elseif(gettype($by) == 'App\User'){
                    $fields['userType'] = ['Contact Request'];
                }
                break;
            case '':
                # code...
                break;
            case '':
                # code...
                break;
            case '':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
