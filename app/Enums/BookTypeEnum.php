<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BookTypeEnum: int implements HasLabel
{
    case Graphic = 1;
    case Digit = 2;
    case Print = 3;

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
