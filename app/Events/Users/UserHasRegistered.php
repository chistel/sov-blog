<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           UserHasRegistered.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     24/02/2022, 1:24 PM
 */

namespace App\Events\Users;

use App\Models\Users\User;

class UserHasRegistered
{
    public function __construct(public User $user)
    {
    }
}
