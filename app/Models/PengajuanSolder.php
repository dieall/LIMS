<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSolder extends Model
{
    use HasFactory;

    protected $table = 'tbs_pengajuan'; 

    protected $fillable = [
        'nama',
        'tgl',
        'nama',
        'tipe_solder',
        'batch',
        'audit_trail',
        'jam_masuk',
        'id_category',


    ];

    public function categorysolder()
    {
        return $this->belongsTo(CategorySolder::class, 'id_category', 'id_category');
    }

    public function sncu()
    {
        return $this->belongsTo(Sncu::class, 'id', 'id');
    }
    public function snagcu()
    {
        return $this->belongsTo(Snagcu::class, 'id', 'id');
    }
    public function snag()
    {
        return $this->belongsTo(Snag::class, 'id', 'id');
    }
    
    public function tin()
    {
        return $this->belongsTo(Tin::class, 'id', 'id');
    }
    
}
