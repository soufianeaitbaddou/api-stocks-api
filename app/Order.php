<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const NEW_ORDER_STATUS = "NEW_ORDER";
    const CONFIRMED_STATUS = "CONFIRMED";
    const CANCELLED_STATUS = "CANCELLED";
    const DELIVERED_STATUS = "DELIVERED";
    const PAID_STATUS = "PAID";

    protected $fillable = [
        'stock_id', 'client_id', 'cost_confirmation', 'cost_delivery', 'qte', 'state'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function getCost()
    {
        return ($this->stock->price_purchase * $this->qte) + $this->cost_delivery +(($this->stock->cost_transport/$this->stock->qte) * $this->qte ) + $this->cost_confirmation + ( $this->stock->cost_package * $this->qte) ;
    }

    public function getTotal()
    {
        return $this->stock->price_sale * $this->qte;
    }

    public function getNet()
    {
        return $this->getTotal() - $this->getCost();
    }
}
