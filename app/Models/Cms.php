<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;

    // Define which fields are mass-assignable
    protected $fillable = [
        'company_name',
        'company_logo',
        'company_description',
    ];
}
