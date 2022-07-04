<?php

namespace App\Listeners\Users;

use App\Events\Users\UserHasRegistered;
use App\Notifications\Users\VerifyEmail;
use App\Services\Tokens\Users\EmailConfirmation;
use Platform\Tokens\TokenManager;

class SendEmailVerificationNotification
{
    public function __construct(protected TokenManager $tokenManager)
    {
    }

    /**
     * @param UserHasRegistered $event
     */
    public function handle(UserHasRegistered $event)
    {
        $user = $event->user;
        if (!$user->hasVerifiedEmail()) {
            // Generate confirmation notification
            $token = $this->tokenManager->create(new EmailConfirmation($user->id));
            $user->notify(new VerifyEmail($token));
        }
    }
}
