<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                 Expert Market
 * @file                           Repository.php
 * @author                  Chistel Brown(chistelbrown@gmail.com, me@chistel.com)
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     27/04/2022, 5:54 PM
 */

namespace App\Services\Database\Eloquent;

use App\Services\Database\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository extends \Platform\Database\Eloquent\Repository implements RepositoryContract
{
    /**
     * @inheritdoc
     */
    public function getNew(array $data = []): Model
    {
        return $this->model->newInstance($data);
    }


    /**
     * Return a new query object to be executed.
     *
     * @return Builder|mixed
     */
    protected function getQuery()
    {
        return $this->model->newInstance()->newQuery();
    }

    /**
     * Return the full records, or a list of values if $list is provided.
     * If $list is null, will use get()
     * If $list is string, will use lists('string')
     * if $list is array, will use lists($list[0], $list[1])
     *
     * @param \Illuminate\Database\Query\Builder|Builder $query
     * @param string|array $list
     * @return \Illuminate\Support\Collection
     */
    protected function getOrList($query, $list = null)
    {
        if (!$list) {
            return $query->get();
        }

        if (is_string($list)) {
            return $query->pluck($list);
        }

        return $query->pluck($list[0], $list[1]);
    }

    /**
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     * @return Model
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Model
    {
        return $this->getQuery()->select($columns)->with($relations)->where($criteria)->firstOrFail();
    }

    /**
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     * @return Collection
     */
    public function getByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->getQuery()->select($columns)->with($relations)->where($criteria)->get();
    }
}
