<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySolder extends Model
{
    use HasFactory;

    
    protected $table = 'category_solder'; // Nama tabel

    protected $primaryKey = 'id_category'; // Menentukan kolom primary key

    protected $fillable = [
        'id_category',
        'nama_kategori',
        'spesification',
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
        'mp',

        

    ];

    public function pengajuansolder()
    {
        return $this->hasMany(PengajuanSolder::class);
    }
}
