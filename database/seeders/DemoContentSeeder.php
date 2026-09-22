<?php

namespace Database\Seeders;

use App\Models\Casino;
use App\Models\ContactMessage;
use App\Models\PaymentMethod;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = PaymentMethod::all();

        Casino::factory()
            ->count(8)
            ->create()
            ->each(function (Casino $casino) use ($paymentMethods) {
                $casino->paymentMethods()->attach(
                    $paymentMethods->random(random_int(2, 5))->pluck('id')
                );

                Review::factory()
                    ->count(random_int(1, 3))
                    ->create(['casino_id' => $casino->id]);

                $casino->forceFill([
                    'rating_avg' => $casino->reviews()->where('status', 'published')->avg('rating_overall') ?? 0,
                ])->save();
            });

        ContactMessage::factory()->count(6)->create();
    }
}
