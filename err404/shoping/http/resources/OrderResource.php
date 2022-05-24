<?php

namespace Err404\Shoping\Http\Resources;

class OrderResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'status' => [
                'name'          => $this->status->name,
                'code'          => $this->status->code,
                'color'         => $this->status->color,
                'preview_text'  => $this->status->preview_text,
            ],
            'order_number'      => $this->order_number,
            'secret_key'        => $this->secret_key,
            'shipping_price'    => $this->shipping_price_value,
            'payment_price'     => $this->payment_price_value,
            'user'              => $this->user,             // TODO: user resource
            'property'          => $this->property,         // TODO: order property resource
            'transaction_id'    => $this->transaction_id,
            'payment_token'     => $this->payment_token,
            'order_position'    => OrderPositionResource::collection(
                $this->order_position
            ),
            'order_offer'       => SimpleOrderOfferResource::collection(
                $this->order_offer
            ),
            'order_customdimension' => \App\CustomDimension\Http\Resources\SimpleCustomDimensionResource::collection(
                $this->order_customdimension
            ),
            'shipping_type'     => new SimplyShippingTypeResource(
                $this->shipping_type
            ),
            'payment_method'    => new SimplyPaymentMethodResource(
                $this->payment_method
            ),
            'order_total'       => $this->total_price_value,
            'created_at'        => $this->created_at,
        ];
    }
}
