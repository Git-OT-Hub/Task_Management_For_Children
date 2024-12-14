<?php

namespace App\Services;

use Illuminate\Support\Str;
use OutOfRangeException;

class TestService
{
    public static array $cached = [];

    public function get(int $length)
    {
        if ($length < 1 || $length > 100) {
            throw new OutOfRangeException('文字数は1から100の間で指定してください');
        }

        if (isset(self::$cached[$length])) {
            return self::$cached[$length];
        }

        return self::$cached[$length] = Str::random($length);
    }
}
