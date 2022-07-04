<?php

namespace App\Actions\Article;

use App\Models\Article;

class EditArticleAction
{
    /**
     * @param Article $article
     * @param array $data
     * @return bool
     */
    public function execute(Article $article, array $data): bool
    {
        try {
            $article->update($data);
            return true;
        } catch (\Exception $exception) {
            logger()->error('Updating article error : ' . $exception);
            return false;
        }
    }
}
