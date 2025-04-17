<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanRawmat extends Model
{
    use HasFactory;
    
    // Table name
    protected $table = 'tbr_pengajuan';

    // Primary key
    protected $primaryKey = 'id';
    
    // Fillable attributes - all fields from the schema
    protected $fillable = [
        // Basic information
        'nama_rawmat',
        'nama',
        'batch',
        'supplier',
        'no_mobil',
        'coa',
        'desc',
        'tgl',
        'jam_masuk',
        'status',
        'user_id',
        
        // Chemical properties
        'sn',
        'purity',
        'purity_tmac',
        'appreance',
        'sg',
        'fe_amo',
        'si_amo',
        'sh',
        'acid',
        'ri',
        'free',
        'ph',
        'fe',
        'si',
        'sulfur',
        'visual',
        'water',
        'color',
        'acidity',
        'lodine',
        'ag',
        'cu',
        'pb',
        'sb',
        'zn',
        'as',
        'ni',
        'bi',
        'cd',
        'ai',
        'pe',
        'ga',
        'densi',
        'clarity',
        'apha',
        
        // Status fields for each property
        'sn_status',
        'purity_status',
        'purity_tmac_status',
        'appreance_status',
        'sg_status',
        'fe_amo_status',
        'si_amo_status',
        'sh_status',
        'acid_status',
        'ri_status',
        'free_status',
        'ph_status',
        'fe_status',
        'si_status',
        'sulfur_status',
        'visual_status',
        'water_status',
        'color_status',
        'acidity_status',
        'lodine_status',
        'ag_status',
        'cu_status',
        'pb_status',
        'sb_status',
        'zn_status',
        'as_status',
        'ni_status',
        'bi_status',
        'cd_status',
        'ai_status',
        'pe_status',
        'ga_status',
        'densi_status',
        'clarity_status',
        'apha_status',
    ];

    /**
     * Get the related raw material data.
     */
    public function datarawmat()
    {
        return $this->belongsTo(DataRawmat::class, 'nama_rawmat', 'nama_rawmat');
    }

    /**
     * Get the user who created this record.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all status history entries for this raw material.
     */
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class, 'pengajuan_rawmat_id', 'id');
    }

    /**
     * Get the user who last updated the status.
     */
    public function lastStatusUser()
    {
        return $this->hasOneThrough(
            User::class, 
            StatusHistory::class, 
            'pengajuan_rawmat_id', // Foreign key on StatusHistory table
            'id',                  // Foreign key on User table
            'id',                  // Local key on PengajuanRawmat table
            'user_id'              // Local key on StatusHistory table
        );
    }

    /**
     * Get the latest status entry.
     */
    public function latestStatus()
    {
        return $this->hasOne(StatusHistory::class, 'pengajuan_rawmat_id', 'id')
                    ->latest('changed_at');
    }
    
    /**
     * Check if this raw material has approved CoA.
     */
    public function hasApprovedCoa()
    {
        return $this->statusHistory()
                   ->where('status', 'CoA Approved')
                   ->exists();
    }
    
    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->tgl)->format('d F Y');
    }
}
