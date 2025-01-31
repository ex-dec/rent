<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{

    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
    ];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_ruang');
    }
}
