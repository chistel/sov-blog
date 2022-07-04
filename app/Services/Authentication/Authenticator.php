<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           Authenticator.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     03/02/2022, 9:27 PM
 */

namespace App\Services\Authentication;

use App\Contracts\Repositories\Users\UserRepository;
use App\Events\Users\UserAuthenticated;
use App\Models\Users\User;
use Illuminate\Contracts\Auth\Guard as Auth;
use Platform\Tokens\TokenManager;

class Authenticator
{
    public function __construct(
        protected Auth $auth,
        protected UserRepository $userRepository,
        protected LoginRateLimiter $loginLimiter,
        protected TokenManager $tokens,
    ) {
    }

    /**
     * @param User $user
     * @param bool $remember
     */
    public function login(
        User $user,
        bool $remember = false
    ) {
        $this->auth->login($user, $remember);

        $user->raise(new UserAuthenticated($user));
    }
}
