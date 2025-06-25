<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'aktif'];

    public function stocks(): HasMany
    {
        return $this->hasMany(\App\Models\Stock::class, 'gudang_id', 'id');
    }
}
