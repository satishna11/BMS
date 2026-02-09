<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin \Laravel\Sanctum\HasApiTokens
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function income()
    {
        return $this->hasMany(Income::class, 'user_id', 'id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class, 'user_id', 'id');
    }

    public function budget()
    {
        return $this->hasOne(Budget::class, 'user_id', 'id');
    }


}
