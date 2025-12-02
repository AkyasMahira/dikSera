<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'institution',
        'year_start',
        'year_end',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
