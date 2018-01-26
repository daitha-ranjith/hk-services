<?php

namespace App\Jobs;

use App\SmsLog;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client(
                        $this->data['sms']['params']['twilio_sms_account_sid'],
                        $this->data['sms']['params']['twilio_sms_auth_token']
                  );

        $response = $client->messages->create(
            $this->data['phone'],
            [
                'from' => $this->data['from'],
                'body' => $this->data['message'],
                'statusCallback' => 'https://a91b52ca.ngrok.io/api/sms/status/update'
            ]
        );

        preg_match('/sid=(.+?)]/', $response, $sid);

        SmsLog::create([
            'sid' => $sid[1],
            'token_id' => $this->data['token']['id'],
            'sent_to' => $this->data['phone'],
            'message' => $this->data['message'],
            'status' => 'queued',
            'characters' => strlen($this->data['message']),
            'sent_at' => Carbon::now(),
            'delivered_at' => null,
        ]);
    }
}
