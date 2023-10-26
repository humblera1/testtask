<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuthorsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Authors', Author::count()),
            Stat::make('Books', Book::count()),
        ];
    }
}
