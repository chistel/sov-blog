<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           RegisterController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Auth;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\RegisterAction;
use App\Http\Requests\Main\Auth\RegisterRequest;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Main\Auth
 */
class RegisterController extends SystemController
{
    public function __construct(protected RegisterAction $registerAction)
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function registerForm(Request $request): Application|Factory|View
    {
        return view($this->_config['view']);
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return RedirectResponse
     */
    public function processRegistration(RegisterRequest $registerRequest)
    {
        try {
            $this->registerAction->execute($registerRequest);
            return redirect()->route('main.account.dashboard');
        } catch (\Exception $exception) {
            logger()->error('User reg error : ' . $exception);
            flash('Registration was not successful, please try again')->error()->important();
            return redirect()->route('main.register.form')->withInput();
        }
    }
}
