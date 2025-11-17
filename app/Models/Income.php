<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';
    protected $primaryKey = 'income_id'; // corrected name

    protected $fillable = [
        'amount',
        'source',
        'date',
        'user_id'
    ];

    // Relationship with User
    public function user()
    {
        // Updated to match users.id
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
