<?php

namespace App\Filament\Resources\GudangResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StocksRelationManager extends RelationManager
{
    protected static string $relationship = 'stocks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'nama')
                    ->required(),
                Forms\Components\TextInput::make('balance')
                    ->label('Jumlah Stok')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('barang.nama')
                ->label('Barang')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('balance')
                ->label('Stok')
                ->sortable()
                ->numeric(),
            Tables\Columns\TextColumn::make('barang.satuan')
                ->label('Satuan'),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('stock_balance')
                ->placeholder('Semua')
                ->trueLabel('Ada Stok')
                ->falseLabel('Stok Kosong') 
                ->queries(
                    blank: fn (Builder $query) => $query,
                    true: fn (Builder $query) => $query->hasBalance(),
                    false: fn (Builder $query) => $query->noBalance(),
                ),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

}
