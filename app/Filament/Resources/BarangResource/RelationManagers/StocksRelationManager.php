<?php

namespace App\Filament\Resources\BarangResource\RelationManagers;

use App\JenisTransaksi;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StocksRelationManager extends RelationManager
{
    protected static string $relationship = 'stocks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('gudang_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gudang_id')
            ->columns([
                Tables\Columns\TextColumn::make('gudang.nama')
                    ->label('Gudang')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('barang.satuan')
                    ->label('Satuan'),
            ])
            ->filters([
                TernaryFilter::make('stock_balance')
                    ->placeholder('Semua')
                    ->trueLabel('Ada Stock')
                    ->falseLabel('Stock Kosong')
                    ->queries(
                        blank: fn (Builder $query) => $query,
                        true: fn (Builder $query) => $query->hasBalance(),
                        false: fn (Builder $query) => $query->noBalance(),
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('masuk_stock')
                    ->label('+ Stock')
                    ->form([
                        TextInput::make('keterangan')
                            ->required(),
                        TextInput::make('jumlah')
                            ->label('Jumlah stock')
                            ->required()
                            ->minValue(1)
                            ->numeric(),
                    ])
                    ->action(
                        function (Model $record, array $data) {
                            DB::transaction(
                                function () use($record, $data) {
                                    $record->update([
                                        'balance' => $record->balance + $data['jumlah'],
                                    ]);
                                    $record->transaksi()->create([
                                        'tanggal' => Carbon::today(),
                                        'keterangan' => $data['keterangan'],
                                        'jenis_transaksi' => JenisTransaksi::Debit,
                                        'jumlah' => $data['jumlah'],
                                    ]);
                                }
                            );
                            
                        }
                    ),
            ]);
    }
}
