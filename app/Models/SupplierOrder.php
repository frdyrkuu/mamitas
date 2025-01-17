<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'batch_number',
        'quantity',
        'supplier',
        'status',
        'expiration_date'
    ];
}
