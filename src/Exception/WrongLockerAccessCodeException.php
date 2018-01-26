<?php

namespace App\Exception;

use App\Entity\Locker;

class WrongLockerAccessCodeException extends \DomainException
{
    public function __construct(string $message = '', \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function forLocker(Locker $locker, \Throwable $previous = null): self
    {
        return new self(sprintf('Invalid presented access code for locker "%s".', $locker->getNumber()), $previous);
    }
}