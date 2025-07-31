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
        \Mail::raw("Your CristalGrade 2FA code is: {$user->two_factor_code}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your 2FA Code');
        });
    }
    }
}
