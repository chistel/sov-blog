<?php

namespace App\Actions\Users;

use App\Models\Users\User;

class UpdatePasswordAction
{
    /**
     * @param User $user
     * @param string $password
     */
    public function execute(User $user, string $password)
    {
        $user->update(['password' => $password]);
    }
}
