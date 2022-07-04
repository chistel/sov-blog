<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           SystemController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Abstracts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Class SystemController
 *
 * @package App\Abstracts\Http\Controllers
 */
class SystemController extends Controller
{
    /**
     * @var array|Application|Request|string
     */
    protected $_config;

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }
}
