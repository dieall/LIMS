<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSolder extends Model
{
    use HasFactory;

    protected $table = 'tbs_pengajuan'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'tgl',
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

    // Relasi ke StatusHistory
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class, 'pengajuan_solder_id');
    }

    // Relasi untuk mendapatkan nama pengguna yang terakhir melakukan perubahan status
    public function lastStatusUser()
    {
            return $this->hasOneThrough(User::class, StatusHistory::class, 'pengajuan_solder_id', 'id', 'id', 'user_id');
    }

    // Relasi ke model CategorySolder
    public function categorySolder()
    {
        return $this->belongsTo(CategorySolder::class, 'id_category');
    }

    // Relasi ke model Sncu
    public function sncu()
    {
        return $this->belongsTo(Sncu::class, 'id', 'id');
    }

    // Relasi ke model Snagcu
    public function snagcu()
    {
        return $this->belongsTo(Snagcu::class, 'id', 'id');
    }

    // Relasi ke model Snag
    public function snag()
    {
        return $this->belongsTo(Snag::class, 'id', 'id');
    }

    // Relasi ke model Tin
    public function tin()
    {
        return $this->belongsTo(Tin::class, 'id', 'id');
    }

    // Relasi ke model DataSolder
    public function dataSolder()
    {
        return $this->belongsTo(DataSolder::class, 'tipe_solder', 'tipe_solder');
    }
}
