<?php

namespace Tests\Feature;

use App\Filament\Resources\BlogCategories\Pages\CreateBlogCategory;
use App\Models\BlogCategory;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BlogCategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_blog_category_with_only_a_name_auto_generates_the_slug(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(CreateBlogCategory::class)
            ->fillForm(['name' => 'Crypto Betting Guides'])
            ->call('create')
            ->assertHasNoFormErrors();

        $category = BlogCategory::where('name', 'Crypto Betting Guides')->firstOrFail();

        $this->assertSame('crypto-betting-guides', $category->slug);
    }
}
