<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'tbl_history';
    protected $fillable = [
        'ticket',
        'cashier',
        'customer',
        'type',
        'sub_total',
        'tax',
        'cash',
        'total',
        'change'
    ];
}
