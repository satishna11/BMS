<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    protected $table='notification';
    use HasFactory;
    protected $primaryKey='notifiaction_id';

    protected $fillable=[
        'message',
        'status',
        'date',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class ,'user_id','user_id');
    }

}
