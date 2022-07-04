<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                 Expert Market
 * @file                           RepositoryContract.php
 * @author                  Chistel Brown(chistelbrown@gmail.com, me@chistel.com)
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     27/04/2022, 5:54 PM
 */

namespace App\Services\Database\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryContract extends \Platform\Database\Contracts\RepositoryContract
{
    /**
     * Create a resource based on the data provided.
     *
     * @param array $data
     * @return Model
     */
    public function getNew(array $data = []): Model;

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Model;

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Collection;

}
