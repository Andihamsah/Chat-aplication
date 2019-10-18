<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Chat extends Model
{
    protected $guarded = [];

    public function fromContact()
    {
        return $this->hasOne(User::class,'id','sender_id');
    }
}
