<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sncu extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi penamaan Laravel, tentukan nama tabelnya
    protected $table = 'tbs_sncu';

    // Jika kolom primary key berbeda, tentukan di sini
    protected $primaryKey = 'id'; // Nama kolom primary key

    
    protected $fillable = [
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
        'mp',
 
    ];

    
    public function pengajuansolder()
    {
        return $this->hasMany(PengajuanSolder::class);
    }
}