<?php

namespace Tests\Feature;

use App\Filament\Resources\Reviews\Pages\CreateReview;
use App\Models\Casino;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_review_with_only_a_title_auto_generates_the_slug(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $casino = Casino::factory()->create();

        Livewire::actingAs($admin)
            ->test(CreateReview::class)
            ->fillForm([
                'casino_id' => $casino->id,
                'title' => 'A Genuinely Fair Casino',
                'body' => 'This casino treats players well.',
                'rating_payout' => 4,
                'rating_games' => 4,
                'rating_support' => 4,
                'rating_bonuses' => 4,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $review = Review::where('title', 'A Genuinely Fair Casino')->firstOrFail();

        $this->assertSame('a-genuinely-fair-casino', $review->slug);
    }
}
