<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           UserAuthenticated.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     03/02/2022, 2:01 PM
 */

namespace App\Events\Users;

use App\Models\Users\User;

class UserAuthenticated
{
    public function __construct(public User $user)
    {
    }
}
