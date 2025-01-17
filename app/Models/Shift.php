<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'tbl_shifts';

    protected $fillable = [
        'cashier',
        'POS_number',
        'starting_cash',
        'closing_cash',
        'cash_in',
        'cash_out'
    ];
}
