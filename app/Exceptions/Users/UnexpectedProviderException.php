<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                 Expert Market
 * @file                           UnexpectedProviderException.php
 * @author                  Chistel Brown(chistelbrown@gmail.com, me@chistel.com)
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     27/04/2022, 5:49 PM
 */

namespace App\Exceptions\Users;

use Throwable;
use UnexpectedValueException;

class UnexpectedProviderException extends UnexpectedValueException
{
    public function __construct(string $message, Throwable $e = null)
    {
        parent::__construct($message, 0, $e);
    }
}
