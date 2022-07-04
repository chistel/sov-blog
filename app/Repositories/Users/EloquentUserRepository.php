<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           EloquentUserRepository.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 12:48 AM
 */

namespace App\Repositories\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Exceptions\Users\UserDoesNotExist;
use App\Models\Users\User;
use App\Services\Database\Eloquent\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository extends Repository implements UserRepository
{
    /**
     * Make sure we assign the required model.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    /**
     * Retrieve a user based on the email. This is also restricted by the current account. If
     * no user exists by that email address that is also associated with the account,
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail($email): ?User
    {
        return $this->getBy('email', $email)->first();
    }

    /**
     * Retrieve all user records that match the emails provided.
     *
     * @param array $emails
     * @return mixed
     */
    public function getAllByEmails(array $emails)
    {
        return $this->getQuery()
            ->whereIn('email', $emails)
            ->get();
    }

    /**
     * Return a single model object based on its url uuid value.
     *
     * @param $uuid
     * @return null
     */
    public function getByUuid($uuid)
    {
        return $this->getByQuery('uuid', $uuid)
            ->first();
    }

    /**
     * @param $email
     * @param $password
     * @return User|false
     */
    public function checkCredentials($email, $password): User|bool
    {
        $user = $this->getByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }
        return $user;
    }

    /**
     * Grab local user if it exists OR
     * Generate local user from user data from another shard OR
     * Generate local user from command
     *
     * @param $email
     * @param $createdBy
     * @return User|null
     * @throws UserDoesNotExist
     */
    public function requireUser($email, $createdBy): ?User
    {
        if ($user = $this->getByEmail($email)) {
            return $user;
        }

        throw new UserDoesNotExist;
    }

    /**
     * Returns a collection of models given an array of IDs.
     *
     * @param array $ids
     * @param bool $order
     * @return Collection
     */
    public function getByIds(array $ids, bool $order = false): Collection
    {
        $query = $this->getQuery()->whereIn('id', $ids);

        if ($order) {
            $query->orderBy('first_name', 'asc')
                ->orderBy('last_name', 'asc');
        }

        return $query->get();
    }

    /**
     * Search by name, return query object.
     *
     * @param Builder $query
     * @param string $name
     * @return Builder
     */
    private function searchByName(Builder $query, string $name): Builder
    {
        return $query->where(function ($query) use ($name) {
            // Split the name so we can do more specific searches
            $splitName = explode(' ', $name);
            $splitNameCount = count($splitName);
            if ($splitNameCount === 1) {
                $query->orWhere('first_name', 'LIKE', '%' . $splitName[0] . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $splitName[0] . '%');
            } elseif ($splitNameCount === 2) {
                $query->where(function ($query) use ($splitName) {
                    $query->where('first_name', 'LIKE', '%' . $splitName[0] . '%')
                        ->where('last_name', 'LIKE', '%' . $splitName[1] . '%');
                })->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", '%' . $name . '%');
            } else {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", '%' . $name . '%');
            }
        });
    }

    /**
     * @param User $user
     * @return User
     */
    public function refreshUser(User $user): User
    {
        return $user->refresh();
    }
}
