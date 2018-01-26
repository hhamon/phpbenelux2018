<?php

namespace App\LockerManagement;

class AccessCodeGenerator
{
    public function generate(int $length = 7): string
    {
        return substr(sha1(uniqid()), 0, $length);
    }
}