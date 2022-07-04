<?php

namespace App\Http\Controllers\Main\Article;

use App\Abstracts\Http\Controllers\SystemController;
use App\Models\Article;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends SystemController
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function single(Request $request)
    {
        $article = $request->article;

        return view($this->_config['view'], compact('article'));
    }
}
