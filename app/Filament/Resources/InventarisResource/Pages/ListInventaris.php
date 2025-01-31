<?php

namespace App\Filament\Resources\InventarisResource\Pages;

use App\Filament\Resources\InventarisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inventaris;

class ListInventaris extends ListRecords
{
    protected static string $resource = InventarisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('primary')
                ->action(function () {
                    $inventaris = Inventaris::all();

                    $pdf = Pdf::loadView('exports.inventaris', ['inventaris' => $inventaris])->setPaper('A4', 'portrait');

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'laporan_inventaris.pdf'
                    );
                }),
        ];
    }
}
