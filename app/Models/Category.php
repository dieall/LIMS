<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; // Nama tabel

    protected $primaryKey = 'id_category'; // Menentukan kolom primary key

    protected $fillable = [
        'id',
        'nama_kategori',
        

    ];


  

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }


    public function result()
    {
        return $this->hasMany(Result::class);
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
