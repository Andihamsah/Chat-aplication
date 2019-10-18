<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Friend extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'telp','avatar','user_id'
    ];

    public function users() 
    {
        return belongsTo(User::class,'user_id');
    }
}
