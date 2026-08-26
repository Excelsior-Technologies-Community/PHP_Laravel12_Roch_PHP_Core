<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $type;

    public function __construct($user, $type = 'created')
    {
        $this->user = $user;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        $subject = $this->type === 'created'
            ? __('messages.new_user_subject')
            : __('messages.updated_user_subject');

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notification',
        );
    }
}
