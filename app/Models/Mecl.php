<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecl extends Model
{
    use HasFactory;

        
    protected $table = 'mecl'; 

    protected $fillable = [
        'nama_mecl'
    ];
}
