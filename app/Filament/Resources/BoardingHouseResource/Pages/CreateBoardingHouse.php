<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoardingHouse extends CreateRecord
{
    protected static string $resource = BoardingHouseResource::class;

    // --- TAMBAHKAN FUNGSI INI ---
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Isi kolom user_id dengan ID user yang sedang login
        $data['user_id'] = auth()->id();
    
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // ----------------------------
}