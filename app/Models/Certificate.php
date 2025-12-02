<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificates';

    protected $fillable = [
        'user_id',
        'type',          // 'wajib' / 'pengembangan'
        'name',
        'description',
        'date_start',
        'date_end',
        'file_path',
    ];

    protected $casts = [
        'date_start' => 'date',
        'date_end'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
