<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    // --- TAMBAHKAN FUNGSI INI ---
    protected function getRedirectUrl(): string
    {
        // Arahkan kembali ke halaman List (Index) setelah berhasil membuat data
        return $this->getResource()::getUrl('index');
    }
    // ----------------------------
}