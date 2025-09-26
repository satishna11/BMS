<?php
use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('saves income in database',function(){
    $user=User::factory()->create();
    $income=Income::create([
        'user_id'=> $user->id,
        'source'=>'salary',
        'amount'=>2000,
        'date'=>now(),
    ]);
    $this->assertDatabaseHas('incomes',[
        'income_id'=>$income->income_id,
        'amount'=>2000,
        'source'=>'salary',
    ]);

});
