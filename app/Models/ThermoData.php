<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThermoData extends Model
{
    // Menentukan nama tabel
    protected $table = 'thermo_data';

    // Menentukan kolom yang bisa diisi
    protected $fillable = ['nama_thermo'];

    // Jika Anda ingin menonaktifkan timestamp otomatis (jika tidak menggunakan created_at dan updated_at)
    public $timestamps = true;


    public function datathermo()
    {
        return $this->belongsTo(DataThermo::class, 'id'); // instrument_id adalah kolom foreign key di instrument_data
    }
}
