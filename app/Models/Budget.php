<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';
    protected $primaryKey = 'budget_id';
    protected $fillable = [
        'user_id',
        'year',
        'month',
        'planned_budget',
        'spent_budget',
        'remaining',
        'status',
        'category_id'
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

    static::saving(function ($budget) {
        $budget->spent_budget = $budget->spent_budget ?? 0;
        $budget->remaining = $budget->planned_budget - $budget->spent_budget;

        // Only allowed ENUM values
        $budget->status = $budget->remaining >= 0 ? 'On Track' : 'Overspent';
    });

    static::saved(function ($budget) {
        if ($budget->remaining < 0 && $budget->user) {
            $budget->user->notify(new \App\Notifications\BudgetExceedNotify($budget));
        }
    });
}

}
