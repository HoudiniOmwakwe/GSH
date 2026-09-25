<?php

namespace Tests\Feature;

use App\Filament\Resources\ComparisonTables\Pages\CreateComparisonTable;
use App\Models\Casino;
use App\Models\ComparisonTable;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ComparisonTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_comparison_table_auto_generates_the_slug(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(CreateComparisonTable::class)
            ->fillForm(['name' => 'Best Crypto Casinos 2026'])
            ->call('create')
            ->assertHasNoFormErrors();

        $table = ComparisonTable::where('name', 'Best Crypto Casinos 2026')->firstOrFail();

        $this->assertSame('best-crypto-casinos-2026', $table->slug);
    }

    public function test_attaching_casinos_to_a_comparison_table_persists_the_relationship(): void
    {
        $table = ComparisonTable::factory()->create();
        $casinoOne = Casino::factory()->create();
        $casinoTwo = Casino::factory()->create();

        $table->casinos()->attach([$casinoOne->id, $casinoTwo->id]);

        $this->assertEqualsCanonicalizing(
            [$casinoOne->id, $casinoTwo->id],
            $table->casinos()->pluck('casinos.id')->all()
        );
    }

    public function test_a_casino_can_be_attached_to_multiple_comparison_tables(): void
    {
        $tableOne = ComparisonTable::factory()->create();
        $tableTwo = ComparisonTable::factory()->create();
        $casino = Casino::factory()->create();

        $tableOne->casinos()->attach($casino->id);
        $tableTwo->casinos()->attach($casino->id);

        $this->assertEqualsCanonicalizing(
            [$tableOne->id, $tableTwo->id],
            $casino->comparisonTables()->pluck('comparison_tables.id')->all()
        );
    }
}
