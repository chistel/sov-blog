<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           PasswordWasChanged.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     03/02/2022, 9:21 PM
 */
namespace App\Events\Users;

use App\Models\Users\User;

class PasswordWasChanged
{
    public function __construct(public User $user)
    {
    }
}
