<?php

namespace Tests\Feature;

use App\Filament\Resources\BlogPosts\Pages\CreateBlogPost;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BlogPostCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_blog_post_auto_generates_the_slug_and_saves_tags(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $category = BlogCategory::factory()->create();
        $tagOne = BlogTag::factory()->create();
        $tagTwo = BlogTag::factory()->create();

        Livewire::actingAs($admin)
            ->test(CreateBlogPost::class)
            ->fillForm([
                'blog_category_id' => $category->id,
                'title' => 'How To Spot A Fair Casino',
                'body' => 'Some helpful guidance for players.',
                'tags' => [$tagOne->id, $tagTwo->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $post = BlogPost::where('title', 'How To Spot A Fair Casino')->firstOrFail();

        $this->assertSame('how-to-spot-a-fair-casino', $post->slug);
        $this->assertEqualsCanonicalizing(
            [$tagOne->id, $tagTwo->id],
            $post->tags()->pluck('blog_tags.id')->all()
        );
    }
}
