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
        'user_id', // Menyimpan ID User
    ];

    // Mendefinisikan relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi ke tabel users berdasarkan user_id
    }
        // Relasi dengan model InstrumentData (One-to-Many)
    public function instrumentData()
    {
        return $this->hasMany(InstrumentData::class); // Relasi one-to-many ke InstrumentData
    }
}
