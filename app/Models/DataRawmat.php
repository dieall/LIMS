<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRawmat extends Model
{
    use HasFactory;

    protected $table = 'tbr_rawmat';

    // Jika kolom primary key berbeda, tentukan di sini
    protected $primaryKey = 'id_rawmat'; // Nama kolom primary key

        
    protected $fillable = [
        'nama',
        'supplier',
    ];

}
