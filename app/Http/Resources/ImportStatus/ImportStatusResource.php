<?php

namespace App\Http\Resources\ImportStatus;

use Illuminate\Http\Resources\Json\JsonResource;

class ImportStatusResource extends JsonResource
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
            'status' => $this->status,
            'errors_array' => $this->errors_array,
            'data' => $this->data,
            'created_at' => $this->created_at,
            'user_id'=> $this->user->id,
            'user'=> $this->user->name
        ];
    }
}
