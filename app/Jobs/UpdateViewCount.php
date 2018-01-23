<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Analytics;
use App\Listing;
use Spatie\Analytics\Period;
use App\Http\Controllers\ListingController;
use Carbon\Carbon;
use Log;

class UpdateViewCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startIndex;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startIndex)
    {
        $this->startIndex = $startIndex;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $response = Analytics::performQuery(
                Period::months(6),
                'ga:pageviews',
                [
                    'dimensions'=>'ga:pagepathlevel2',
                    'max-results' =>config('analytics.page-size'),
                    'start-index' => $this->startIndex,
                ]
            );
            $views = collect($response['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'slug' => substr($dateRow[0], 1),
                    'views' => (int) $dateRow[1],
                ];
            })->pluck('views','slug')->toArray();
            // Log::info($views);
            $listings = Listing::where('status',1)->whereIn('slug',array_keys($views))->get();
            foreach ($listings as $listing) {
                $lc = new ListingController;
                $stats = $lc->getListingStats($listing,Carbon::now()->subMonth()->toDateString(),Carbon::now()->toDateString());
                $listing->contact_request_count = $stats['contact'];
                $listing->enquiries_count = $stats['direct'] + $stats['shared'];
                if(isset($views[$listing->slug])){
                    $listing->views_count = $views[$listing->slug];  
                }
                $listing->save();            
            }
            if($response->nextLink != null){
                self::dispatch($this->startIndex + config('analytics.page-size'))->delay(now()->addMinutes(1))->onQueue('low');
            }
        }catch(\Exception $e){
            Log::error($e->message);
        }
    }
}
