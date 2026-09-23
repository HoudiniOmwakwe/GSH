<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactMessages\Pages\EditContactMessage;
use App\Models\ContactMessage;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactMessageEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_changing_only_the_status_does_not_wipe_the_other_fields(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $message = ContactMessage::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Original subject',
            'message' => 'Original message body',
            'status' => 'unread',
        ]);

        Livewire::actingAs($admin)
            ->test(EditContactMessage::class, ['record' => $message->getRouteKey()])
            ->fillForm(['status' => 'read'])
            ->call('save')
            ->assertHasNoFormErrors();

        $message->refresh();

        $this->assertSame('Jane Doe', $message->name);
        $this->assertSame('jane@example.com', $message->email);
        $this->assertSame('Original subject', $message->subject);
        $this->assertSame('Original message body', $message->message);
        $this->assertSame('read', $message->status);
    }
}
