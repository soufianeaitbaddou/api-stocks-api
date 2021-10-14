<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'city', 'tel'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id', 'id');
    }
}
