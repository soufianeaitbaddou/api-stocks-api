<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->product),
            'qte' => $this->qte,
            'qte_left' => $this->qte_left,
            'price_purchase' => $this->price_purchase,
            'price_sale' => $this->price_sale,
            'cost_transport' => $this->cost_transport,
            'cost_package' => $this->cost_package,
            '_total' => $this->orders->sum(function($value) {
                return $value->getTotal();
            }),
           '_cost' => $this->orders->sum(function($value) {
                return $value->getCost();
            }),
           '_net' => $this->orders->sum(function($value) {
                return $value->getNet();
            }),

            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
