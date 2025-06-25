<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'barang_id',
        'gudang_id',
        'balance',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class,'gudang_id','id');
        //return $this->belongsTo(Gudang::class);
    }
public function transaksi():HasMany
{
    return $this->hasMany(
        TransaksiStock::class,
        'stock_id',
        'id'
    );

}

#laravel <=  11
# ppublic function scopeHasBalance(Builder $query): void
#{
#  $query->where('balance', '>', 0);
#}

# laravel >= 12
#[Scope]
public function scopeHasBalance(Builder $query): Builder
{
    return $query->where('balance', '>', 0);
}

public function scopeNoBalance(Builder $query): Builder
{
    return $query->where('balance', '<=', 0);
}

}