<?php
namespace App\Events\Users;

use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class UserWasConfirmed
{
    use SerializesModels;

    public function __construct(public User $user, public bool $sync)
    {
    }
}
