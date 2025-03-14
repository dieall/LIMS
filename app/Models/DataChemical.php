<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataChemical extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi penamaan Laravel, tentukan nama tabelnya
    protected $table = 'tbc_chemical';

    // Jika kolom primary key berbeda, tentukan di sini
    protected $primaryKey = 'id'; // Nama kolom primary key

    
    protected $fillable = [
        'nama',
        'kategori',
        'tgl',
        'batch',
        'desc',
        'orang',
        'status',
        'clarity',
        'transmission',
        'ape',
        'dimet',
        'trime',
        'tin',
        'solid',
        'ri',
        'sg',
        'acid',
        'sulfur',
        'water',
        'mono',
        'yellow',
        'eh',
        'visco',
        'pt',
        'moisture',
        'cloride',
        'spec',
        'cla',
        'densi',

        

    ];


    public function PengajuanChemical()
    {
        return $this->belongsTo(PengajuanChemical::class, 'nama', 'nama'); 
        // Relasi berdasarkan 'nama'
    }
}
