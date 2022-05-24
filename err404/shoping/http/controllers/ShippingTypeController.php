<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Event\ShopingHook;
use Illuminate\Support\Facades\Event;
use Lovata\OrdersShopaholic\Models\ShippingType;

class ShippingTypeController extends ShopingController
{

    public function handle()
    {
        $response = [];

        $shippingType = ShippingType::get();

        Event::fire('Err404.shoping.beforeReturnShippingType', [$shippingType]);

        $shippingResourceClass = config('err404.shoping::resources.shipping');
        $response = [
            'methods' => $shippingResourceClass::collection($shippingType),
        ];

        return $afterProcess = ShopingHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
    }
}
