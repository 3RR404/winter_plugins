<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Processor\CartProcessor;
use Err404\Shoping\Classes\Processor\OrderProcessor;
use Err404\Shoping\Classes\UserAddressCreator;
use Err404\User\Facades\JWTAuth;
use Err404\User\Models\User;
use Illuminate\Support\Facades\Event;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Interfaces\PaymentGatewayInterface;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\Ordersshopaholic\Models\UserAddress;
use Lovata\Shopaholic\Classes\Helper\CurrencyHelper;
use Lovata\Toolbox\Classes\Helper\UserHelper;
use Lovata\Toolbox\Traits\Helpers\TraitValidationHelper;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\Settings as UserSettings;
use Winter\Storm\Support\Facades\Input;

class OrderController extends ShopingController
{
    use TraitValidationHelper;

    protected $arOrderData = [];
    protected $arUserData = [];

    /** @var User */
    protected $obUser;

    /** @var Order */
    protected $obOrder;

    /** @var PaymentGatewayInterface|null */
    protected $obPaymentGateway;

    protected $arShippingAddressOrder = [];
    protected $arBillingAddressOrder = [];
    protected $arCompanyOrder = [];

    protected $bCreateNewUser = true;

    public function handle()
    {
        $orderProcessor = OrderProcessor::instance();

        Result::setData($orderProcessor->getPaymentGateway());

        return Result::get();

    }

    public function onOrder($key)
    {

        $obOrder = Order::getBySecretKey($key)
            ->with('user')
            ->with('status')
            ->with('order_position')
            ->with('order_offer')
            ->with('order_customdimension')
            ->first();

        /** @var \Err404\Shoping\Http\Resources\OrderResource $sResourceClass */
        $sResourceClass = config('err404.shoping::resources.order');

        Result::setData( new $sResourceClass($obOrder) );

        return Result::get();
    }

    public function onCreate()
    {

        $this->processUserData( Input::post('user') );

        $this->create();

        $this->prepareResponseData();

        if (empty($this->obPaymentGateway) || !Result::status())
            return Result::get();

        if ($this->obPaymentGateway->isSuccessful())
            Result::setTrue($this->obPaymentGateway->getResponse());
        else
            Result::setFalse($this->obPaymentGateway->getResponse());

        return Result::get();
    }

    protected function processUserData( $arUserData )
    {
        $arProcessedUserData = [
            'name' => $arUserData['firstName'],
            'surname' => $arUserData['lastName'],
        ];
        unset($arUserData['firstName'], $arUserData['lastName']);

        $this->arUserData = array_merge($arProcessedUserData, $arUserData);
    }

    protected function create()
    {

        if ( JWTAuth::check() ) {
            $this->obUser = JWTAuth::getUser();
        }

        $orderProcessor = OrderProcessor::instance();

        if (empty($this->obUser) && $this->bCreateNewUser) {
            $this->findOrCreateUser();
        } else if (!empty($this->obUser)) {
            $arAuthUserData = [
                'email' => $this->obUser->email,
                'name' => $this->obUser->name,
                'last_name' => $this->obUser->last_name,
                'phone' => $this->obUser->phone,
            ];
            $this->arUserData = array_merge($arAuthUserData, $this->arUserData);
        }

        if (!Result::status())
            return;

        $obCartProccessor = CartProcessor::instance();


        $obCart = $obCartProccessor->getCartObject();
        $this->arUserData = array_merge((array) $obCart->user_data, $this->arUserData);
        $obCart->user_id = $this->obUser->id;
        $obCart->email = $this->obUser->email;

        $this->processOrderAddress();

        if (empty($obCart->user_data))
            $obCart->user_data = $this->arUserData;

        if (!Result::status())
            return;

        $this->arOrderData['payment_method_id'] = $obCart->payment_method_id;
        $this->arOrderData['shipping_type_id'] = $obCart->shipping_type_id;

        $arOrderData = $this->arOrderData;

        if ( @Input::post('order_notice') )
            $arOrderData['property'] = [
                'order_notice' => Input::post('order_notice')
            ];

        $obActiveCurrency = CurrencyHelper::instance()->getActive();
        if (empty(array_get($arOrderData, 'currency')) && !empty($obActiveCurrency)) {
            $arOrderData['currency_id'] = $obActiveCurrency->id;
        }
        if (!isset($arOrderData['property']) || !is_array($arOrderData['property'])) {
            $arOrderData['property'] = [];
        }

        $arOrderData['property'] = array_merge($arOrderData['property'], $this->arUserData, $this->arBillingAddressOrder, $this->arShippingAddressOrder, $this->arCompanyOrder);

        $this->obOrder = $orderProcessor->create( $arOrderData, $this->obUser );
        $this->obPaymentGateway = $orderProcessor->getPaymentGateway();
    }

    protected function findOrCreateUser()
    {
        if( !empty($this->obUser) || empty($this->arUserData) )
            return;

        $this->findUserByEmail();
        if ( !empty($this->obUser) && $this->obUser->is_guest == false ) {
            $this->obUser = null;
            Result::setFalse(['field' => 'email'])->setMessage(trans('err404.shoping::lang.message.email_already_used'));
            return;
        }

        if (!empty($this->obUser) || !$this->bCreateNewUser) {
            return;
        }

        $this->createUser();
    }

    protected function findUserByEmail()
    {
        if (empty($this->arUserData) || !isset($this->arUserData['email']) || empty($this->arUserData['email'])) {
            return;
        }
        $sEmail = $this->arUserData['email'];
        $this->obUser = UserHelper::instance()->findUserByEmail($sEmail);

        if (!empty($this->obUser) && $this->obUser->is_guest && (!@$this->arUserData['is_guest'] || $this->arUserData['is_guest'] == 'false')) {
            $autoActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
            $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;

            Auth::convertGuestToUser($this->obUser, $this->arUserData ,$autoActivation);
            if ($userActivation && !$this->obUser->is_activated) {
                $this->sendActivationCode($this->obUser);
                Result::setMessage( trans('err404.shoping::lang.message.user_registred_need_activation'));
            }
        }
    }

    protected function createUser()
    {
        if (empty($this->arUserData)) {
            return;
        }

        $arUserData = (array) $this->arUserData;

        $sPassword = md5(microtime(true));

        if (!isset($arUserData['password']) || empty($arUserData['password'])) {
            $arUserData['password'] = $sPassword;
        }

        $arUserData['password_confirmation'] = $arUserData['password'];

        $this->obUser = $this->register($arUserData);
    }

    protected function register($data)
    {
        Event::fire('rainlab.user.beforeRegister', [&$data]);

        $autoActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
        $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;


        if (@$data['is_guest'] && ((is_bool($data['is_guest']) && $data['is_guest'] == true)
            || (is_string($data['is_guest']) && $data['is_guest'] === 'true'))) {
            try {
                $user = Auth::registerGuest($data);
            } catch (\October\Rain\Database\ModelException $obException) {
                $this->processValidationError($obException);
                return;
            }
        } else {
            try {
                $user = Auth::register($data, $autoActivation);

            } catch (\October\Rain\Database\ModelException $obException) {
                $this->processValidationError($obException);
                return;
            }
        }

        if ($userActivation && !$user->is_activated && !$user->is_guest) {
            $this->sendActivationCode($user);
        }

        return $user;
    }

    protected function sendActivationCode($user)
    {
        $activationCode = $user->activation_code ?? $user->getActivationCode();
        return Event::fire('Err404.user.sendActivationCode', [$user, $activationCode], true);
    }

    /**
     * Process shipping/billing addresses. Create new user address or get data from exist address
     */
    protected function processOrderAddress()
    {
        $arShippingAddressData = (array) Input::post('shipping_address');
        $arBillingAddressData = (array) Input::post('billing_address');
        $arCompanyData = (array) Input::post('company');

        $obCart = CartProcessor::instance()->getCartObject();

        $arShippingAddressData = array_merge((array) $obCart->shipping_address, $arShippingAddressData);
        $arBillingAddressData = array_merge((array) $obCart->billing_address, $arBillingAddressData);
        $arCompanyData = array_merge((array) $obCart->company, $arCompanyData);

        $this->arShippingAddressOrder = (new UserAddressCreator($this->obUser))->addOrderAddress(UserAddress::ADDRESS_TYPE_SIPPING, $arShippingAddressData);
        $this->arBillingAddressOrder = (new UserAddressCreator($this->obUser))->addOrderAddress(UserAddress::ADDRESS_TYPE_BILLING, $arBillingAddressData);
        $this->arCompanyOrder = (new UserAddressCreator($this->obUser))->addCompany($arCompanyData);
    }

    /**
     * Fire event and prepare response data
     */
    protected function prepareResponseData()
    {
        if (!Result::status()) {
            return;
        }

        $arResponseData = Result::data();
        $arEventData = Event::fire(OrderProcessor::EVENT_UPDATE_ORDER_RESPONSE_AFTER_CREATE, [$arResponseData, $this->obOrder, $this->obUser, $this->obPaymentGateway]);
        if (empty($arEventData)) {
            return;
        }

        foreach ($arEventData as $arData) {
            if (empty($arData)) {
                continue;
            }

            $arResponseData = array_merge($arResponseData, $arData);
        }

        Result::setData($arResponseData);
    }
}
