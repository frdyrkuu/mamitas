<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Authentication extends Authenticatable
{
    use HasFactory;
    protected $table = 'tbl_cashiers';

    protected $fillable = [
        'name',
        'password',
        'role'
    ];

}
