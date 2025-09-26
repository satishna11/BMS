<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

protected $table='incomes';
    protected $primaryKey = "income_id"; // corrected name

    protected $fillable = [
        'amount',
        'source',
        'date',
        'user_id'
    ];

    // Relationship with User
    public function user()
    {
        // If users table has PK = id
        return $this->belongsTo(User::class, 'user_id', 'user_id');

        // If users table has PK = user_id
        // return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
