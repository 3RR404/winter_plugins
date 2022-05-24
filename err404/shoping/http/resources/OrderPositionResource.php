<?php

namespace Err404\Shoping\Http\Resources;

class OrderPositionResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $sItemType = $this->item_type;

        $obOffer = $sItemType::where('id', $this->item_id)->with('product')->first();

        if ( $sItemType == 'App\\CustomDimension\\Models\\CustomDimension' )
            $sResource = \App\CustomDimension\Http\Resources\CustomDimensionResource::class;
        else
            $sResource = SimpleOfferResource::class;

        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'offer' => new $sResource(
                $obOffer
            ),
            'product' => new SimpleProductResource(
                $obOffer->product
            ),
            'quantity' => $this->quantity,
        ];
    }
}
