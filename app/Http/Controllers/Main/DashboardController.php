<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           DashboardController.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     05/02/2022, 1:13 AM
 */

namespace App\Http\Controllers\Main;

use App\Abstracts\Http\Controllers\SystemController;
use App\Contracts\Repositories\Articles\ArticleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Main\Account
 */
class DashboardController extends SystemController
{
    public function __construct(protected ArticleRepository $articleRepository)
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $articles = $this->articleRepository->getAll()
                        ->paginate(5)
                            ->withPath(route('main.account.dashboard'));

        return view($this->_config['view'], compact('articles'));
    }
}
