<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn ($record) => $record->status === 'unread' ? 'bold' : null),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unread' => 'danger',
                        'read' => 'gray',
                        'replied' => 'success',
                        'archived' => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyState(fn () => view('filament.empty-states.no-records', [
                'heading' => 'No messages yet',
                'description' => 'Submissions from the site\'s contact form will land here.',
            ]))
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'unread' => 'Unread',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'archived' => 'Archived',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
