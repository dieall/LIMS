<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentData extends Model
{
    use HasFactory;

    // Tabel yang digunakan
    protected $table = 'instrument_data';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_instrument', 'changed_at', 'updated_at',
    ];

    // Menonaktifkan auto timestamp
    public $timestamps = false;

    // Relasi dengan model Instrument
    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'id'); // instrument_id adalah kolom foreign key di instrument_data
    }
}
