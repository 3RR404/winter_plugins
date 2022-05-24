<?php

namespace Err404\Shoping\Http\Controllers;

use App\CustomDimension\Classes\Processor\CustomDimensionCartPositionProcessor;
use Err404\Shoping\Classes\Processor\CartProcessor;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Classes\Item\PaymentMethodItem;
use Lovata\OrdersShopaholic\Classes\Item\ShippingTypeItem;
use Lovata\OrdersShopaholic\Classes\Processor\OfferCartPositionProcessor;
use Lovata\WishListShopaholic\Classes\Helper\WishListHelper;
use Winter\Storm\Support\Facades\Input;

class CartController extends ShopingController
{
    public function handle()
    {
        $cartProccessor = CartProcessor::instance();

        Result::setData($cartProccessor->getCartData());

        return Result::get();

    }

    public function onAdd()
    {

        $arRequestData['quantity'] = Input::get('quantity');
        $sType = OfferCartPositionProcessor::class;

        if ( @Input::get('offer_id') )
            $arRequestData['offer_id'] = Input::get('offer_id');

        else if ( @Input::get('custom_dimension_id') ) {
            $arRequestData['offer_id'] = Input::get('custom_dimension_id');
            $arRequestData['flat'] = @Input::get('flat') ?? 0;
            $sType = CustomDimensionCartPositionProcessor::class;
        }

        CartProcessor::instance()->add([$arRequestData], $sType);

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();

    }

    /**
     * Update cart
     * @return array
     */
    public function onUpdate()
    {
        $arRequestData['quantity'] = Input::get('quantity');
        $sType = OfferCartPositionProcessor::class;

        if ( @Input::get('offer_id') )
            $arRequestData['offer_id'] = Input::get('offer_id');

        else if ( @Input::get('custom_dimension_id') ) {
            $arRequestData['offer_id'] = Input::get('custom_dimension_id');
            $arRequestData['flat'] = @Input::get('flat') ?? 0;
            $sType = CustomDimensionCartPositionProcessor::class;
        }

        CartProcessor::instance()->update([$arRequestData], $sType);

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function onRemove()
    {
        $arRequestData = [
            [
                'offer_id' => get('offer_id')
            ]
        ];
        $sType = get('type');

        if ( $sType === 'offer')
            $sPossitionProcessor = OfferCartPositionProcessor::class;
        elseif ( $sType === 'customdimension' )
            $sPossitionProcessor = CustomDimensionCartPositionProcessor::class;

        CartProcessor::instance()->remove($arRequestData, $sPossitionProcessor, $sType);
        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function onClear()
    {
        CartProcessor::instance()->clear();

        Result::setData(CartProcessor::instance()->getCartData());
        return Result::get();
    }

    public function addShippingType( $key = null )
    {
        $shippingTypeID = @$key ?: get('shipping_type_id');

        if ( $shippingTypeID == null )
        {
            CartProcessor::instance()->setActiveShippingType(null);
            Result::setData(CartProcessor::instance()->getCartData());
            return Result::get();
        }

        $obShippingTypeItem = ShippingTypeItem::make($shippingTypeID);

        if ( $obShippingTypeItem->isEmpty() )
        {
            $sMessage = \Lang::get('lovata.toolbox::lang.message.e_not_correct_request');
            Result::setFalse()->setMessage($sMessage);
            return Result::get();
        }

        CartProcessor::instance()->setActiveShippingType($obShippingTypeItem);

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function addPaymentMethod( $key = null )
    {
        $paymentMethodID = @$key ?: get('payment_method_id');

        if ($paymentMethodID == null)
            CartProcessor::instance()->setActivePaymentMethod(null);
        else {
            $paymentMethodItem = PaymentMethodItem::make($paymentMethodID);

            CartProcessor::instance()->setActivePaymentMethod($paymentMethodItem);
        }

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function onAddBillingAddress()
    {
        $arBillingAddress = Input::post('billing_address');

        CartProcessor::instance()->addBillingAddress($arBillingAddress);

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function onAddShippingAddress()
    {
        $arShippingAddress = Input::post('shipping_address');

        CartProcessor::instance()->addShippingAddress($arShippingAddress);

        Result::setData(CartProcessor::instance()->getCartData());

        return Result::get();
    }

    public function onAddToWishlist()
    {
        $iProductID = Input::get('product_id');

        /** @var WishListHelper $obWishListHelper */
        $obWishListHelper = app(WishListHelper::class);

        $obWishListHelper->add($iProductID);
        $arProductIDList = $obWishListHelper->getList();

        return $arProductIDList;
    }

    public function onRemoveFromWishList()
    {
        $iProductID = Input::get('product_id');

        /** @var WishListHelper $obWishListHelper */
        $obWishListHelper = app(WishListHelper::class);

        $obWishListHelper->remove($iProductID);
        $arProductIDList = $obWishListHelper->getList();

        return $arProductIDList;
    }

    public function onClearWishList()
    {
        /** @var WishListHelper $obWishListHelper */
        $obWishListHelper = app(WishListHelper::class);

        $obWishListHelper->clear();
    }

}
