<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function($record) {
                    Log::channel('daily')->info("'{$record->title}' book has been deleted");
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Log::channel('daily')->info("'{$record->title}' book has been updated");

        return parent::handleRecordUpdate($record, $data);
    }
}
