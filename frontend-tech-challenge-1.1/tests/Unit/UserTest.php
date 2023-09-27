<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUsers()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    public function testHome()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
