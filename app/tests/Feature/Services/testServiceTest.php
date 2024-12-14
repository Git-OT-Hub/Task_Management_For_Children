<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use OutOfRangeException;

class testServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_exception_occurred_on_top_page(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(OutOfRangeException::class);

        $this->get('/');
    }

    public function test_global_1(): void
    {
        $this->get('/')
            ->assertOk();
    }

    public function test_global_2(): void
    {
        $this->get('')
            ->assertOk();
    }
}
