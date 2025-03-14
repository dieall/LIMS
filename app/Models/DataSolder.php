<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSolder extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi penamaan Laravel, tentukan nama tabelnya
    protected $table = 'tbs_solder';

    // Jika kolom primary key berbeda, tentukan di sini
    protected $primaryKey = 'id'; // Nama kolom primary key

    
    protected $fillable = [
        'nama_kategori',
        'tipe_solder',
        'spesification',
        'tgl',
        'rev',
        'sn',
        'ag',
        'cu',
        'pb',
        'sb',
        'zn',
        'fe',
        'as',
        'ni',
        'bi',
        'cd',
        'ai',
        'pe',
        'ga',

    ];

    public function pengajuansolder()
    {
        return $this->belongsTo(PengajuanSolder::class, 'tipe_solder','tipe_solder');
    }

}

