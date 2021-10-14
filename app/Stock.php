<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id', 'price_purchase', 'price_sale', 'cost_transport', 'cost_package','qte_left','qte',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'stock_id', 'id');
    }
     
}
