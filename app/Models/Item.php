<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'stok',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
