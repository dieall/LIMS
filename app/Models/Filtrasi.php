<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filtrasi extends Model
{
    use HasFactory;

    protected $table = 'filtrasi'; 

    protected $fillable = [
        'nama_filtrasi'
    ];
}
