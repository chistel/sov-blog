<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           EloquentUserRepository.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 12:48 AM
 */

namespace App\Repositories\Articles;

use App\Contracts\Repositories\Articles\ArticleRepository;
use App\Models\Article;
use App\Services\Database\Eloquent\Repository;

class EloquentArticleRepository extends Repository implements ArticleRepository
{
    /**
     * Make sure we assign the required model.
     *
     * @param Article $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }
}
