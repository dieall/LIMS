<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nh3 extends Model
{
    use HasFactory;

    protected $table = 'nh3'; 

    protected $fillable = [
        'nama_nh3'
    ];
}
