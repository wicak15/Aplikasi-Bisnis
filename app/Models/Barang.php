<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;


class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'barcode',
        'satuan',
        //'version',
        'gudang_id',
    ];

    public function gudang(): BelongsTo 
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'barang_id','id');
    }

    // calculated vale menghitung totaal stock barang 
    protected function totalStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stocks()->sum('balance'),
        );
    }

    #[Scope]
    public function hasStock(Builder $query)
    {
        $query->whereHas('stocks', fn ($q) => $q->where('balance', '>', 0 ));
    }

    public function noStock(Builder $query)
    {
        //FIX : barang ada relasi stock tapi balance nya sudah 0
        $query->whereDoesntHave('stocks');
    }

}