<?php

namespace App\Filament\Owner\Widgets;

use App\Models\BoardingHouse;
use App\Models\Transaction; // Asumsi ada model Transaction
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        return [
            Stat::make('Total Kost', BoardingHouse::where('user_id', $userId)->count())
                ->description('Properti aktif Anda')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('primary'),

            // Contoh jika ada transaksi (sesuaikan logika booking kamu)
            Stat::make('Total Booking', '12') 
                ->description('Bulan ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Grafik mini hiasan

            Stat::make('Estimasi Pendapatan', 'Rp 15.400.000')
                ->description('Bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}