<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'result'; 

    protected $fillable = [
        
        'id',
        'result',
        'id_transaksi',
        'id_category',

    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function tc191()
    {
        return $this->belongsTo(Tc191::class, 'id_tc191', 'id_tc191');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id', 'id_transaksi');
    }

    public function tc192f()
    {
        return $this->belongsTo(Transaksi::class, 'id_tc192f', 'id_tc192f');
    }

}
