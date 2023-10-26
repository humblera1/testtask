<?php

namespace App\Filament\Resources\GenreResource\Pages;

use App\Filament\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EditGenre extends EditRecord
{
    protected static string $resource = GenreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function($record) {
                    Log::channel('daily')->info("genre '{$record->name}' has been deleted");
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Log::channel('daily')->info("genre '{$record->name}' has been updated");

        return parent::handleRecordUpdate($record, $data);
    }
}
