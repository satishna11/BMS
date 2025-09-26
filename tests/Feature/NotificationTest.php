<?php

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('saves notification in database',function(){
$user=User::factory()->create();
    $notification=Notification::create([
       'message'=>'satishna',
       'user_id'=>$user->id,
       'status'=>'On Track',
       'date'=>now(),

    ]);
    $this->assertDatabaseHas('notification',[
        'notifiaction_id' => $notification->notifiaction_id,
        'message'=>'satishna',
        'status'=>'On Track',

    ]);

});
