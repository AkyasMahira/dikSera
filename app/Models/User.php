<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN        = 'admin';
    const ROLE_PERAWAT      = 'perawat';
    const ROLE_PEWAWANCARA  = 'pewawancara';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perawatProfile()
    {
        return $this->hasOne(PerawatProfile::class);
    }

    public function certificates()
    {
        // FK: certificates.user_id -> users.id
        return $this->hasMany(Certificate::class, 'user_id');
    }
}
