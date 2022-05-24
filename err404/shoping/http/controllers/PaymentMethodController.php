<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Event\ShopingHook;
use Illuminate\Support\Facades\Event;
use Lovata\OrdersShopaholic\Models\PaymentMethod;

class PaymentMethodController extends ShopingController
{

    public function handle()
    {
        $response = [];

        $paymentMethods = PaymentMethod::get();

        Event::fire('Err404.shoping.beforeReturnPaymentMethod', [$paymentMethods]);

        $paymentResourceClass = config('err404.shoping::resources.payment');
        $response = [
            'methods' => $paymentResourceClass::collection($paymentMethods),
        ];

        return $afterProcess = ShopingHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
    }
}
