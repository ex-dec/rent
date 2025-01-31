<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages;
use App\Models\Inventaris;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    protected static ?string $navigationLabel = 'Inventaris';
    protected static ?string $navigationGroup = 'Manajemen Aset';
    protected static ?string $icon = 'heroicon-o-archive-box';

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->hasRole('admin');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->hasRole('admin');
    }

    public static function canView($record): bool
    {
        return Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function canViewNavigation(): bool
    {
        return Auth::user()->hasRole('operator') || Auth::user()->hasRole('admin');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Data Inventaris')
                    ->schema([
                        TextInput::make('nama')->required()->maxLength(255),

                        Select::make('kondisi')
                            ->options([
                                'Baru' => 'Baru',
                                'Bekas' => 'Bekas',
                            ])
                            ->required(),

                        Textarea::make('keterangan')->rows(3),
                        TextInput::make('jumlah')->numeric()->required(),

                        Select::make('jenis_id')
                            ->label('Jenis')
                            ->relationship('jenis', 'nama', fn($query) => $query->orderBy('nama'))
                            ->searchable(false)
                            ->required(),

                        Select::make('ruang_id')
                            ->label('Ruang')
                            ->relationship('ruang', 'nama', fn($query) => $query->orderBy('nama'))
                            ->searchable(false)
                            ->required(),

                        TextInput::make('kode_inventaris')->required()->maxLength(50),
                        DatePicker::make('tanggal_register')->required(),

                        Hidden::make('user_id')->default(Auth::id()),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('kondisi')->sortable(),
                TextColumn::make('jumlah')->sortable(),
                TextColumn::make('kode_inventaris')->sortable()->searchable(),
                TextColumn::make('jenis.nama')->label('Jenis')->sortable(),
                TextColumn::make('ruang.nama')->label('Ruang')->sortable(),
                TextColumn::make('tanggal_register')->date()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn() => !Auth::user()->hasRole('admin')),

                Tables\Actions\DeleteAction::make()
                    ->hidden(fn() => !Auth::user()->hasRole('admin')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden(fn() => !Auth::user()->hasRole('admin')),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventaris::route('/'),
            'create' => Pages\CreateInventaris::route('/create'),
            'edit' => Pages\EditInventaris::route('/{record}/edit'),
        ];
    }
}
