<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUserRegistered extends Mailable
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): static
    {
        return $this->subject('User Baru Terdaftar')
                    ->view('emails.new-user-registered');
    }
}
