<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('saves categories in database',function(){

    $categories=Category::create([
       'name'=>'satishna',
    ]);
    $this->assertDatabaseHas('categories',[
        'category_id' => $categories->category_id,
        'name'=>'satishna',
    ]);

});
