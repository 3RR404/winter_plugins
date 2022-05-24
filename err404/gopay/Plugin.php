<?php namespace Err404\GoPay;

use Backend;
use Illuminate\Support\Facades\Event;
use Lovata\OrdersShopaholic\Models\PaymentMethod;
use Omnipay\GoPay\Gateway;
use Omnipay\Omnipay;
use System\Classes\PluginBase;

/**
 * GoPay Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'GoPay',
            'description' => 'No description provided yet...',
            'author'      => 'Err404',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Omnipay::getFactory()->register('GoPay');
        Event::listen(PaymentMethod::EVENT_GET_GATEWAY_LIST, function() {
            $arPaymentMethodList = [
                'GoPay' => 'GoPay',
            ];

            return $arPaymentMethodList;
        });
        PaymentMethod::extend(function ($obElement) {
            /** @var PaymentMethod $obElement */

            $obElement->addGatewayClass('GoPay', Gateway::class);
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Err404\GoPay\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'err404.gopay.some_permission' => [
                'tab' => 'GoPay',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'gopay' => [
                'label'       => 'GoPay',
                'url'         => Backend::url('err404/gopay/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['err404.gopay.*'],
                'order'       => 500,
            ],
        ];
    }
}
