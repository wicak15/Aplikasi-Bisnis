<?php

namespace App\Filament\Resources\TransaksiStockResource\Pages;

use App\Filament\Resources\TransaksiStockResource;
use App\JenisTransaksi;
use App\Models\Stock;
use App\Models\TransaksiStock;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTransaksiStock extends CreateRecord
{
    protected static string $resource = TransaksiStockResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(
            function () use ($data) {
                //defensive programming, check data sanity
                if (intval($data['jumlah']) <= 0) {
                    Notification::make()
                        ->title('Jumlah salah')
                        ->danger()
                        ->send();

                    $this->halt();
                }
                //cari data stock sesuai pilihan barang & gudang
                $stock = Stock::firstOrCreate(
                    [
                        'barang_id' => $data['barang'],
                        'gudang_id' => $data['gudang']
                    ],
                    [
                        'barang_id' => $data['barang'],
                        'gudang_id' => $data['gudang'],
                        'balance' => 0,
                    ]
                
                );

                //kunci stock supaya hanya bisa di update oleh 1 proses saja
                $stock = Stock::lockForUpdate()->find($stock->id);

                //jika transaksi kredit, check apakah saldo stock cukup
                //jika tidak, tampilkan warning dan stop proses
                if (
                    $data['jenis_transaksi'] === JenisTransaksi::Kredit->value
                    && $data['jumlah'] > $stock->balance
                    ) {
                    Notification::make()
                        ->title('Stock tidak cukup')
                        ->danger()
                        ->send();

                    $this->halt();
                }

                // catat transaksi stock
                $trx = TransaksiStock::create([
                    'tanggal' => $data['tanggal'],
                    'stocks_id' => $stock->id,
                    'keterangan' => $data['keterangan'],
                    'jenis_transaksi' => $data['jenis_transaksi'],
                    'jumlah' => $data['jumlah'],
                ]);

                // tambahkan balance stock sesuai jumlah
                if ($data['jenis_transaksi'] === JenisTransaksi::Debit->value) {
                    $stock->balance +=$data['jumlah'];
                    $stock->save();

                    return $trx;
                }

                //kurang balance stock sesuai jumlah
                if ($data['jenis_transaksi'] === JenisTransaksi::Kredit->value) {
                    $stock->balance -= $data['jumlah'];
                    $stock->save();

                    return $trx;
                }
            }
        );
    }
}