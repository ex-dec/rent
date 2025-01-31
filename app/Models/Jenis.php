<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';

    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
    ];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_jenis');
    }
}
