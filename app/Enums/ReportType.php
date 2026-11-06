<?php

namespace App\Enums;

enum ReportType: string
{
    case Publikasi = 'publikasi';
    case Tahunan = 'tahunan';
    case Neraca = 'neraca';
    case LabaRugi = 'laba_rugi';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::Publikasi => 'Laporan Publikasi',
            self::Tahunan => 'Laporan Keuangan Tahunan',
            self::Neraca => 'Laporan Neraca',
            self::LabaRugi => 'Laporan Laba Rugi',
            self::Lainnya => 'Informasi Keuangan Lainnya',
        };
    }
}
