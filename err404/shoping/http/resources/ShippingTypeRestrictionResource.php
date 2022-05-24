<?php

namespace Err404\Shoping\Http\Resources;

use Lovata\OrdersShopaholic\Classes\Restriction\RestrictionByTotalPrice;
use Lovata\OrdersShopaholic\Classes\Restriction\ShippingRestrictionByPaymentMethod;
use Lovata\OrdersShopaholic\Models\PaymentMethod;

class ShippingTypeRestrictionResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        if ( $this->restriction === ShippingRestrictionByPaymentMethod::class )
        {
            $properties[] = $this->property['payment_method'];
            $payment_methods = [];

            foreach( $properties as $payment_method )
            {
                $payment_methods[] = new SimplyPaymentMethodResource(
                    PaymentMethod::where('id', $payment_method)->first()
                );
            }
        } else if ( $this->restriction === RestrictionByTotalPrice::class )
            $payment_methods = $this->restriction;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'property' => $payment_methods,
        ];
    }
}
