<?php

namespace Err404\Location\Http\Resources;

class StateResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'country' => CountryResource::collection(
                $this->country->where('is_enabled', true)->get()
            )
        ];
    }
}
