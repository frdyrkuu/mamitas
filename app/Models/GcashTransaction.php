<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'sender_name',
        'amount',
        'ticket_number',
        'transaction_date'
    ];

    // No relationships needed since it's independent
}