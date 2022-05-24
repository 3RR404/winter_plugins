<?php

namespace Err404\Shoping\Classes\Extend;

use Err404\Shoping\Classes\UserAddressCreator;
use Err404\User\Models\User;
use File;
use Lovata\Ordersshopaholic\Models\UserAddress;
use RainLab\Location\Models\Country;
use Winter\Storm\Database\Model;
use Winter\Storm\Support\Facades\Event;
use Yaml;
use RainLab\User\Controllers\Users as UsersController;
use RainLab\User\Models\User as UserModel;

class UserExtend
{

    protected $arShippingAddressOrder;
    protected $arBillingAddressOrder;

    /** @var User */
    protected $obUser;

    public static function _extendModel()
    {
        UserModel::extend(function(Model $model) {

            $model->addFillable([
                'ico',
                'dic',
                'icdph',
                'companyName',
                'country_id',
            ]);

            $model->addJsonable('product_wish_list');

            $model->implement[] = 'Err404.User.Behaviors.LocationModel';

            if ( !in_array( 'RainLab.Location.Behaviors.LocationModel', $model->implement ) )
                $model->implement[] = 'RainLab.Location.Behaviors.LocationModel';

        });

        UserAddress::extend( function (Model $model){
            $model->belongsTo['country'] = [Country::class];
        });
    }

    public static function _extendFormFields()
    {
        UsersController::extendFormFields(function($widget) {
            // Prevent extending of related form instead of the intended User form
            if (!$widget->model instanceof UserModel) {
                return;
            }

            $widget->removeField('mobile');
            $widget->removeField('company');
            $widget->removeField('state');

            $configFile = plugins_path('err404/user/config/_profile_fields.yaml');
            $config = Yaml::parse(File::get($configFile));
            $widget->addTabFields($config);
        });
    }

    public static function _extendUserRegistration()
    {
        Event::listen('rainlab.user.register', function($obUser, $data){

            if ( $obUser->is_guest )
                return;

            $arShippingAddressData = $data['shipping_address'];
            $arBillingAddressData = $data['billing_address'];
            $arCompanyData = $data['company'];

            $resShippingAddressData = (new UserAddressCreator($obUser))->addOrderAddress(UserAddress::ADDRESS_TYPE_SIPPING, $arShippingAddressData);
            $resBillingAddressData = (new UserAddressCreator($obUser))->addOrderAddress(UserAddress::ADDRESS_TYPE_BILLING, $arBillingAddressData);
            $resCompanyData = (new UserAddressCreator($obUser))->addCompany($arCompanyData);
        });
    }

}
