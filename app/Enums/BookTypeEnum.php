<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BookTypeEnum: string implements HasLabel
{
    case Graphic = 'graphic';
    case Digit = 'digit';
    case Print = 'print';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
