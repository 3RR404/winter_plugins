<?php

namespace Err404\Shoping\Http\Controllers;

use Illuminate\Routing\Controller;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Product;
use Lovata\WishListShopaholic\Classes\Helper\WishListHelper;

class UserController extends Controller
{
    public function onWishlist()
    {
        /** @var WishListHelper $obWishListHelper */
        $obWishListHelper = app(WishListHelper::class);

        $arProductIDList = $obWishListHelper->getList();

        /** @var \Err404\Shoping\Http\Resources\ProductResource $sResourceClass */
        $sResourceClass = config('err404.shoping::resources.product');

        return $sResourceClass::collection(
            Product::whereIn('id', $arProductIDList)
                ->get()
        );
    }
}
