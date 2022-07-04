<?php

namespace App\Actions\Article;

use App\Models\Users\User;
use Exception;

class CreateArticleAction
{
    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function execute(User $user, array $data): bool
    {
        try {
            $user->articles()->create($data);
            return true;
        } catch (Exception $exception) {
            logger()->error('creating article error : ' . $exception);
            return false;
        }
    }
}
