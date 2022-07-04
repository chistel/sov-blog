<?php

namespace App\Http\Controllers\Main\Article;

use App\Abstracts\Http\Controllers\SystemController;
use App\Actions\Article\CreateArticleAction;
use App\Actions\Article\EditArticleAction;
use App\Http\Requests\Article\ArticleRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ManageArticleController extends SystemController
{
    public function __construct(
        private CreateArticleAction $createArticleAction,
        private EditArticleAction $editArticleAction
    ) {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function createForm(Request $request)
    {
        $actionUrl = route('main.articles.new');
        return view($this->_config['view'], compact('actionUrl'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function editForm(Request $request)
    {
        $article = $request->article;
        $actionUrl = route('main.articles.single.edit', ['article' => $article->uuid]);
        return view($this->_config['view'], compact('article', 'actionUrl'));
    }

    /**
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        if ($this->createArticleAction->execute($request->user(), $request->validated())) {
            flash('Article saved successfully')->success();
            return redirect()->route('main.account.dashboard');
        }
        flash('Article could not be saved')->error();
        return redirect()->route('main.article.new')->withInput();
    }

    /**
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function update(ArticleRequest $request): RedirectResponse
    {
        if ($this->editArticleAction->execute($article = $request->article, $request->validated())) {
            flash('Article updated successfully ')->success();
            return redirect()->route('main.articles.single.edit', ['article' => $article->uuid]);
        }
        flash('Article could not be updated')->error();
        return redirect()->route('main.articles.single.edit', ['article' => $article->uuid]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        $request->article->delete();
        flash('Article deleted successfully')->success();
        return redirect()->route('main.account.dashboard');
    }
}
