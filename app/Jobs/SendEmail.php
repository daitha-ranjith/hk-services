<?php

namespace App\Jobs;

use Mail;
use App\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
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
        config([
            'mail.host' => $this->data['email']['params']['email_smtp_host'],
            'mail.port' => $this->data['email']['params']['email_smtp_port'],
            'mail.from.address' => $this->data['sender_email'],
            'mail.from.name' => $this->data['sender_name'],
            'mail.username' => $this->data['email']['params']['email_smtp_username'],
            'mail.password' => $this->data['email']['params']['email_smtp_password'],
        ]);

        $to_emails = array_filter(explode(',', $this->data['to']));
        $cc_emails = array_filter(explode(',', $this->data['cc']));
        $bcc_emails = array_filter(explode(',', $this->data['bcc']));
        $reply_to_emails = array_filter(explode(',', $this->data['reply_to']));
        $subject = $this->data['sender_name'];

        Mail::raw(
            $this->data['content'],
            function ($message) use (
                $to_emails,
                $cc_emails,
                $bcc_emails,
                $reply_to_emails,
                $subject
            ) {
            foreach ($to_emails as $email) {
                $message->to($email);
            }
            if ($cc_emails) {
                foreach ($cc_emails as $email) {
                    $message->cc($email);
                }
            }
            if ($bcc_emails) {
                foreach ($bcc_emails as $email) {
                    $message->bcc($email);
                }
            }
            if ($reply_to_emails) {
                foreach ($reply_to_emails as $email) {
                    $message->replyTo($email);
                }
            }
            $message->subject($subject);
        });

        EmailLog::create([
            'token_id' => $this->data['token']['id'],
            'email' => [
                'to' => $to_emails, 'cc' => $cc_emails, 'bcc' => $bcc_emails,
                'subject' => $subject, 'content' => $this->data['content'],
                'sender_name' => $this->data['sender_name'], 'sender_email' => $this->data['sender_email']
            ]
        ]);
    }

}
