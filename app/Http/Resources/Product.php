<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->getTotalStock(),
            'images' => $this->getImages(),
            'category' => new Category($this->category),
            'attributes' => $this->stockAttributes()
        ];
    }
}
