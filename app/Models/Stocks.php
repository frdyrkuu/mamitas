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
        'quantity',
        'cost',
        'retail',
        'image',
        'update_reason',
    ];

    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'food_name', 'item');
    }
}
