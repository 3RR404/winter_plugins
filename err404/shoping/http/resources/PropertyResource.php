<?php

namespace Err404\Shoping\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PropertyResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->property->name,
            'slug'      => $this->property->slug,
            'value'     => $this->value->value,
//            'property'  => $this->property
        ];
    }
}
