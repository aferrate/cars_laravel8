<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Request;

class CarsViewTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_slug()
    {
        $response = $this->get('/car/60912a2089cd8');
        $response->assertStatus(200);
        $response->assertSee('ID');
        $response->assertSee('Mark');
        $response->assertSee('Model');
        $response->assertSee('Year');
        $response->assertSee('Description');
        $response->assertSee('Last update');
        $response->assertSee('Country');
        $response->assertSee('City');
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

    public function test_edit_not_logged()
    {
        $response = $this->get('/admin/edit/34');
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
