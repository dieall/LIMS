<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solar extends Model
{
    use HasFactory;

   
    protected $table = 'solar'; 

    protected $fillable = [
        'nama_solar'
    ];
}
