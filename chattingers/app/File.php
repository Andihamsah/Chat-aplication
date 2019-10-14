<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;


class File extends Model
{
    protected $fillable = [
        'files'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
