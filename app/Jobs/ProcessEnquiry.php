<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\EnquiryController;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProcessEnquiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $enquiry_data, $enquiry_sent, $listing_operation_ids, $send_email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($enquiry_data, $enquiry_sent, $listing_operation_ids, $send_email=false)
    {
        $this->enquiry_data = $enquiry_data;
        $this->enquiry_sent = $enquiry_sent;
        $this->listing_operation_ids = $listing_operation_ids;
        $this->send_email = $send_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = new ConsoleOutput;
        $enquiry_class_obj = new EnquiryController;
        try {
            $enquiry_class_obj->secondaryEnquiryQueue($this->enquiry_data, $this->enquiry_sent, $this->listing_operation_ids, $this->send_email);
        } catch (Exception $e) {
            $output->writeln("Failed " . $e->getMessage());
        }
    }
}
