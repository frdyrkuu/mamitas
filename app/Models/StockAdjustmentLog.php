<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustmentLog extends Model
{
    protected $fillable = [
        'stock_id',
        'adjustment_type',
        'quantity',
        'old_quantity',
        'new_quantity',
        'reason',
        'adjusted_by'
    ];

    public function stock()
    {
        return $this->belongsTo(Stocks::class, 'stock_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
} 