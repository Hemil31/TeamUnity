<?php

namespace App\Jobs;

use App\Mail\RegisterCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData;
    /**
     * Create a new job instance.
     */
    public function __construct(array $mailData)
    {
        
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mailData['email'])->send(new RegisterCompany($this->mailData));
    }
}
