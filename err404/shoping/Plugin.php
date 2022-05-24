<?php

namespace Err404\Shoping;

use App\CustomDimension\Models\CustomDimension;
use Backend;
use Err404\Shoping\Classes\Event\ExtendPaymentMethodFieldsHandler;
use Err404\Shoping\Classes\Extend\BrandExtend;
use Err404\Shoping\Classes\Extend\CartModelExtend;
use Err404\Shoping\Classes\Extend\CategoryExtend;
use Err404\Shoping\Classes\Extend\OrderExtend;
use Err404\Shoping\Classes\Extend\PaymentMethodExtend;
use Err404\Shoping\Classes\Extend\ProductExtend;
use Err404\Shoping\Classes\Extend\PropertyValueModelExtend;
use Err404\Shoping\Classes\Extend\UserExtend;
use Err404\Shoping\Classes\Extend\UserResourceExtend;
use Illuminate\Support\Facades\Event;
use Lovata\OrdersShopaholic\Classes\Processor\OrderProcessor;
use Lovata\OrdersShopaholic\Controllers\Orders;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Models\OrderPosition;
use Lovata\OrdersShopaholic\Models\ShippingType;
use Lovata\Shopaholic\Models\Offer;
use RainLab\Location\Models\Country;
use System\Classes\PluginBase;

/**
 * Shoping Plugin Information File
 */
class Plugin extends PluginBase
{

	public $require = [
		'Lovata.Shopaholic',
        'Lovata.Toolbox',
        'Lovata.PropertiesShopaholic'
	];

	/**
	 * Boot method, called right before the request route.
	 *
	 * @return array
	 */
	public function boot()
	{
		ProductExtend::_extendMethod();
		CategoryExtend::_extendMethod();
		BrandExtend::_extendMethod();
        PropertyValueModelExtend::_addDynamicMethod();
        CartModelExtend::_extendMethod();

        UserExtend::_extendUserRegistration();
        UserExtend::_extendModel();
        UserExtend::_extendFormFields();
        UserResourceExtend::_extendResource();

        // **
        // Add some fields into order
        // **
        Event::listen(OrderProcessor::EVENT_ORDER_CREATED_USER_MAIL_DATA, function($obOrder){

            $sBillingCountryOrder = array_get($obOrder->property, 'billing_country');
            $sShippingCountryOrder = array_get($obOrder->property, 'shipping_country');

            $sBillingCountry = Country::where('id', $sBillingCountryOrder)->first();
            $sShippingCountry = Country::where('id', $sShippingCountryOrder)->first();

            $arShippingData = $obOrder->shipping_type()->first();
            $arPaymentData = $obOrder->payment_method()->first();

            $arOrderPositions = $obOrder->order_position()
                ->with('offer')
                ->with('customdimension')
                ->get();

            /** @var OrderPosition $position */
            foreach( $arOrderPositions as $position)
            {
                if( $position->item_type === Offer::class ) {
                    $obOffer = $position->offer()->with('product')->first();
                    $obProduct = $obOffer->product()->first();
                    $arPositions[] = [
                        'name' => "{$obProduct->name} {$obOffer->name}",
                        'quantity' => $position->quantity,
                        'measure' => 'ks',
                        'price_value' => $position->price_data->price_value,
                    ];
                }

                if( $position->item_type === CustomDimension::class ) {
                    $obOffer = $position->customdimension()->with('product')->first();
                    $obProduct = $obOffer->product()->first();
                    $arPositions[] = [
                        'name' => "{$obProduct->name} (vlastný rozmer) {$obOffer->name}",
                        'quantity' => $position->flat,
                        'measure' => 'm2',
                        'price_value' => $position->price_value,
                    ];
                }
            }

            $arAdditionalData = [
                'billing_country' => $sBillingCountry->name,
                'shipping_country' => $sShippingCountry->name,
                'shipping_type' => $arShippingData,
                'payment_method' => $arPaymentData,
                'order_position' => $arPositions,
            ];

            return $arAdditionalData;
        });

        Orders::extendFormFields( function($widget){
            if (!$widget->model instanceof Order)
                return;

            $arFields = [
                'property[billing_country][name]' => [
                        'label' => 'Country',
                        'nameFrom' => 'name',
                        'type' => 'text',
                        'span' => 'left',
                        'tab' => 'lovata.ordersshopaholic::lang.tab.billing_address',
                ],

                "property[shipping_country][name]" => [
                    'label' => 'Country',
                    'nameFrom' => 'name',
                    'type' => 'text',
                    'span' => 'left',
                    'tab' => 'lovata.ordersshopaholic::lang.tab.shipping_address',
                ]
            ];

            $widget->addTabFields($arFields);
        });
	}

    /**
     * @return array
     */
    public function registerMailTemplates()
    {
        return [
            'err404.shoping::mail.create_order_user'    => \Lang::get('err404.shoping::mail.create_order_user'),
        ];
    }
}
