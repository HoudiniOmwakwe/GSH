<?php

namespace Tests\Feature;

use App\Filament\Resources\Casinos\Pages\CreateCasino;
use App\Models\Casino;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CasinoMediaUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploading_a_logo_attaches_it_to_the_casinos_media_collection(): void
    {
        Storage::fake('public');
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        Livewire::actingAs($admin)
            ->test(CreateCasino::class)
            ->fillForm([
                'name' => 'Lucky Star Casino',
                'logo' => [TemporaryUploadedFile::fake()->image('logo.jpg')],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $casino = Casino::where('name', 'Lucky Star Casino')->firstOrFail();
        $media = $casino->getFirstMedia('logo');

        $this->assertNotNull($media);
        $this->assertStringEndsWith('.jpg', $media->file_name);
        $this->assertFileExists($media->getPath());
    }
}
