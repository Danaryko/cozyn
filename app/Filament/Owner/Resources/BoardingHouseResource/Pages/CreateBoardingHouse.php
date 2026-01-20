<?php

namespace App\Filament\Owner\Resources\BoardingHouseResource\Pages;

use App\Filament\Owner\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoardingHouse extends CreateRecord
{
    protected static string $resource = BoardingHouseResource::class;

    // TAMBAHKAN FUNGSI INI
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id(); // Isi user_id dengan ID yang login otomatis
        return $data;
    }
}