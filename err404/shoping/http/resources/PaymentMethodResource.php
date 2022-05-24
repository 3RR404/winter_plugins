<?php

namespace Err404\Shoping\Http\Resources;

class PaymentMethodResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'code'                  => $this->code,
            'preview_text'          => $this->preview_text,
            'price_value'           => (float) $this->price_value,
            'payment_restriction'   => PaymentMethodRestrictionResource::collection(
                $this->payment_restriction()->where('active', true)->get()
            ),
        ];
    }
}
