<?php

namespace Err404\Shoping\Http\Resources;

class ShippingTypeResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'price_value'   => (float) $this->price_value,
            'preview_text'  => $this->preview_text,
            'property'      => $this->property,
            'api_class'     => $this->api_class,
            'shipping_restriction' => ShippingTypeRestrictionResource::collection(
                    $this->shipping_restriction
                ),
        ];
    }
}
