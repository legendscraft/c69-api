<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $xmessage;
    public $title;
    public $attachment_path;

    /**
     * Create a new message instance.+
     *
     * @return void
     */
    public function __construct($title,$name,$xmessage,$attachment_path)
    {
        $this->name = $name;
        $this->xmessage = $xmessage;
        $this->title = $title;
        $this->attachment_path = $attachment_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('mail.report')
            ->attach($this->attachment_path, [
                'mime' => 'application/pdf',
            ]);
    }
}
