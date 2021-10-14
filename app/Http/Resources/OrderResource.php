<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'stock' => new StockResource($this->stock),
            'client' => new ClientResource($this->client),
            'state' => $this->state,
            'qte' => $this->qte,
            'cost_confirmation' => $this->cost_confirmation,
            'cost_delivery' => $this->cost_delivery,
            'cost' => $this->getCost(),
            'total' => $this->getTotal(),
            'net' => $this->getNet(),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
