<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'nama',
        'barcode',
        'satuan',
        'version',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'barang_id', 'id');
    }

    // calculated value menghitung total stock barang
    protected function totalStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stocks()->sum('balance'),
        );
    }

    #[Scope]
    public function hasStock(Builder $query)
    {
        $query->whereHas(
            'stocks',
            fn ($stock) => $stock->where('balance', '>', 0)
        );
    }

    #[Scope]
    public function noStock(Builder $query)
    {
        $query->whereDoesntHave(
            'stocks',
            fn ($stock) => $stock->where('balance', '>', 0)
        );
    }
}