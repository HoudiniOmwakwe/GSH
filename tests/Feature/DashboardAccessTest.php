<?php

namespace Tests\Feature;

use App\Filament\Widgets\SiteOverview;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array<string>>
     */
    public static function roleProvider(): array
    {
        return [
            'Super Admin' => ['Super Admin'],
            'Admin' => ['Admin'],
            'Editor' => ['Editor'],
            'Support' => ['Support'],
        ];
    }

    #[DataProvider('roleProvider')]
    public function test_the_dashboard_and_its_stats_widget_render_for_every_role(string $role): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user)->get('/admin')->assertOk();

        Livewire::actingAs($user)
            ->test(SiteOverview::class)
            ->assertSee('Published casinos')
            ->assertSee('Unread messages');
    }
}
