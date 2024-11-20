<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ri extends Model
{
    use HasFactory;

    
    protected $table = 'ri'; 

    protected $fillable = [
        'nama_ri'
    ];
}
