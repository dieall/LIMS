<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataInterval extends Model
{
    use HasFactory;

    protected $table = 'status_histories'; 
    
    protected $fillable = [
        'pengajuan_solder_id',
        'pengajuan_chemical_id',
        'status',
        'changed_at',
        'rejection_reason',
        'user_id',
        'interval',
    ];

    // Relasi ke model PengajuanSolder
    
// Relasi ke model PengajuanSolder
public function pengajuanSolder()
{
    return $this->belongsTo(PengajuanSolder::class, 'pengajuan_solder_id');
}


    // Relasi ke model PengajuanChemical
    public function pengajuanChemical()
    {
        return $this->belongsTo(PengajuanChemical::class, 'pengajuan_chemical_id');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
