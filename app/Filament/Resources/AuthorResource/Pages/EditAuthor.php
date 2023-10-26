<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function($record) {
                    Log::channel('daily')->info("author {$record->username} has been deleted");
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (!($record->password === $data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        Log::channel('daily')->info("author {$record->username} data has been updated");

        return parent::handleRecordUpdate($record, $data);
    }
}
