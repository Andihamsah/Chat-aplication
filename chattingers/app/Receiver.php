<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Receiver extends Model
{
    protected $fillable = [
        'text',
        'files',
        'receiver_id',
        'sender_id'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }
}
