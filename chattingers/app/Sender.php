<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Sender extends Model
{
    protected $fillable = [
        'text',
        'files',
        'sender_id'
    ];

    public function users()
    {

        return $this->hasMany(User::class);

    }
}
