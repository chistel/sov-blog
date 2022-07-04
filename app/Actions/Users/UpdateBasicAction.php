<?php

namespace App\Actions\Users;

use App\Models\Users\User;

class UpdateBasicAction
{
    public function execute(User $user, array $data = [])
    {
        $user->update($data);
    }
}
