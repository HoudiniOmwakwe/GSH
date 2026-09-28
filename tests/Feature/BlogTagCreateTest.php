<?php

namespace Tests\Feature;

use App\Filament\Resources\BlogTags\Pages\CreateBlogTag;
use App\Models\BlogTag;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BlogTagCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_blog_tag_with_only_a_name_auto_generates_the_slug(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(CreateBlogTag::class)
            ->fillForm(['name' => 'Live Dealer'])
            ->call('create')
            ->assertHasNoFormErrors();

        $tag = BlogTag::where('name', 'Live Dealer')->firstOrFail();

        $this->assertSame('live-dealer', $tag->slug);
    }
}
