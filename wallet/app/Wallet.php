<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'id','palabras','email', 'private_key','plata','fecha',
    ];
}
