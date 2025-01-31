<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'status_peminjaman',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPinjam()
    {
        return $this->hasMany(DetailPinjam::class, 'id_peminjaman');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
            $peminjaman->status_peminjaman = 'dipinjam';
        });
    }
}
