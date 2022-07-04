<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           LoginAction.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 1:01 AM
 */

namespace App\Actions\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Exceptions\Users\InvalidAuthenticationCredentialsException;
use App\Exceptions\Users\TooManyAttempts;
use App\Models\Users\User;
use App\Services\Authentication\Authenticator;
use App\Services\Authentication\LoginRateLimiter;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Platform\Database\Traits\EventDispatcher;

class LoginAction
{
    use EventDispatcher;

    public function __construct(
        protected UserRepository $userRepository,
        protected Authenticator $authenticator,
        protected LoginRateLimiter $loginRateLimiter,
        protected Request $request
    ) {
    }

    /**
     * @param string $login
     * @param string $password
     * @param bool $remember
     * @return User|bool
     * @throws BindingResolutionException
     * @throws InvalidAuthenticationCredentialsException
     * @throws TooManyAttempts
     */
    public function execute(string $login, string $password, bool $remember = false): User|bool
    {
        $this->loginRateLimiter->increment($login);

        $user = $this->userRepository->checkCredentials($login, $password);

        if (!$user) {
            $this->fireFailedEvent($login, $password);

            $this->loginRateLimiter->invalidCredentials($login);

            return false;
        }

        $this->authenticator->login($user, $remember);

        $this->request->session()->regenerate();

        $this->loginRateLimiter->resetLoginCount($login);

        Session::put('authentication.freshLogin', true);

        $this->dispatch($user->releaseEvents());

        return $user;
    }

    /**
     * Fire the failed authentication attempt event with the given arguments.
     *
     * @param $login
     * @param $password
     */
    protected function fireFailedEvent($login, $password): void
    {
        event(new Failed('user', null, [
            'identity' => $login,
            'password' => $password,
        ]));
    }
}
