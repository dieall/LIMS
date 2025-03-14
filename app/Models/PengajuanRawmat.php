<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanRawmat extends Model
{
    use HasFactory;
        // Jika nama tabel tidak mengikuti konvensi penamaan Laravel, tentukan nama tabelnya
        protected $table = 'tbr_pengajuan';

        // Jika kolom primary key berbeda, tentukan di sini
        protected $primaryKey = 'id'; // Nama kolom primary key
        protected $fillable = [

        'nama',
        'supplier',
        'spesifikasi',
        'satuan',
        'coa',
        'result',
        'tgl',


        ];
        public function datarawmat()
        {
            return $this->belongsTo(DataRawmat::class, 'id_rawmat', 'id_rawmat');
        }
}
