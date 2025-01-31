<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Carbon\Carbon;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationLabel = 'Peminjaman Barang';
    protected static ?string $navigationGroup = 'Manajemen Peminjaman';
    protected static ?string $icon = 'heroicon-o-shopping-cart';

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('pegawai') || Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->hasRole('pegawai') || Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->hasRole('admin') || Auth::user()->hasRole('operator');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->hasRole('admin') || Auth::user()->hasRole('operator');
    }

    public static function canView($record): bool
    {
        return Auth::user()->hasRole('pegawai') || Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function canViewNavigation(): bool
    {
        return Auth::user()->hasRole('pegawai') || Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Informasi Peminjaman')
                    ->schema([
                        DatePicker::make('tanggal_pinjam')->required(),
                        Hidden::make('status_peminjaman')->default('dipinjam'),
                        Select::make('user_id')
                            ->label('Peminjam')
                            ->relationship('user', 'name')
                            ->searchable(false)
                            ->required(),
                    ]),
                Section::make('Detail Peminjaman')
                    ->schema([
                        Repeater::make('detailPinjam')
                            ->relationship()
                            ->schema([
                                Select::make('id_inventaris')
                                    ->label('Inventaris')
                                    ->relationship('inventaris', 'nama')
                                    ->searchable(false)
                                    ->required(),
                                TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->addActionLabel('Tambah Barang'),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pinjam')->sortable(),
                TextColumn::make('tanggal_kembali')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('d M Y') : 'Belum dikembalikan'),
                TextColumn::make('status_peminjaman')->label('Status')->sortable(),
                TextColumn::make('user.name')->label('Peminjam')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn() => Auth::user()->hasRole('pegawai')),

                Tables\Actions\DeleteAction::make()
                    ->hidden(fn() => Auth::user()->hasRole('pegawai')),

                Action::make('Kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->color('success')
                    ->hidden(fn() => Auth::user()->hasRole('pegawai'))
                    ->action(fn(Peminjaman $record) => $record->update([
                        'status_peminjaman' => 'ada',
                        'tanggal_kembali' => now(),
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden(fn() => Auth::user()->hasRole('pegawai')),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjaman::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
