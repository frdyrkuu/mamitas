<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'item',
        'category',
        'supplier',
        'product_unit',
        'color',
        'size',
        'barcode',
        'quantity',
        'cost',
        'retail',
    ];
}
