<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisResource\Pages;
use App\Models\Jenis;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;

class JenisResource extends Resource
{
    protected static ?string $model = Jenis::class;
    protected static ?string $navigationLabel = 'Jenis Barang';
    protected static ?string $navigationGroup = 'Manajemen Aset';
    protected static ?string $icon = 'heroicon-o-collection';

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->required()->maxLength(255),
                TextInput::make('kode')->required()->maxLength(50),
                Textarea::make('keterangan')->rows(3),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('kode')->sortable()->searchable(),
                TextColumn::make('keterangan'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenis::route('/'),
            'create' => Pages\CreateJenis::route('/create'),
            'edit' => Pages\EditJenis::route('/{record}/edit'),
        ];
    }
}
