<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           UserCreated.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     13/06/2021, 1:46 PM
 */

namespace App\Events\Users;

use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class UserWasAdded
{
    use SerializesModels;

    /**
     * UserWasAdded constructor.
     *
     * @param User $user
     */
    public function __construct(public User $user)
    {
    }
}
