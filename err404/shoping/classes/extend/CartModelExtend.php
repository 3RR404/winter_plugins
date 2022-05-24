<?php

namespace Err404\Shoping\Classes\Extend;

use Lovata\OrdersShopaholic\Models\Cart;
use Winter\Storm\Database\Model;

class CartModelExtend
{
    public static function _extendMethod()
    {
        Cart::extend( function(Model $model){
            $model->addFillable(['company']);

            $model->jsonable[] = 'company';
        });
    }
}
