<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mixing extends Model
{
    use HasFactory;

    protected $table = 'mixing'; 

    protected $fillable = [
        'nama_mixing'
    ];
}
