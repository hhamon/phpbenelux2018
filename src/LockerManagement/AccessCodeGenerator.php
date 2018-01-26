<?php

namespace App\LockerManagement;

class AccessCodeGenerator
{
    public function generate(int $length = 7): string
    {
        return substr(sha1(random_bytes(32)), 0, $length);
    }
}