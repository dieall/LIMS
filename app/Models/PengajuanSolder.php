<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSolder extends Model
{
    use HasFactory;

    protected $table = 'tbs_pengajuan'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key

        // Mengaktifkan timestamps untuk otomatis menangani created_at dan updated_at
        public $timestamps = true;

    protected $fillable = [
        'nama',
        'tgl',
        'nama',
        'tipe_solder',
        'batch',
        'audit_trail',
        'jam_masuk',
        'id_category',
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
        'status',



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

    public function datasolder()
    {
        return $this->belongsTo(DataSolder::class, 'tipe_solder', 'tipe_solder');
    }
    
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class, 'pengajuan_solder_id');
    }
    
}
