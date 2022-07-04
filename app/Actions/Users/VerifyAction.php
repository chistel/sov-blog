<?php

namespace App\Actions\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Exceptions\Users\UnknownConfirmationException;
use App\Services\Tokens\Users\EmailConfirmation;
use Platform\Tokens\TokenManager;
use Psr\SimpleCache\InvalidArgumentException;

class VerifyAction
{
    public function __construct(protected TokenManager $tokenManager, protected UserRepository $userRepository)
    {
    }

    /**
     * @param string $token
     * @return bool
     * @throws InvalidArgumentException
     * @throws UnknownConfirmationException
     */
    public function execute(string $token): bool
    {
        $emailToken = $this->tokenManager->has($token, EmailConfirmation::class);

        if (!$emailToken) {
            throw new UnknownConfirmationException;
        }

        $type = EmailConfirmation::class;
        $token = $this->tokenManager->pull($token, $type);

        if (($user = $this->userRepository->getById($token->userId)) && !$user->emailVerifiedAt) {

            $user->markEmailAsVerified();

            return true;
        }

        throw new UnknownConfirmationException;
    }
}
