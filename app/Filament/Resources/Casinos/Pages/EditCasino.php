<?php

namespace App\Filament\Resources\Casinos\Pages;

use App\Filament\Resources\Casinos\CasinoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCasino extends EditRecord
{
    protected static string $resource = CasinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
