<?php
namespace App\Events\Users;

use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class EmailWasChanged
{
    use SerializesModels;

    public function __construct(public User $user)
    {
    }
}
