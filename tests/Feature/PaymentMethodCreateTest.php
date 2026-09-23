<?php

namespace Tests\Feature;

use App\Filament\Resources\PaymentMethods\Pages\CreatePaymentMethod;
use App\Models\PaymentMethod;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PaymentMethodCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_payment_method_with_only_a_name_auto_generates_the_slug(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(CreatePaymentMethod::class)
            ->fillForm([
                'name' => 'Apple Pay',
                'type' => 'e-wallet',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $paymentMethod = PaymentMethod::where('name', 'Apple Pay')->firstOrFail();

        $this->assertSame('apple-pay', $paymentMethod->slug);
    }
}
