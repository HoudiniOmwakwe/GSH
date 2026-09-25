<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_with_permission_can_save_settings(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(ManageSettings::class)
            ->fillForm([
                'site_name' => 'GameStakeHub',
                'contact_email' => 'hello@gamestakehub.com',
                'default_meta_title' => 'GameStakeHub — Smarter iGaming Intelligence',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $setting = Setting::current();

        $this->assertSame('GameStakeHub', $setting->site_name);
        $this->assertSame('hello@gamestakehub.com', $setting->contact_email);
        $this->assertSame('GameStakeHub — Smarter iGaming Intelligence', $setting->default_meta_title);
    }

    public function test_a_user_without_permission_cannot_access_settings(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $support = User::factory()->create();
        $support->assignRole('Support');

        $this->actingAs($support);

        $this->assertFalse(ManageSettings::canAccess());
    }
}
