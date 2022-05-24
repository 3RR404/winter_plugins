<?php

namespace Err404\Shoping\Http\Resources;


class WishlistResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
        ];
    }
}
