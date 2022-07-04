<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           RetrievePasswordController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Auth;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\PasswordReminderAction;
use App\Actions\Users\ResetUserPasswordAction;
use App\Contracts\Repositories\Users\UserRepository;
use App\Exceptions\Users\TokenNotFoundException;
use App\Http\Requests\Main\Auth\PasswordReminderRequest;
use App\Http\Requests\Main\Auth\PasswordResetRequest;
use App\Services\Tokens\Users\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Platform\Tokens\TokenManager;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class RetrievePasswordController
 *
 * @package App\Http\Controllers\Main\Auth
 */
class RetrievePasswordController extends SystemController
{
    public function __construct(
        protected PasswordReminderAction $passwordReminderAction,
        protected ResetUserPasswordAction $resetUserPasswordAction,
        protected UserRepository $userRepository,
        protected TokenManager $tokenManager
    ) {
        parent::__construct();
    }

    /**
     * @return Application|Factory|View
     */
    public function requestForm(): View|Factory|Application
    {
        return view($this->_config['view']);
    }

    /**
     * @param PasswordReminderRequest $passwordReminderRequest
     * @return RedirectResponse
     */
    public function processRequest(PasswordReminderRequest $passwordReminderRequest): RedirectResponse
    {
        if ($this->passwordReminderAction->execute($passwordReminderRequest->identity)) {
            flash('We have e-mailed your reset password link.')->success();
            return redirect()->back();
        }

        flash('Seems like user is not found or there was an issue sending reset link')->error();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws InvalidArgumentException
     */
    public function resetForm(Request $request): View|Factory|RedirectResponse|Application
    {
        $token = $request->route('passwordResetToken');

        if (!$this->tokenManager->has($token, ResetPassword::class)) {
            flash('Unable to reset password, invalid password reset URL. Please confirm or resend the reset link to reset your password.')->error();
            return redirect()->route('main.password.reset-request');
        }

        return view($this->_config['view'], compact('token'));
    }

    /**
     * @param PasswordResetRequest $passwordResetRequest
     * @return RedirectResponse
     */
    public function processReset(PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        try {
            $redirect = $this->resetUserPasswordAction->execute($passwordResetRequest->token,
                $passwordResetRequest->password);
        } catch (TokenNotFoundException $e) {
            flash('Unable to reset password, invalid password reset URL. Please confirm or resend the reset link to reset your password.')->error();
            return redirect()->back();
        }

        flash('Password reset successful, you can now login')->success();
        return redirect($redirect ?? route($this->_config['redirect']));
    }
}
