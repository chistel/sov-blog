<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           UserRepository.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     02/02/2022, 3:07 PM
 */

namespace App\Contracts\Repositories\Users;

use App\Models\Users\User;
use Platform\Database\Contracts\RepositoryContract;

interface UserRepository extends RepositoryContract
{

    /**
     * Should return a user object based on the email address.
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail($email): ?User;

    /**
     * Retrieve all user records that match the emails provided.
     *
     * @param array $emails
     * @return mixed
     */
    public function getAllByEmails(array $emails);

    /**
     * @param User $user
     * @return mixed
     */
    public function refreshUser(User $user);
}
