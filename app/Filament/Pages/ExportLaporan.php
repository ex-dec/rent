<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inventaris;
use App\Models\Peminjaman;

class ExportLaporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Generate Laporan';
    protected static ?string $title = 'Generate Laporan';
    protected static ?string $navigationGroup = 'Laporan';
    protected static string $view = 'filament.pages.export-laporan';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Export PDF')
                ->label('Export Semua Data')
                ->icon('heroicon-o-document')
                ->color('primary')
                ->action(function () {
                    $inventaris = Inventaris::all();
                    $peminjaman = Peminjaman::all();

                    $pdf = Pdf::loadView('exports.report', [
                        'inventaris' => $inventaris,
                        'peminjaman' => $peminjaman,
                    ])->setPaper('A4', 'portrait');

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'all_report.pdf'
                    );
                }),
        ];
    }
}
