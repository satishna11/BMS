<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Budget;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($expense) {
            // Find the budget for the same user, category, and month/year
            $month = date('F', strtotime($expense->date));
            $year = date('Y', strtotime($expense->date));

            $budget = Budget::where('user_id', $expense->user_id)
                ->where('category_id', $expense->category_id)
                ->where('month', $month)
                ->where('year', $year)
                ->first();

            if ($budget) {
                // Update spent_budget
                $budget->spent_budget += $expense->amount;
                // Remaining will be automatically recalculated in Budget's boot()
                $budget->save();
            }
        });
    }
}
