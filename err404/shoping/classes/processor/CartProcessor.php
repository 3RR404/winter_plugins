<?php

namespace Err404\Shoping\Classes\Processor;

use App\CustomDimension\Classes\Promomechanism\CartPromoMechanismProcessor;
use App\CustomDimension\Http\Resources\CustomDimensionResource;
use App\CustomDimension\Models\CustomDimension;
use Err404\Shoping\Http\Resources\OfferResource;
use Err404\User\Facades\JWTAuth;
use Lovata\OrdersShopaholic\Classes\Collection\CartPositionCollection;
use Lovata\OrdersShopaholic\Classes\Item\PaymentMethodItem;
use Lovata\OrdersShopaholic\Classes\PromoMechanism\ItemPriceContainer;
use Lovata\OrdersShopaholic\Models\CartPosition;
use Lovata\Ordersshopaholic\Models\UserAddress;
use Lovata\Shopaholic\Models\Offer;

class CartProcessor extends \Lovata\OrdersShopaholic\Classes\Processor\CartProcessor
{

    protected function init()
    {
        if( JWTAuth::check() )
            $this->obUser = JWTAuth::getUser();

        parent::init();
    }

    /**
     * Set active shipping type
     * @param \Lovata\OrdersShopaholic\Classes\Item\ShippingTypeItem $obShippingTypeItem
     */
    public function setActiveShippingType($obShippingTypeItem)
    {

        if ($obShippingTypeItem === null)
        {
            $this->obCart->update(
                ['shipping_type_id' => null]
            );
            return;
        }

        parent::setActiveShippingType($obShippingTypeItem);

        $this->obCart->update(
            ['shipping_type_id' => $obShippingTypeItem->id]
        );
    }

    /**
     * Set active payment method
     * @param \Lovata\OrdersShopaholic\Classes\Item\PaymentMethodItem $obPaymentMethodItem
     */
    public function setActivePaymentMethod($obPaymentMethodItem)
    {
        if ( $obPaymentMethodItem === null )
        {
            $this->obCart->update(
                ['payment_method_id' => null]
            );
            return;
        }

        parent::setActivePaymentMethod($obPaymentMethodItem);

        $this->obCart->update(
            ['payment_method_id' => $obPaymentMethodItem->id]
        );
    }

    /**
     * Init selected payment method
     */
    protected function initPaymentMethodItem()
    {
        if (empty($this->obCart) || !empty($this->obPaymentMethodItem) || empty($this->obCart->payment_method_id)) {
            return;
        }

        $this->obPaymentMethodItem = PaymentMethodItem::make($this->obCart->payment_method_id);
        if ($this->obPaymentMethodItem->isEmpty()) {
            $this->obPaymentMethodItem = null;
        }
    }

    /**
     * Get cart data
     * @return array
     */
    public function getCartData()
    {
        $obCartPositionList = $this->get();

        $arResult = [
            'position'             => [],
            'shipping_price'       => $this->getShippingPriceData()->getData(),
            'payment_price'        => $this->getPaymentPriceData()->getData(),
            'position_total_price' => $this->getCartPositionTotalPriceData()->getData(),
            'total_price'          => $this->getCartTotalPriceData()->getData(),
            'quantity'             => 0,
            'total_flat'           => 0,
            'total_quantity'       => 0,
            'weight'               => 0,

            'payment_method_id' => !empty($this->obPaymentMethodItem) ? $this->obPaymentMethodItem->id : $this->obCart->payment_method_id,
            'shipping_type_id'  => !empty($this->obShippingTypeItem) ? $this->obShippingTypeItem->id : $this->obCart->shipping_type_id,
            'user_data'         => $this->obCart->user_data,
            'shipping_address'  => $this->obCart->shipping_address,
            'billing_address'   => $this->obCart->billing_address,
            'property'          => $this->obCart->property,
        ];

        if ($obCartPositionList->isEmpty()) {
            return $arResult;
        }

        foreach ($obCartPositionList as $obCartPositionItem) {

            $offer_resource = [];

            if ( $obCartPositionItem->item_type === Offer::class )
                $offer_resource = OfferResource::make(
                    Offer::where('id', $obCartPositionItem->item_id)->first()
                );
            elseif ( $obCartPositionItem->item_type === CustomDimension::class ) {
                $offer_resource = CustomDimensionResource::make(
                    CustomDimension::where('id', $obCartPositionItem->item_id)->first()
                );
            }

            $arPositionData = [
                'id'           => $obCartPositionItem->id,
                'item_id'      => $obCartPositionItem->item_id,
                'item_type'    => $obCartPositionItem->item_type,
                'item_offer'    => $offer_resource,
                'quantity'      => (int) $obCartPositionItem->quantity,
                'flat'          => (float) $obCartPositionItem->flat,
                'max_quantity'  => (int) $obCartPositionItem->item->quantity,
                'weight'        => (float) $obCartPositionItem->weight,
                'property'      => $obCartPositionItem->property,
            ];

            $arPositionData = $this->getCartPositionPriceData($obCartPositionItem->id)->getData($arPositionData);

            $arResult['quantity']++;
            $arResult['total_flat'] += $obCartPositionItem->flat;
            $arResult['total_quantity'] += $obCartPositionItem->quantity;
            $arResult['weight'] += $obCartPositionItem->weight;
            $arResult['position'][] = $arPositionData;
        }

        return $arResult;
    }

    /**
     * Init promo processor
     */
    protected function initPromoProcessor()
    {
        $this->obPromoProcessor = new CartPromoMechanismProcessor($this->obCart, $this->obCartPositionList, $this->obShippingTypeItem, $this->obPaymentMethodItem);
    }

    /**
     * Init cart position list
     */
    protected function initCartPositionList()
    {
        if (empty($this->obCart)) {
            $this->obCartPositionList = CartPositionCollection::make();
        }

        /** @var array $arCartPositionIDList */
        $arCartPositionIDList = CartPosition::getByCart($this->obCart->id)->lists('id');
        $this->obCartPositionList = CartPositionCollection::make($arCartPositionIDList);
    }

    public function getPaymentPriceData(): ItemPriceContainer
    {
        if (empty($this->obPromoProcessor)) {
            $this->updateCartData();
        }

        $obPriceData = $this->obPromoProcessor->getPaymentPrice();

        return $obPriceData;
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        if (empty($this->obCart))
            return;

        $this->obCart->update([
            'shipping_type_id' => null,
            'payment_method_id' => null
        ]);

        parent::clear();
    }

    public function addBillingAddress($billing_address)
    {
        $this->obCart->billing_address = $billing_address;
    }

    public function addShippingAddress($shipping_address)
    {
        $this->obCart->shipping_address = $shipping_address;
    }
}
