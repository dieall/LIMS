<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; 

    protected $fillable = [

        'tgl',
        'id_category',
        'tipe_sampel',
        'batch',
        'deskripsi',
        'nama',
        'audit_trail',
        'jam_masuk',

    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }


    public function tinstab()
    {
        return $this->hasMany(Tinstab::class);
    }

    
    public function dmt()
    {
        return $this->hasMany(Dmt::class);
    }

    public function tinchem()
    {
        return $this->hasMany(Tinchem::class);
    }
}

