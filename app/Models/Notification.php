<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
    protected $primaryKey='notification_id';

    protected $fillable=[
        'message',
        'status',
        'date',
        'user_id'
    ];
    public function user(){
        $this->belongsTo(User::class ,'user_id','user_id');
    }

}
