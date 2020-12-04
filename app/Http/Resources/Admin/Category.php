<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'icon' => $this->icon,
            'children' => Category::collection($this->children),
            'attributesIds' => $this->attributes
        ];
    }
}
