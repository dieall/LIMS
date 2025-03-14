<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rtinchemical extends Model
{
    use HasFactory;

    protected $table = 'tbr_logam1'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key
    public $timestamps = true; // Nonaktifkan timestamps jika tidak digunakan

    protected $fillable = [
        'nama_kategori',
        'tipe_rawmat',
        'nama',
        'sn',
        'cu',
        'pb',
        'sb',
        'bi',
        'cd',
        'ai',
        'ag',
        'as',
        'fe',
        'ni',
        'ge',
        'in',
        'zn',
        'pe',
        'sn_b',
        'cu_b',
        'pb_b',
        'sb_b',
        'bi_b',
        'cd_b',
        'ai_b',
        'ag_b',
        'as_b',
        'fe_b',
        'ni_b',
        'ge_b',
        'in_b',
        'zn_b',
        'pe_b',
        'purity_mecl',
        'appreance_tmac',
        'purity_tmac',
        'appreance_ammo',
        'purity_ammo',
        'specific_ammo',
        'iron_ammo',
        'chlorides_ammo',
        'heavy_ammo',
        'appreance_ehtg',
        'chroma_ehtg',
        'purity_ehtg',
        'sh_ehtg',
        'refractive_ehtg',
        'acid_ehtg',
        'free_ehtg',
        'appreance_dpdp',
        'specific_dpdp',
        'refractive_dpdp',


    ];
}
