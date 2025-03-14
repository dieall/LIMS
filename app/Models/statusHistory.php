<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusHistory extends Model
{
    protected $table = 'status_histories'; 
    protected $fillable = ['pengajuan_solder_id','pengajuan_chemical_id', 'status', 'changed_at','rejection_reason'];

    public function pengajuanSolder()
    {
        return $this->belongsTo(PengajuanSolder::class);
    }

    public function pengajuanchemical()
    {
        return $this->belongsTo(PengajuanChemical::class);
    }
    
}

