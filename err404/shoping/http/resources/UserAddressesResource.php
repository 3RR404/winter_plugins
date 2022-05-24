<?php

namespace Err404\Shoping\Http\Resources;

use Err404\Location\Http\Resources\CountryResource;
use Winter\Storm\Support\Facades\Event;

class UserAddressesResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $arAddresses = [
            "id"        => $this->id,
            "country"   => $this->country()->first(),
            "state"     => $this->state,
            "city"      => $this->city,
            "street"    => $this->street,
            "house"     => $this->house,
            "building"  => $this->building,
            "flat"      => $this->flat,
            "floor"     => $this->floor,
            "address1"  => $this->address1,
            "address2"  => $this->address2,
            "postcode"  => $this->postcode,
        ];

        Event::fire('err404.shoping.user.beforeReturnResource', [&$arAddresses, $this->resource]);

        return $arAddresses;
    }
}
