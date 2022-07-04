<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           FormRequest.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\Abstracts\Http;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Support\Arr;

abstract class FormRequest extends BaseFormRequest
{
   /**
    * Determine if the given offset exists.
    *
    * @param string $offset
    * @return bool
    */
   public function offsetExists($offset): bool
   {
      return Arr::has(
         $this->route() ? $this->all() + $this->route()->parameters() : $this->all(),
         $offset
      );
   }
}
