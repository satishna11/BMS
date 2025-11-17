<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expense;
use App\Models\Budget;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'name'
    ];

    // One category has many expenses
    public function expense()
    {
        return $this->hasMany(Expense::class, 'category_id', 'category_id');
    }

    // One category has many budgets
    public function budget()
    {
        return $this->hasMany(Budget::class, 'category_id', 'category_id');
    }
}
