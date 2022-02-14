<?php

namespace App\Http\Resources\Fertilizer;

use Illuminate\Http\Resources\Json\JsonResource;

class FertilizerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fertilizer' => $this->fertilizer,
            'normN' => $this->normN,
            'normP' => $this->normP,
            'normK' => $this->normK,
            'culture_id' => $this->culture_id,
            'region' => $this->region,
            'price' => $this->price,
            'description' => $this->description,
            'purpose' => $this->purpose,
        ];
    }
}
