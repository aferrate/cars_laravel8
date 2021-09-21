<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;

class CarsViewTest extends TestCase
{
    public function test_root()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ID');
        $response->assertSee('Mark');
        $response->assertSee('Model');
        $response->assertSee('Year');
        $response->assertSee('Last update');
        $response->assertSee('Photo');
    }

    public function test_admin_not_logged()
    {
        $response = $this->get('/admin');
        $response->assertStatus(403);
        $response->assertSee('User is not logged in.');
    }

    public function test_create_not_logged()
    {
        $response = $this->get('/admin/create');
        $response->assertStatus(403);
        $response->assertSee('User is not logged in.');
    }

    public function test_admin()
    {
        $this->withoutMiddleware();

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('ID');
        $response->assertSee('Mark');
        $response->assertSee('Model');
        $response->assertSee('Year');
        $response->assertSee('Published?');
        $response->assertSee('Last update');
        $response->assertSee('Country');
        $response->assertSee('City');
        $response->assertSee('Photo');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
    }
}
