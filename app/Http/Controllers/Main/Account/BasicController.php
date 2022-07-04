<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           BasicController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Http\Controllers\Main\Account;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Users\UpdateBasicAction;
use App\Http\Requests\Main\Account\UpdateBasicRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class BasicController
 *
 * @package App\Http\Controllers\Main\Account
 */
class BasicController extends SystemController
{
    /**
     * BasicController constructor.
     *
     * @param UpdateBasicAction $updateBasicAction
     */
    public function __construct(protected UpdateBasicAction $updateBasicAction)
    {
        parent::__construct();
    }

    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        return view($this->_config['view']);
    }

    /**
     * @param UpdateBasicRequest $basicRequest
     * @return RedirectResponse
     */
    public function processBasic(UpdateBasicRequest $basicRequest): RedirectResponse
    {
        try {
            $this->updateBasicAction->execute($basicRequest->user(), $basicRequest->except(['password']));
            flash('Basic information successfully updated')->success();
            return redirect()->route('main.account.manage.basic');
        } catch (\Exception $exception) {
            logger()->error('User profile update error : ' . $exception);
            flash('Basic information could not be updated, please try again')->error();
            return redirect()->route('main.account.manage.basic');
        }
    }

}
