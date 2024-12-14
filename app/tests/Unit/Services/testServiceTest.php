<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\TestService;
use OutOfRangeException;

class testServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_specified_number_of_characters(): void
    {
        $random = new TestService();

        $str5 = $random->get(5);
        $str10 = $random->get(10);

        $this->assertSame(5, strlen($str5));
        $this->assertSame(10, strlen($str10));
    }

    public function test_random_characters(): void
    {
        $random = new TestService();

        $str1 = $random->get(10);
        $str2 = $random->get(10);

        $this->assertFalse($str1 === $str2);
    }

    public function test_characters_exception_occurred(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('文字数は1から100の間で指定してください');

        $random = new TestService();
        $random->get(999);
    }

    public function test_strrandom2_a(): void
    {
        $random = new TestService();

        $str = $random->get(10);
        dump($str);

        $this->assertTrue(true);
    }

    public function test_strrandom2_b(): void
    {
        $random = new TestService();

        $str = $random->get(10);
        dump($str);

        $this->assertTrue(true);
    }
}
