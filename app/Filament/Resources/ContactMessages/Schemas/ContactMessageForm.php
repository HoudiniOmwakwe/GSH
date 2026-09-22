<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Message')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->disabled(),
                        TextInput::make('subject')
                            ->disabled()
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->disabled()
                            ->rows(6)
                            ->columnSpanFull(),
                        TextInput::make('ip_address')
                            ->disabled(),
                        Select::make('status')
                            ->options([
                                'unread' => 'Unread',
                                'read' => 'Read',
                                'replied' => 'Replied',
                                'archived' => 'Archived',
                            ])
                            ->required(),
                    ]),
            ]);
    }
}
