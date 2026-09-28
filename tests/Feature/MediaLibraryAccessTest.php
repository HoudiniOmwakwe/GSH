<?php

namespace Tests\Feature;

use App\Models\Casino;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaLibraryAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_with_permission_can_view_the_media_library_and_see_uploaded_files(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $casino = Casino::factory()->create();
        $casino->addMediaFromString('fake-image-bytes')
            ->usingFileName('logo.jpg')
            ->toMediaCollection('logo');

        $response = $this->actingAs($admin)->get('/admin/media-library-items');

        $response->assertOk();
        $response->assertSee('logo.jpg');
    }

    public function test_a_user_without_permission_is_forbidden(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $support = User::factory()->create();
        $support->assignRole('Support');

        $this->actingAs($support)
            ->get('/admin/media-library-items')
            ->assertForbidden();
    }
}
