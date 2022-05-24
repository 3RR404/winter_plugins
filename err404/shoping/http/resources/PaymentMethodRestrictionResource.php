<?php

namespace Err404\Shoping\Http\Resources;

use Lovata\OrdersShopaholic\Classes\Restriction\PaymentRestrictionByShippingType;
use Lovata\OrdersShopaholic\Classes\Restriction\RestrictionByTotalPrice;
use Lovata\OrdersShopaholic\Models\ShippingType;

class PaymentMethodRestrictionResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $shipping_types = [];

        if ( $this->restriction === PaymentRestrictionByShippingType::class )
        {
            $properties[] = $this->property['shipping_type'];

            foreach( $properties as $shipping_id )
            {
                $shipping_types[] = new SimplyShippingTypeResource(
                    ShippingType::where('id', $shipping_id)->first()
                );
            }

        } else if ( $this->restriction === RestrictionByTotalPrice::class )
            $shipping_types = $this->restriction;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'property' => $shipping_types,
        ];
    }
}
