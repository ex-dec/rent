<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $fillable = [
        'nama',
        'kondisi',
        'keterangan',
        'jumlah',
        'jenis_id',
        'tanggal_register',
        'ruang_id',
        'kode_inventaris',
        'user_id',
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($inventaris) {
            $inventaris->user_id = Auth::id();
        });
    }
}
