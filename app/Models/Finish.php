<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    use HasFactory;

    protected $table = 'finish'; 

    protected $fillable = [
        'nama_finish'
    ];
}
