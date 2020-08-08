<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyYourEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('E-mail Verification Code')
            ->view('emails.api_email_verification')
            ->with(['token' => $this->user->api_verification_code]);
    }
}
