<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'manufacturing_cost' => $this->manufacturing_cost,
            'prices' => ProductPriceResource::collection($this->whenLoaded('prices')),
        ];
    }
}
