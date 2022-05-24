<?php

namespace Err404\Shoping\Http\Resources;

use Lovata\Shopaholic\Models\Price;

class SimpleOrderOfferResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id'	=> $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'preview_text' => $this->preview_text,
            'description' => $this->description,
            'price' => $this->price,
            'price_value' => (float) $this->price_value,
            'old_price' => $this->old_price,
            'old_price_value' => (float) $this->old_price_value,
            'quantity' => (int) $this->quantity,
            'measure_of_unit_id' => $this->measure_of_unit_id,
            'quantity_in_unit' => (int) $this->quantity_in_unit,
        ];
    }
}
