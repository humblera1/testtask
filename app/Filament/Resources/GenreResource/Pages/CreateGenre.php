<?php

namespace App\Filament\Resources\GenreResource\Pages;

use App\Filament\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateGenre extends CreateRecord
{
    protected static string $resource = GenreResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        Log::channel('daily')->info("genre '{$data['name']}' has been added");

        return parent::handleRecordCreation($data);
    }
}
