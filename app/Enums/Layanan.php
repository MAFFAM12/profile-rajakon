<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Layanan: string implements HasColor, HasLabel
{
    case Construction = 'construction';
    case Mechanical = 'mechanical';
    case Electrical = 'electrical';
    case Safety = 'safety';
    case Maintenance = 'maintenance';
    case Logistics = 'logistics';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Construction => 'Jasa Konstruksi',
            self::Mechanical => 'Teknik Mesin',
            self::Electrical => 'Sistem Kelistrikan',
            self::Safety => 'Keselamatan & Kepatuhan',
            self::Maintenance => 'Layanan Pemeliharaan',
            self::Logistics => 'Logistik & Dukungan',
            self::Other => 'Lainnya',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Construction => 'warning',
            self::Mechanical => 'danger',
            self::Electrical => 'info',
            self::Safety => 'success',
            self::Maintenance => 'secondary',
            self::Logistics => 'light',
            self::Other => 'primary',
        };
    }
}
