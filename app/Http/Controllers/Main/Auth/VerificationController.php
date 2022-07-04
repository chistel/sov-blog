<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           VerificationController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Auth;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\VerifyAction;
use App\Exceptions\Users\UnknownConfirmationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class VerificationController
 *
 * @package App\Http\Controllers\Main\Auth
 */
class VerificationController extends SystemController
{
    /**
     * VerificationController constructor.
     *
     * @param VerifyAction $verifyAction
     */
    public function __construct(protected VerifyAction $verifyAction)
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws InvalidArgumentException
     */
    public function processVerification(Request $request): RedirectResponse
    {
        // Load from POST or GET
        $confirmationToken = $request->get('confirmationToken', $request->route('confirmationToken'));

        try {
            $this->verifyAction->execute($confirmationToken);
        } catch (UnknownConfirmationException $exception) {
            logger()->error('Account verification error : ' . $exception);
            flash('Account verification failed')->error()->important();
            return redirect()->route('main.home');
        }

        return redirect()->route('main.account.dashboard');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showResendForm(Request $request)
    {
        return view($this->_config['view']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function processResend(Request $request): RedirectResponse
    {
    }
}
