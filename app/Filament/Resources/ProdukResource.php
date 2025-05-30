<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProdukResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProdukResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Produks Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_produk')
                    ->required(),
                TextInput::make('produk_name')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric(),
                Textarea::make('description'),
                FileUpload::make('produk_image')
                    ->image()
                    ->disk('public')
                    ->directory('produk-images')
                    ->visibility('public')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_produk')
                    ->searchable(),
                TextColumn::make('produk_name')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('price')
                    ->formatStateUsing(fn(Produk $record): string => 'Rp ' . number_format($record->price, 0, '.', '.')),
                ImageColumn::make('produk_image')
                    ->disk('public')
                    ->visibility('public')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
