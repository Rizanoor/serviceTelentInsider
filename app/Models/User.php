<?php

namespace App\Models;

use App\Models\User_jobs;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'about',
        'photo',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

     // Relasi
     public function user_jobs()
     {
         return $this->hasMany(User_jobs::class, 'user_id', 'id');
     }

     public function company()
     {
         return $this->hasOne(Company::class, 'user_access', 'id');
     }

     public function resume()
     {
         return $this->hasMany(Resume::class, 'user_id', 'id');
     }
}
