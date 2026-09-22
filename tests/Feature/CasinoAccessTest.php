<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CasinoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/admin/casinos');

        $response->assertRedirect('/admin/login');
    }

    public function test_a_user_with_permission_can_view_the_casino_list(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)->get('/admin/casinos');

        $response->assertOk();
    }

    public function test_a_user_without_permission_is_forbidden(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $support = User::factory()->create();
        $support->assignRole('Support');

        $response = $this->actingAs($support)->get('/admin/casinos');

        $response->assertForbidden();
    }
}
