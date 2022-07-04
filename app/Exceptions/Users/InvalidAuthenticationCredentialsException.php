<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           InvalidAuthenticationCredentialsException.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     04/02/2022, 11:33 AM
 */

namespace App\Exceptions\Users;

use Exception;

class InvalidAuthenticationCredentialsException extends Exception
{
    /** @var int */
    private int $attemptsRemaining;

    protected $message = 'The login credentials you provided are invalid.';

    public static function fromAttemptsRemaining(int $attemptsRemaining)
    {
        $exception = new static;
        $exception->attemptsRemaining = $attemptsRemaining;

        return $exception;
    }

    public function attemptsRemaining(): int
    {
        return $this->attemptsRemaining ?: 0;
    }
}
