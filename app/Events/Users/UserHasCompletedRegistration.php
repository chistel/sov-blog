<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           UserHasCompletedRegistration.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     03/02/2022, 9:22 PM
 */

namespace App\Events\Users;

use App\Models\Users\User;

class UserHasCompletedRegistration
{
    public function __construct(public User $user)
    {
    }
}
