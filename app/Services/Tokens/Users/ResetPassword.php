<?php

namespace App\Services\Tokens\Users;

use Platform\Tokens\StringToken;
use Platform\Tokens\Token;

class ResetPassword implements Token
{
    use StringToken;

    private const EXPIRE_DAY = 1440;
    private const EXPIRE_WEEK = 10080;

    /**
     * @param int $userId
     * @param int $expiry Expire in 24 hours by default (60 minutes * 24 hours)
     * @param string|null $redirect
     */
    public function __construct(
        protected int $userId,
        protected int $expiry = self::EXPIRE_DAY,
        protected string|null $redirect = null
    ) {
    }

    /**
     * @return int
     */
    public function userId(): int
    {
        return $this->userId;
    }

    /**
     * The number of minutes until the token expires.
     *
     * @return int
     */
    public function expires(): int
    {
        return $this->expiry;
    }

    /**
     * @return string|null
     */
    public function redirect(): ?string
    {
        return $this->redirect;
    }
}
