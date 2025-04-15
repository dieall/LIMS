<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'tb_instrument';

    // Menentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'nama_instrument',
        'kondisi',
        'keterangan',
        'tgl',
        'shift',
        'jam',
        'nama', // Menyimpan nama operator, bukan lagi user_id
    ];

    // Mendefinisikan relasi ke model User - REMOVED since we no longer use user_id
    
    // Relasi dengan model InstrumentData (One-to-Many)
    public function instrumentData()
    {
        return $this->hasMany(InstrumentData::class);
    }
}
