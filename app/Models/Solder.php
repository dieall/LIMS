<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solder extends Model
{
    use HasFactory;

       
    protected $table = 'solder'; 

    protected $fillable = [
        'nama_solder'
    ];
}
