<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           PasswordController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Account;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\UpdatePasswordAction;
use App\Http\Requests\Main\Account\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Class PasswordController
 *
 * @package App\Http\Controllers\Main\Account
 */
class PasswordController extends SystemController
{
    /**
     * PasswordController constructor.
     *
     * @param UpdatePasswordAction $updatePasswordAction
     */
    public function __construct(protected UpdatePasswordAction $updatePasswordAction)
    {
        parent::__construct();
    }

    /**
     * @param UpdatePasswordRequest $updatePasswordRequest
     * @return RedirectResponse
     */
    public function processPassword(UpdatePasswordRequest $updatePasswordRequest): RedirectResponse
    {
        try {
            $this->updatePasswordAction->execute($updatePasswordRequest->user(), $updatePasswordRequest->password);
            flash('Basic information successfully updated')->success();
            return redirect()->route('main.account.manage.basic');
        } catch (\Exception $exception) {
            logger()->error('User profile update error : ' . $exception);
            flash('Basic information could not be updated, please try again')->error();
            return redirect()->route('main.account.manage.basic');
        }
    }
}
