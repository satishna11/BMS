<?php

namespace App\Models;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory;
    protected $table="expense";
    protected $primaryKey='expense_id';
    protected $fillable=[
        'user_id',
        'category_id',
        'amount',
        'date'

    ];
 // Relationship with User
    public function user()
    {
        // If users table has PK = id
        return $this->belongsTo(User::class, 'user_id', 'user_id');

        // If users table has PK = user_id
        // return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
     public function category()
    {
        // If users table has PK = id
        return $this->belongsTo(Category::class, 'category_id', 'category_id');

        // If users table has PK = user_id
        // return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
