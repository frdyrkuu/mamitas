<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'type',
        'amount',
        'charge'
    ];
}
