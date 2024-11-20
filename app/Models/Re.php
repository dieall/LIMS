<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Re extends Model
{
    use HasFactory;

    protected $table = 'res'; 

    protected $fillable = [
        'nama_re'
    ];
}
