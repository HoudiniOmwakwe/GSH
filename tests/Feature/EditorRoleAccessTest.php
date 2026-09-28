<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Models\Casino;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditorRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_can_view_and_create_casinos(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->actingAs($editor)->get('/admin/casinos')->assertOk();
        $this->actingAs($editor)->get('/admin/casinos/create')->assertOk();
    }

    public function test_editor_cannot_delete_a_casino(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->assertFalse($editor->can('delete', Casino::factory()->create()));
    }

    public function test_editor_cannot_access_settings(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->actingAs($editor);

        $this->assertFalse(ManageSettings::canAccess());
    }

    public function test_editor_cannot_access_user_management_permissions(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->assertFalse($editor->can('view users'));
        $this->assertFalse($editor->can('view settings'));
    }
}
