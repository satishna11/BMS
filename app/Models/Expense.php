<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Budget;
use App\Models\User;
use App\Models\Category;

class Expense extends Model
{
    use HasFactory;
 protected $table = 'expenses';
    protected $primaryKey = 'expense_id';
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description',
    ];

    // Updated relationship to match users.id
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

   protected static function boot()
{
    parent::boot();

    static::created(function ($expense) {
        // Normalize month format
        $month = ucfirst(strtolower(date('F', strtotime($expense->date))));
        $year  = date('Y', strtotime($expense->date));

        // Find budget for same user, category, month, year
        $budget = Budget::where('user_id', $expense->user_id)
            ->where('category_id', $expense->category_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($budget) {
            // Recalculate total spent from all expenses
            $budget->spent_budget = Expense::where('user_id', $expense->user_id)
                ->where('category_id', $expense->category_id)
                ->whereMonth('date', date('m', strtotime($expense->date)))
                ->whereYear('date', $year)
                ->sum('amount');

            $budget->save(); // remaining and status recalculated automatically in Budget model
        }
    });
}

}
