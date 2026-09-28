<?php

namespace Tests\Feature;

use App\Models\Casino;
use App\Models\ComparisonTable;
use App\Models\PaymentMethod;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class CasinoDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_casino_cascades_to_its_reviews_and_pivot_rows(): void
    {
        $casino = Casino::factory()->create();
        $review = Review::factory()->create(['casino_id' => $casino->id]);
        $paymentMethod = PaymentMethod::factory()->create();
        $casino->paymentMethods()->attach($paymentMethod->id);
        $table = ComparisonTable::factory()->create();
        $table->casinos()->attach($casino->id);

        $casinoId = $casino->id;
        $reviewId = $review->id;

        $casino->delete();

        $this->assertNull(Review::find($reviewId));
        $this->assertSame(0, DB::table('casino_payment_method')->where('casino_id', $casinoId)->count());
        $this->assertSame(0, DB::table('comparison_table_casino')->where('casino_id', $casinoId)->count());
    }

    public function test_deleting_a_casino_removes_its_media_files(): void
    {
        $casino = Casino::factory()->create();
        $casino->addMediaFromString('fake-image-bytes')
            ->usingFileName('logo.jpg')
            ->toMediaCollection('logo');

        $mediaId = $casino->getFirstMedia('logo')->id;
        $mediaPath = $casino->getFirstMedia('logo')->getPath();

        $casino->delete();

        $this->assertFileDoesNotExist($mediaPath);
        $this->assertNull(Media::find($mediaId));
    }
}
