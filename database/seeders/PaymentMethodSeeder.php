<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * @var array<string, string>
     */
    private array $methods = [
        'Visa' => 'card',
        'Mastercard' => 'card',
        'Bitcoin' => 'crypto',
        'Ethereum' => 'crypto',
        'USDT' => 'crypto',
        'Skrill' => 'e-wallet',
        'Neteller' => 'e-wallet',
        'PayPal' => 'e-wallet',
        'Bank Transfer' => 'bank-transfer',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->methods as $name => $type) {
            PaymentMethod::query()->firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name, 'type' => $type]
            );
        }
    }
}
