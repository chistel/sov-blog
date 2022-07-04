<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           TokenNotFoundException.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 11:33 AM
 */

namespace App\Exceptions\Users;

use Illuminate\Auth\Access\AuthorizationException;

class TokenNotFoundException extends AuthorizationException
{
    /**
     * @var string
     */
    protected $message = 'Token not found.';
}
