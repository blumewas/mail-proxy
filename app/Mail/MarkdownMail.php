<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarkdownMail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $mail_from;
    public $name;
    public $subject;

    public function __construct($body, $from, $subject)
    {
        $this->mail_from = config("addresses.{$from}.mail_from");
        $this->name = config("addresses.{$from}.name");

        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('mail.markdown', ['body' => $this->body])
            ->from($this->mail_from, $this->name);
    }

}
