<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Sender extends Model
{
    protected $fillable = [
        'text',
        'files',
        'sender_id',
        'receiver_id'
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
