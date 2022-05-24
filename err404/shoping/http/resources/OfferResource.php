<?php

namespace Err404\Shoping\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OfferResource extends Resource
{
	public function toArray($request)
	{
		return [
			'id'	=> $this->id,
			'name' => $this->name,
			'code' => $this->code,
			'external_id' => $this->external_id,
			'price' => $this->price,
			'price_value' => (float) $this->price_value,
			'old_price' => $this->old_price,
			'old_price_value' => (float) $this->old_price_value,
			'quantity' => (int) $this->quantity,
			'price_list' => $this->price_list, // TODO: Change to pricelist resource
			'preview_text' => $this->preview_text,
			'description' => $this->description,
			'weight' => $this->weight,
			'height' => $this->height,
			'length' => $this->length,
			'width' => $this->width,
			'measure_of_unit_id' => $this->measure_of_unit_id, // TODO: Change id to measure resource
			'measure_id' => $this->measure_id, // TODO: Change id to measure resource
			'quantity_in_unit' => (int) $this->quantity_in_unit,
            'property'          => PropertyResource::collection(
                $this->property_value()->get()
            ),
            'product'           => SimpleProductResource::make(
                $this->product()->first()
            )
		];
	}
}
