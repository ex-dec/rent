<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use Filament\Forms\Components\DatePicker;

class ListPeminjaman extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('primary')
                ->form([
                    DatePicker::make('start_date')->label('Dari Tanggal'),
                    DatePicker::make('end_date')->label('Sampai Tanggal'),
                ])
                ->action(function (array $data) {
                    $peminjaman = Peminjaman::whereBetween('tanggal_pinjam', [$data['start_date'], $data['end_date']])->get();
                    $pdf = Pdf::loadView('exports.peminjaman', ['peminjaman' => $peminjaman])->setPaper('A4', 'landscape');

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'laporan_peminjaman.pdf'
                    );
                }),
        ];
    }
}
