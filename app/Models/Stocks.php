<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'category',
        'supplier',
        'quantity',
        'product_unit',
        'description',
        'color',
        'sku',
        'size',
        'barcode',
        'cost',
        'retail',
        'image',
        'update_reason',
        'expiration_date',
        'item_promo',
    ];

    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'food_name', 'item');
    }

    public function adjustmentLogs()
    {
        return $this->hasMany(StockAdjustmentLog::class, 'stock_id');
    }
}
