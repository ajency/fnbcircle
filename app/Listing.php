<?php

namespace App;

use App\Listing;
use App\ListingCategory;
use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;
use Conner\Tagging\Model\Tagged;
use Conner\Tagging\Model\TagGroup;
use Ajency\FileUpload\FileUpload;
use Carbon\Carbon;
use Auth;

class Listing extends Model
{
    const PUBLISHED    = 1;
    const REVIEW       = 2;
    const DRAFT        = 3;
    const ARCHIVED     = 4;
    const REJECTED     = 5;

    const WHOLESALER   = 11;
    const RETAILER     = 12;
    const MANUFACTURER = 13;
    const IMPORTER = 14;
    const EXPORTER = 15;
    const SERVICEPROVIDER = 16;

    use Taggable;
    use FileUpload;

    protected $table = "listings";

    protected $fillable = ['title', 'status', 'type'];
    protected $dates = [
        'created_at',
        'updated_at',
        'published_on',
        'submission_date'
    ];

    public function owner()
    {
        return $this->hasOne('App\User', 'id' ,'owner_id');
    }
    public function lastUpdatedBy()
    {
        return $this->hasOne('App\User','id', 'last_updated_by');
    }
    public function createdBy()
    {
        return $this->hasOne('App\User', 'created_by');
    }
    public function location()
    {
        return $this->hasOne('App\Area','id', 'locality_id');
    }
    public function updates()
    {
        return $this->hasMany('App\Update', 'listing_id');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\ListingCategory');
    }
    public function operationAreas()
    {
        return $this->belongsToMany('App\Area')->using('App\ListingAreasOfOperation');
    }
    public function contacts()
    {
        return $this->morphMany('App\UserCommunication','object');
    }
    public function operationTimings()
    {
        return $this->hasMany('App\ListingOperationTime');
    }
    public function isReviewable()
    {
        if (!empty($this->title) and !empty($this->type) and !empty($this->locality_id)) {
            $category = ListingCategory::where('listing_id', $this->id)->count();
            if ($category < 1) {
                return false;
            }

            return true;
        } else {
            return false;
        }

    }

    public function saveInformation($title, $type, $email, $area)
    {
        $slug  = str_slug($title);
        $count = Listing::where('slug', $slug)->count();
        $i     = 1;
        $slug1 = $slug;
        if ($count > 0) {
            do {
                $slug1 = $slug . '-' . $i;
                $count = Listing::where('slug', $slug1)->count();
                $i++;
            } while ($count > 0);
        }

        $this->title = $title;
        $this->type  = $type;
        if ($this->status != "1") {
            $this->slug = $slug1;
        }

        $this->show_primary_email = $email;
        $this->locality_id        = $area;
        if ($this->status == null) {
            $this->status = self::DRAFT;
        }

        
        if ($this->reference == null) {
            // $this->reference = str_random(8);
            $this->reference = generateRefernceId($this,'reference');
        }

        if ($this->created_by == null) {
            $this->created_by = Auth::user()->id;
            $this->owner_id = Auth::user()->id;
        }

        $this->save();
    }

    public static function existingTagsLike($group,$str)
     {
        $groups = TagGroup::where('slug',$group)->get();
        $group=$groups[0];
        return Tagged::distinct()
            ->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
            ->where('taggable_type', '=', (new static)->getMorphClass())
            ->where('tag_group_id',$group->id)
            ->where('tag_name','like', title_case($str).'%')
            ->orderBy('tag_slug', 'ASC')
            ->get(array('tag_slug as slug', 'tag_name as name', 'tagging_tags.count as count'));
     }

    public function save(array $options = []){
        $this->last_updated_by = Auth::user()->id;
        parent::save();
    }

    public function getHoursofOperation(){
        $opHrs = $this->operationTimings()->get();
        $week = [
            '0' => ['day' => 'Monday'],
            '1' => ['day' => 'Tuesday'],
            '2' => ['day' => 'Wednesday'],
            '3' => ['day' => 'Thursday'],
            '4' => ['day' => 'Friday'],
            '5' => ['day' => 'Saturday'],
            '6' => ['day' => 'Sunday'],
        ];
        foreach($opHrs as $day){
            $week[$day->day_of_week]['timing'] = substr($day->from,0,-3).' to '.substr($day->to,0,-3);
            $week[$day->day_of_week]['from'] = $day->from;
            $week[$day->day_of_week]['to'] = $day->to;
            if($day->closed == 1) $week[$day->day_of_week]['timing'] = 'Closed';
            if($day->open24 == 1) $week[$day->day_of_week]['timing'] = 'Open 24 Hours';
        }
        return $week;
    }

    public function today(){
        $carbon = new Carbon();
        $day = $this->operationTimings()->where('day_of_week',$carbon->dayOfWeek)->first();
        if($day == null) return false;
        $timing = substr($day->from,0,-3).' to '.substr($day->to,0,-3);
        if($day->closed == 1) { $timing = 'Closed'; $open = false; }
        elseif($day->open24 == 1) { $timing = 'Open 24 Hours'; $open = true; }
        else {
            $from = Carbon::createFromFormat('H:i:s',$day->from);
            $to = Carbon::createFromFormat('H:i:s',$day->to);
            if($from < $carbon and $carbon < $to){
                $open = true;
            }else{
                $open = false;
            }
        }
        return ['timing'=>$timing, 'open'=>$open];
    }
    public function getPayments(){
        $payments = [];
        if($this->payment_modes == null) return null;
        $modes =json_decode($this->payment_modes);
        $mode_name=[
            "visa" => "Visa Cards",
            "debit" => "Debit Cards",
            "money_order" => "Money Order",
            "cheque" => "Cheque",
            "credit" => "Credit Cards",
            "travelers" => "Travelers Cheque",
            "cash" => "Cash",
            "master" => "Master Cards",
            "diners" => "Diner's Cards",
        ];
        foreach ($modes as $mode => $value) {
             if($value == '1') $payments[] = $mode_name[$mode];
         }
         $payments = array_merge($payments,$this->tagNames('payment-modes'));
         return $payments;
    }

}
