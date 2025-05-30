<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Customer;
use App\Models\Faktur;
use App\Models\Produk;
use Attribute;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;

class FakturResource extends Resource
{
    protected static ?string $model = Faktur::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Faktur Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_faktur')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 2,
                        'lg' => 1,
                        'xl' => 1
                    ]),
                DatePicker::make('tanggal_faktur')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 2,
                        'lg' => 1,
                        'xl' => 1
                    ]),
                Select::make('customer_id')
                    ->reactive()
                    ->relationship('customer', 'name')
                    ->columnSpan(2)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $customer = Customer::find($state);

                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    })
                    ->afterStateHydrated(function ($state, callable $set) {
                        $customer = Customer::find($state);

                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    }),
                TextInput::make('kode_customer')
                    // ->disabled()
                    ->reactive()
                    ->columnSpan(2),
                Repeater::make('details')
                    ->relationship()
                    ->schema([
                        Select::make('produk_id')
                            ->relationship('produk', 'produk_name')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $produk = Produk::find($state);

                                if ($produk) {
                                    $set('kode_produk', $produk->kode_produk);
                                    $set('harga', $produk->price);
                                }
                            }),
                        TextInput::make('kode_produk'),
                        // ->disabled(),
                        TextInput::make('harga')
                            // ->disabled()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('qty')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $tampungHarga = $get('harga');

                                $set('hasil_qty', intval($state * $tampungHarga));
                            }),
                        TextInput::make('hasil_qty')
                            // ->disabled()
                            ->numeric(),
                        TextInput::make('diskon')
                            ->reactive()
                            ->numeric()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $hasilQty = $get('hasil_qty');
                                $diskon = $hasilQty * ($state / 100);
                                $hasil = $hasilQty - $diskon;

                                $set('subtotal', intval($hasil));
                            }),
                        TextInput::make('subtotal')
                            // ->disabled()
                            ->numeric(),
                    ])
                    ->live()
                    ->columnSpan(2),
                Textarea::make('ket_faktur')
                    ->columnSpan(2),
                TextInput::make('total')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 2,
                        'lg' => 1,
                        'xl' => 1
                    ])
                    ->placeholder(function (Set $set, Get $get) {
                        $detail = collect($get('details'))->pluck('subtotal')->sum();

                        if ($detail == null) {
                            $set('total', 0);
                        } else {
                            $set('total', $detail);
                        }
                    }),
                TextInput::make('nominal_charge')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 2,
                        'lg' => 1,
                        'xl' => 1
                    ])
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        $total = $get('total');
                        $charge = $total * ($state / 100);
                        $hasil = $total + $charge;

                        $set('total_final', $hasil);
                        $set('charge', $charge);
                    }),
                TextInput::make('charge')
                    // ->disabled()
                    ->columnSpan(2),
                TextInput::make('total_final')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_faktur'),
                TextColumn::make('tanggal_faktur'),
                TextColumn::make('customer.name'),
                TextColumn::make('total')
                    ->formatStateUsing(fn(Faktur $record): string => 'Rp ' . number_format($record->total, 0, '.', '.')),
                TextColumn::make('nominal_charge'),
                TextColumn::make('charge'),
                TextColumn::make('total_final')
                    ->formatStateUsing(fn(Faktur $record): string => 'Rp ' . number_format($record->total_final, 0, '.', '.')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListFakturs::route('/'),
            'create' => Pages\CreateFaktur::route('/create'),
            'edit' => Pages\EditFaktur::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
