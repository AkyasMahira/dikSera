<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'lembaga',
        'tanggal_mulai',
        'tanggal_akhir',
        'file_path',
        'keterangan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
