<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TwoFactorCodeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
         $user = $event->user;

    if ($user->email_verified_at) { 
        $user->generateTwoFactorCode();

        // Send email
        \Mail::send('emails.twofactor', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('CristalGrade Verification Code');
        });

    }
    }
}
