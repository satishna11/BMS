<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';
    use HasFactory;

    protected $primaryKey='category_id';
    protected $fillable=[
        'name'
    ];
   public function expense()
    {
        return $this->hasMany(Expense::class,'category_id','category_id');
    }

}
