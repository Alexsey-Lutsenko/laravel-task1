<?php

namespace App\Http\Resources\Culture;

use Illuminate\Http\Resources\Json\JsonResource;

class CultureResource extends JsonResource
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
            'culture' => $this->culture
        ];
    }
}
