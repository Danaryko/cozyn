<?php

namespace App\Filament\Widgets;

use App\Models\BoardingHouse;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Stat 1: Total Revenue (Omzet Aplikasi)
            Stat::make('Total Omzet', 'Rp ' . number_format(Transaction::sum('total_amount'), 0, ',', '.')) // Sesuaikan nama kolom amount
                ->description('Pemasukan kotor dari semua transaksi')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success')
                ->chart([7, 10, 15, 20, 18, 30, 45]), // Grafik dummy keren

            // Stat 2: Total Properti
            Stat::make('Total Kost Terdaftar', BoardingHouse::count())
                ->description('Kost aktif di platform')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('primary'),

            // Stat 3: Total User
            Stat::make('Total Pengguna', User::count())
                ->description('Gabungan Owner & Pencari')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}