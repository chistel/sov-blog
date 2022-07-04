<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanUpdateOrDeleteArticle
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $article = $request->article;
        $user = $request->user();
        if ($article && $article->user_id == $user->id) {
            return $next($request);
        }
        abort(404);

    }
}
