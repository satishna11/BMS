<?php
use App\Models\Saving;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('saves saving in database',function(){
    $user=User::factory()->create();
    $saving=Saving::create([
        'user_id'=> $user->id,
        'goal'=>'maintain budget',
        'target_amount'=>2000,
         'amount'=>1000,
    ]);
    $this->assertDatabaseHas('saving',[
        'saving_id'=>$saving->saving_id,
        'amount'=>1000,
        'goal'=>'maintain budget',
        'target_amount'=>2000,
    ]);

});
