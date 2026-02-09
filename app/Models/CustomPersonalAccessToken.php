<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPersonalAccessToken extends Model
{
    //
     public function tokenable()
    {
        return $this->morphTo('tokenable', 'tokenable_type', 'tokenable_id');
    }
}
