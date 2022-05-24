<?php

namespace Err404\Shoping\Classes\Extend;

use Err404\Shoping\Http\Resources\OrderResource;
use Err404\Shoping\Http\Resources\UserAddressesResource;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\Ordersshopaholic\Models\UserAddress;
use Winter\Storm\Support\Facades\Event;

class UserResourceExtend
{
    public static function _extendResource()
    {
        Event::listen('err404.user.user.beforeReturnResource', function (&$arUserData, $obUser) {

            $arUserData['user_address'] = [
                'billing'   => UserAddressesResource::collection(
                    UserAddress::getByUser($obUser->id)
                        ->where('type', 'billing')
                        ->get()
                ),
                'shipping'  => UserAddressesResource::collection(
                    UserAddress::getByUser($obUser->id)
                        ->where('type', 'shipping')
                        ->get()
                ),
            ];
            $arUserData['orders'] = OrderResource::collection(
                Order::where('user_id', $obUser->id)->orderBy('created_at', 'DESC')->get()
            );
        });
    }
}
