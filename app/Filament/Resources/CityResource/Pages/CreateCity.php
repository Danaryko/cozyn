<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    // --- TAMBAHKAN FUNGSI INI ---
    protected function getRedirectUrl(): string
    {
        // Arahkan kembali ke halaman List (Index) setelah Create
        return $this->getResource()::getUrl('index');
    }
    // ----------------------------
}