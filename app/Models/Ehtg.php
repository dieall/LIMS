<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ehtg extends Model
{
    use HasFactory;
    protected $table = 'ehtgs'; 

    protected $fillable = [
        'nama_ehtg'
    ];
}
