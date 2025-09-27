<?php
use App\Models\Expense;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('saves income in database',function(){
    $user=User::factory()->create();
    $Category=Category::factory()->create();
    $expense=Expense::create([
        'user_id'=> $user->id,
        'category_id'=> $Category->category_id,
        'source'=>'salary',
        'amount'=>2000,
        'date'=>now(),
    ]);
    $this->assertDatabaseHas('expense',[
        'expense_id'=>$expense->expense_id,
        'amount'=>2000,
        'category_id'=>$Category->category_id,
    ]);

});


