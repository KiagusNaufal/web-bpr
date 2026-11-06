<?php

namespace App\Enums;

enum ProductType: string
{
    case Tabungan = 'tabungan';
    case Kredit = 'kredit';
    case Deposito = 'deposito';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function tagline(): string
    {
        return match ($this) {
            self::Tabungan => 'Simpan dana dengan aman dan mudah diakses.',
            self::Kredit => 'Pembiayaan untuk usaha, kebutuhan, dan rencana Anda.',
            self::Deposito => 'Tempatkan dana untuk jangka waktu yang Anda pilih.',
        };
    }
}
