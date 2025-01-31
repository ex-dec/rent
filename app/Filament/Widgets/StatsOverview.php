<?php

namespace App\Filament\Widgets;

use App\Models\Inventaris;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return [
                Stat::make('Total Inventaris', Inventaris::sum('jumlah'))
                    ->description('Total dari semua jenis inventaris')
                    ->icon('heroicon-o-archive-box')
                    ->color('success'),

                Stat::make('Total Ruangan', Ruang::count())
                    ->description('Total ruangan yang tersedia')
                    ->icon('heroicon-o-building-office')
                    ->color('primary'),

                Stat::make('Total Peminjaman', Peminjaman::count())
                    ->description('Total transaksi peminjaman')
                    ->icon('heroicon-o-document-text')
                    ->color('warning'),
            ];
        }

        if ($user->hasRole('operator')) {
            return [
                Stat::make('Total Peminjaman', Peminjaman::count())
                    ->description('Total peminjaman yang sedang berlangsung')
                    ->icon('heroicon-o-document-text')
                    ->color('warning'),

                Stat::make('Total Inventaris', Inventaris::sum('jumlah'))
                    ->description('Total barang di inventaris')
                    ->icon('heroicon-o-archive-box')
                    ->color('success'),
            ];
        }

        if ($user->hasRole('pegawai')) {
            return [
                Stat::make('Peminjaman Saya', Peminjaman::where('user_id', $user->id)->count())
                    ->description('Jumlah barang yang dipinjam oleh Anda')
                    ->icon('heroicon-o-user')
                    ->color('info'),
            ];
        }

        return [];
    }
}
