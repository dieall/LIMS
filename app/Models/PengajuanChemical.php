<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanChemical extends Model
{
    use HasFactory;

    // Nama tabel sesuai dengan yang ada di database
    protected $table = 'tbc_pengajuan'; 

    // Primary key sesuai dengan tabel
    protected $primaryKey = 'id'; 

    // Mengatur agar primary key menggunakan auto-increment
    public $incrementing = true; 

    // Mengaktifkan timestamps untuk otomatis menangani created_at dan updated_at
    public $timestamps = true;

    // Daftar field yang dapat diisi menggunakan mass-assignment
    protected $fillable = [
        'nama_chemical',
        'nama',
        'tgl',
        'batch',
        'desc',
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
        'densi',
        'orang',
    ];

    // Relasi ke tabel DataChemical
    public function DataChemical()
    {
        return $this->hasOne(DataChemical::class, 'nama', 'nama'); 
        // Relasi berdasarkan 'nama'
    }

    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class, 'pengajuan_chemical_id');
    }

    public function lastStatusUser()
    {
            return $this->hasOneThrough(User::class, StatusHistory::class, 'pengajuan_chemical_id', 'id', 'id', 'user_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
