<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           LoginRateLimiter.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 12:53 AM
 */

namespace App\Services\Authentication;

use App\Exceptions\Users\InvalidAuthenticationCredentialsException;
use App\Exceptions\Users\TooManyAttempts;
use App\Models\Users\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginRateLimiter
{
    /**
     * Create a new login rate limiter instance.
     *
     * @param RateLimiter $limiter
     * @param int $maxAttempts
     * @param int $lockDuration
     */
    public function __construct(
        protected RateLimiter $limiter,
        protected int $maxAttempts,
        protected int $lockDuration
    ) {
    }

    /**
     * Get the number of attempts for the given key.
     *
     * @param Request $request
     * @return mixed
     */
    public function attempts(Request $request)
    {
        return $this->limiter->attempts($this->throttleKey($request));
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param string $login
     * @return bool
     */
    public function tooManyAttempts(string $login): bool
    {
        return $this->limiter->tooManyAttempts($this->throttleKey($login), $this->maxAttempts);
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param string $login
     * @return void
     * @throws TooManyAttempts
     */
    public function increment(string $login): void
    {
        $this->checkAttempts($login);

        $this->limiter->hit($login, $this->lockDuration);
    }

    /**
     * Determine the number of seconds until logging in is available again.
     *
     * @param string $login
     * @return int
     */
    public function availableIn(string $login): int
    {
        return $this->limiter->availableIn($this->throttleKey($login));
    }

    /**
     * @param string $login
     * @throws InvalidAuthenticationCredentialsException
     * @throws TooManyAttempts
     */
    public function invalidCredentials(string $login): void
    {
        $this->checkAttempts($login);

        $remaining = $this->limiter->retriesLeft($this->throttleKey($login), $this->maxAttempts);

        throw InvalidAuthenticationCredentialsException::fromAttemptsRemaining($remaining);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param string $login
     * @return void
     */
    public function resetLoginCount(string $login): void
    {
        $this->limiter->clear($this->throttleKey($login));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param string $login
     * @return string
     */
    protected function throttleKey(string $login): string
    {
        return Str::transliterate(Str::lower($login) . '|' . request()->ip());
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userLocked(User $user): bool
    {
        return ($user->email && $this->limiter->tooManyAttempts($user->email, $this->maxAttempts))
            || ($user->phone_number && $this->limiter->tooManyAttempts($user->phone_number, $this->maxAttempts));
    }

    /**
     * @param string $login
     * @throws TooManyAttempts
     */
    private function checkAttempts(string $login): void
    {
        if ($this->limiter->tooManyAttempts($login, $this->maxAttempts)) {
            throw new TooManyAttempts;
        }
    }
}
