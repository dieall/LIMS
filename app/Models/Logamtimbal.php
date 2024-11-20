<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logamtimbal extends Model
{
    use HasFactory;

    protected $table = 'logamtimbals'; 

    protected $fillable = [
        'nama_logamtimbal'
    ];
}
