<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           LoginController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Auth;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\LoginAction;
use App\Exceptions\Users\InvalidAuthenticationCredentialsException;
use App\Exceptions\Users\TooManyAttempts;
use App\Http\Requests\Main\Auth\LoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends SystemController
{
    public function __construct(protected LoginAction $loginAction)
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function loginForm(Request $request): Factory|View|Application
    {
        return view($this->_config['view']);
    }

    /**
     * @param LoginRequest $loginRequest
     * @return RedirectResponse
     */
    public function processLogin(LoginRequest $loginRequest): RedirectResponse
    {
        $duration = config('auth.temporary_lock.duration');
        try {
            $this->loginAction->execute($loginRequest->identity, $loginRequest->password);
            return redirect()->route('main.account.dashboard');
        } catch (\Exception $exception) {
            if ($exception instanceof TooManyAttempts) {
                flash('Your account has been locked for ' . $duration . ' minutes due to too many failed log in attempts.')->error();
            } elseif ($exception instanceof InvalidAuthenticationCredentialsException) {
                $attemptsRemaining = $exception->attemptsRemaining();
                $message = 'Those log in details are incorrect.';

                if ($attemptsRemaining && $attemptsRemaining <= 3) {
                    $message .= ' ' . $attemptsRemaining . ' log in attempts remaining until your account is locked.';
                }
                flash($message)->error();
            }else{
                flash('Invalid login detail')->error();
            }

            return redirect()->route('main.home');
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        auth('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('main.home');
    }
}
