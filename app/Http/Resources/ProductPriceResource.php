<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'price' => $this->price,
            'tax_cost' => $this->tax_cost,
            'currency' => [
                'id' => $this->currency->id,
                'name' => $this->currency->name,
                'symbol' => $this->currency->symbol,
                'exchange_rate' => $this->currency->exchange_rate,
            ]
        ];
    }
}

