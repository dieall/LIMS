<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataThermo extends Model
{
    // Tentukan nama tabel yang akan digunakan oleh model ini
    protected $table = 'tbt_thermo';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'tgl', 
        'waktu', 
        'nama_thermo', 
        'suhu', 
        'kelembapan', 
        'user_id'
    ];

    // Tentukan kolom yang tidak dapat diisi (mass assignable)
    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    // Tentukan format timestamp untuk model ini
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Jika Anda ingin menggunakan timestamp untuk 'created_at' dan 'updated_at'
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi ke tabel users berdasarkan user_id
    }
    public function ThermoData()
    {
        return $this->hasMany(ThermoData::class); // Relasi one-to-many ke InstrumentData
    }
}
