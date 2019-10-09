<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Receiver extends Model
{
    protected $fillable = [
        'text',
        'files',
        'receiver_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
