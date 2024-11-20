<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trial extends Model
{
    use HasFactory;

    protected $table = 'trial'; 

    protected $fillable = [
        'nama_trial'
    ];
}
