<?php

namespace Err404\Location\Http\Resources;

class SimpleStateResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code
        ];
    }
}
