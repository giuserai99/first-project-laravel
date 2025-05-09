<?php

namespace App\Jobs;

use App\Models\Address;
use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use function PHPSTORM_META\map;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $mailId) {}

    public function handle()
    {

        $email = Mail::with('addresses')->where('id', $this->mailId)->first();

        //dd($email->addresses);
        $recipients = $email->addresses->map(function ($recipient) {
            return $recipient->email_to;
        });
        //dd($addresses);
        dump('Id: ' . $email->id . ' subject: ' . $email->subject . ' body: ' . $email->body . ' receivers: ' . $recipients);
    }
}
