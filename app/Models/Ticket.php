<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public $fillable = [
        'ticket',
        'food_name'
    ];

    public function stock()
    {
        return $this->belongsTo(Stocks::class, 'food_name', 'item');
    }
}
