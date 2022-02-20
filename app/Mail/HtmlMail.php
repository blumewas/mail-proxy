<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class HtmlMail extends Mailable
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

        $this->theme = 'default';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cssToInlineStyles = new CssToInlineStyles();

        $html = view('mail.html', ['body' => $this->body])->render();
        $css = file_get_contents(app('path') . '/../resources/views/vendor/mail/html/themes/default.css');

        $rendered = $cssToInlineStyles->convert(
            $html,
            $css
        );

        return $this
            ->html($rendered)
            ->from($this->mail_from, $this->name);
    }

}
