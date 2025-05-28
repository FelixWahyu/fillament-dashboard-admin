<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Customers Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('kode_customer')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                FileUpload::make('image_profile')
                    ->disk('public')
                    ->image()
                    ->directory('profile-images')
                    ->visibility('public')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_customer'),
                TextColumn::make('name'),
                TextColumn::make('phone'),
                TextColumn::make('address'),
                ImageColumn::make('image_profile')
                    ->disk('public')
                    ->visibility('public')
                    ->url(fn($record) => asset('storage/' . $record->image_profile))
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
