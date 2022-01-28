<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
        'id'=>$this->id,
        'name'=>$this->name,
        'detail'=>$this->detail,
        'price'=>$this->price,
        'created_at'=>$this->created_at->format('Y/m/d'),
        'updated_at'=>$this->updated_at->format('Y/m/d')
       ];
    }
}
