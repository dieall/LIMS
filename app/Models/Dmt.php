<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dmt extends Model
{
    use HasFactory;


    // Jika nama tabel tidak mengikuti konvensi penamaan Laravel, tentukan nama tabelnya
    protected $table = 'tb_dmt';

    // Jika kolom primary key berbeda, tentukan di sini
    protected $primaryKey = 'idx'; // Nama kolom primary key

    protected $keyType = 'string'; // Menentukan bahwa id adalah string

    public $incrementing = false; // Mengindikasikan bahwa id bukan auto-increment

    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'id_category',
        'id_transaksi',
        'tgl',
        'ape',
        'solid',
        'tinc',
        'monomet',
        'trime',
        'cloride',
        'spec',
        'dimet',
        'moisture',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }
    

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
    

}
