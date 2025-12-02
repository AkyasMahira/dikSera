<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    // 🔹 pastikan sesuai dengan nama tabel di DB (biasanya 'educations')
    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'level',
        'institution',
        'city',
        'year_start',
        'year_end',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
