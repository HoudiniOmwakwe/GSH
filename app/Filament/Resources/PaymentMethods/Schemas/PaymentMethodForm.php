<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Auto-generated from the name; edit if you need a custom slug.'),
                Select::make('type')
                    ->options([
                        'card' => 'Card',
                        'crypto' => 'Crypto',
                        'e-wallet' => 'E-wallet',
                        'bank-transfer' => 'Bank Transfer',
                    ])
                    ->required()
                    ->default('card'),
            ]);
    }
}
