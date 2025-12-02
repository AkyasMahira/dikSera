<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerawatProfile extends Model
{
    protected $table = 'perawat_profiles'; // pastikan sama dengan DB-mu

    protected $fillable = [
   'user_id',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'phone',
        'marital_status',
        'address',
        'office_address',
        'nip',
        'current_position',
        'work_unit',
        'last_education',
        'education_institution',
        'profile_photo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

  public function certificates()
{
    // sambungkan ke certificates lewat user_id yang sama
    return $this->hasMany(Certificate::class, 'user_id', 'user_id');
}

}
