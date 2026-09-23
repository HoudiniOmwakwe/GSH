<?php

namespace Tests\Feature;

use App\Filament\Resources\Casinos\Pages\CreateCasino;
use App\Filament\Resources\Casinos\Pages\EditCasino;
use App\Models\Casino;
use App\Models\PaymentMethod;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CasinoEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_casino_saves_payment_methods_and_seo_fields(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $visa = PaymentMethod::factory()->create(['name' => 'Visa']);
        $bitcoin = PaymentMethod::factory()->create(['name' => 'Bitcoin']);

        Livewire::actingAs($admin)
            ->test(CreateCasino::class)
            ->fillForm([
                'name' => 'Test Casino',
                'type' => 'casino',
                'status' => 'published',
                'paymentMethods' => [$visa->id, $bitcoin->id],
                'meta_title' => 'Test Casino Review',
                'meta_description' => 'A great place to play.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $casino = Casino::where('name', 'Test Casino')->firstOrFail();

        $this->assertSame('test-casino', $casino->slug);
        $this->assertSame('Test Casino Review', $casino->meta_title);
        $this->assertSame('A great place to play.', $casino->meta_description);
        $this->assertEqualsCanonicalizing(
            [$visa->id, $bitcoin->id],
            $casino->paymentMethods()->pluck('payment_methods.id')->all()
        );
    }

    public function test_editing_a_casinos_payment_methods_updates_the_relationship(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $casino = Casino::factory()->create();
        $visa = PaymentMethod::factory()->create(['name' => 'Visa']);
        $bitcoin = PaymentMethod::factory()->create(['name' => 'Bitcoin']);
        $paypal = PaymentMethod::factory()->create(['name' => 'PayPal']);

        $casino->paymentMethods()->attach([$visa->id, $bitcoin->id]);

        Livewire::actingAs($admin)
            ->test(EditCasino::class, ['record' => $casino->getRouteKey()])
            ->fillForm(['paymentMethods' => [$bitcoin->id, $paypal->id]])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEqualsCanonicalizing(
            [$bitcoin->id, $paypal->id],
            $casino->paymentMethods()->pluck('payment_methods.id')->all()
        );
    }
}
