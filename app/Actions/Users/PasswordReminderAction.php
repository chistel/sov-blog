<?php

namespace App\Actions\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Notifications\Users\ResetPasswordNotification;
use App\Services\Tokens\Users\ResetPassword;
use Platform\Tokens\TokenManager;

class PasswordReminderAction
{
    public function __construct(protected UserRepository $userRepository, protected TokenManager $tokenManager)
    {
    }

    /**
     * @param string $identity
     * @return bool|void
     */
    public function execute(string $identity)
    {
        $user = $this->userRepository->getByEmail($identity);
        if (!$user) {
            return;
        }

        $token = $this->tokenManager->create(new ResetPassword($user->id));

        try {
            $user->notify(new ResetPasswordNotification($token));
            return true;
        } catch (\Exception $exception) {
            logger()->error('Password reminder error : ' . $exception);
            return false;
        }
    }
}
