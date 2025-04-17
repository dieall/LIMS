<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRawmat extends Model
{
    use HasFactory;

    protected $table = 'tbr_rawmat';
    protected $primaryKey = 'id';
    
    // Add all the columns from your schema to the fillable array
    protected $fillable = [
        'nama',
        'nama_rawmat',
        'sn',
        'purity',
        'purity_tmac',
        'appreance',
        'sg',
        'fe_amo',
        'si_amo',
        'sh',
        'acid',
        'ri',
        'free',
        'ph',
        'fe',
        'si',
        'sulfur',
        'visual',
        'water',
        'color',
        'acidity',
        'lodine',
        'ag',
        'cu',
        'pb',
        'sb',
        'zn',
        'as',
        'ni',
        'bi',
        'cd',
        'ai',
        'pe',
        'ga',
        'densi',
        'clarity',
        'apha'
    ];

    // Define created_at and updated_at handling
    public $timestamps = true;
}
