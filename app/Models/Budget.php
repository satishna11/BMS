<?php

namespace App\Models;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory;
    protected $table='budgets';
    protected $primaryKey='budget_id';
    protected $fillable=[
        'user_id',
        'year',
        'month',
        'planned_budget',
        'spent_budget',
        'remaining',
        'status',
        'category_id'

    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');

    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','category_id');
    }
protected static function boot()
{
    parent::boot();

    static::saving(function ($budget) {
        $budget->spent_budget = $budget->spent_budget ?? 0;
        $budget->remaining = $budget->planned_budget - $budget->spent_budget;

        if ($budget->remaining < 0) {
            $budget->status = 'Over Spent';
        } elseif ($budget->remaining == 0) {
            $budget->status = 'Completed';
        } else {
            $budget->status = 'Within Limit';
        }
    });

    static::saved(function ($budget) {
        if ($budget->remaining < 0 && $budget->user) {
            $budget->user->notify(new \App\Notifications\BudgetExceedNotify($budget));
        }
    });
}

}
