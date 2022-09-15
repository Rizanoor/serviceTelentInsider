<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'attachment',
        'user_id',
    ];

    public function user_jobs()
    {
        return $this->hasMany(User_jobs::class, 'resume_id', 'attachment');
    }
}
