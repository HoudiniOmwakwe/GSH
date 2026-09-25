<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Casino;
use App\Models\ComparisonTable;
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

        $casinos = Casino::factory()
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

        $categories = BlogCategory::factory()->count(3)->create();
        $tags = BlogTag::factory()->count(6)->create();

        BlogPost::factory()
            ->count(6)
            ->create(['blog_category_id' => fn () => $categories->random()->id])
            ->each(fn (BlogPost $post) => $post->tags()->attach(
                $tags->random(random_int(1, 3))->pluck('id')
            ));

        ComparisonTable::factory()
            ->count(2)
            ->create()
            ->each(function (ComparisonTable $table) use ($casinos) {
                $table->casinos()->attach(
                    $casinos->random(random_int(3, 5))->pluck('id')
                );
            });
    }
}
