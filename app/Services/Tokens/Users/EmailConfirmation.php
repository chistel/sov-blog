<?php

namespace App\Services\Tokens\Users;

use Platform\Tokens\StringToken;
use Platform\Tokens\Token;

class EmailConfirmation implements Token
{
    use StringToken;

    /**
     * EmailChannelConfirmation constructor.
     *
     * @param int $userId
     */
    public function __construct(public int $userId)
    {
    }

    /**
     * The number of minutes until the token expires.
     *
     * @return int
     */
    public function expires(): int
    {
        return 60 * 24; // expire in 24 hours
    }
}
