<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * @param Request $request
     * @param array $guards
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->ownRedirectTo($request, $guards)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param $request
     * @param array $guards
     * @return string
     */
    protected function ownRedirectTo($request, array $guards)
    {
        if (!$request->expectsJson()) {
            if (in_array('user', $guards) && !auth('user')->check()) {
                return route('main.home', ['redirect_to' => request()->fullUrl()]);
            }
            return route('main.home', ['redirect_to' => request()->fullUrl()]);
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
