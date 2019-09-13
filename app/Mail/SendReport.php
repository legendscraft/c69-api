<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $message;
    public $title;
    public $attachment_path;

    /**
     * Create a new message instance.+
     *
     * @return void
     */
    public function __construct($title,$name,$message,$attachment_path)
    {
        $this->name = $name;
        $this->message = $message;
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
