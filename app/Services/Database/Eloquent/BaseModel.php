<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                 Expert Market
 * @file                           BaseModel.php
 * @author                  Chistel Brown(chistelbrown@gmail.com, me@chistel.com)
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     27/04/2022, 5:54 PM
 */

namespace App\Services\Database\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;
use Plank\Metable\Metable;
use Platform\Database\Eloquent\Model;
use Platform\Support\Traits\Common\Uuid;

abstract class BaseModel extends Model
{
    use HasFactory;
    use Metable;
    use Uuid;

    /**
     * @return array
     */
    protected function columns(): array
    {
        return Schema::getColumnListing($this->getTable());
    }

    /**
     * @param $query
     * @param array $value
     * @return mixed
     */
    public function scopeExclude($query, array $value = []): mixed
    {
        return $query->select(array_diff($this->columns(), $value));
    }


    /**
     * Save the model to the database, force the modification timestamp to be updated.
     *
     * @param array $options
     * @return bool
     */
    public function saveOrTouch(array $options = [])
    {
        if ($this->isDirty()) {
            return $this->save($options);
        }

        return $this->touch();
    }
}
