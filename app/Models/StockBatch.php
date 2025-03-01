<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBatch extends Model
{
    protected $fillable = [
        'stock_id',
        'batch_number',
        'quantity',
        'manufacturing_date',
        'expiration_date'
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiration_date' => 'date'
    ];

    public function stock()
    {
        return $this->belongsTo(Stocks::class);
    }
} 