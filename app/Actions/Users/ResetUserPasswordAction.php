<?php

namespace App\Actions\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Services\Tokens\Users\ResetPassword;
use Platform\Tokens\TokenManager;

class ResetUserPasswordAction
{
    public function __construct(protected UserRepository $userRepository, protected TokenManager $tokenManager)
    {
    }

    /**
     * @param string $token
     * @param string $password
     * @return string|null
     */
    public function execute(string $token, string $password): ?string
    {
        /** @var ResetPassword $token */
        $token = $this->tokenManager->pull($token, ResetPassword::class);

        if ($user = $this->userRepository->getById($token->userId())) {
            $user->update(['password' => $password]);
        }

        return $token->redirect();
    }
}
