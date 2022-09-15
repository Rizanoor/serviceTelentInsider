<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'city',
        'organization_size',
        'industry_id',
        'logo',
        'user_access',
    ];


    // Relasi
    public function jobs()
    {
        return $this->hasMany(Jobs::class, 'company_id', 'id');
    }
}
