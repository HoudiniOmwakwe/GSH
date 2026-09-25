<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $title = 'Website Settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view settings') ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(Setting::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Site Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('contact_email')
                            ->email()
                            ->maxLength(255),
                    ]),

                Section::make('Social Links')
                    ->columns(3)
                    ->schema([
                        TextInput::make('twitter_url')
                            ->label('Twitter / X')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('facebook_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('instagram_url')
                            ->url()
                            ->maxLength(255),
                    ]),

                Section::make('Default SEO')
                    ->description('Used as a fallback when a casino, review, or blog post has no SEO overrides of its own.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('default_meta_title')
                            ->maxLength(255),
                        TextInput::make('default_meta_description')
                            ->maxLength(500),
                    ]),

                Section::make('Analytics')
                    ->schema([
                        TextInput::make('analytics_id')
                            ->label('Analytics tracking ID')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function save(): void
    {
        abort_unless(auth()->user()?->can('update settings'), 403);

        Setting::current()->update($this->form->getState());

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
