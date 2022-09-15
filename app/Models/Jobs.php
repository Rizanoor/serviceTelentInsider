<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jobs_title',
        'companies_id',
        'location',
        'workspace_type',
        'min_salary',
        'max_salary',
    ];

    // Relasi
    public function user_jobs()
    {
        return $this->hasMany(User_jobs::class, 'jobs_id', 'id');
    }

}
