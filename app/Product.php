<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'varient'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }
}
