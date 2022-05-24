<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Err404\User\Facades\JWTAuth;
use Illuminate\Support\Facades\Event;
use Kharanenka\Helper\Result;
use Lovata\Toolbox\Traits\Helpers\TraitValidationHelper;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\Settings as UserSettings;
use Winter\Storm\Support\Facades\Input;

class SignupController extends UserController
{

    use TraitValidationHelper;

    protected $arUserData = [];

	public function handle()
	{
        $this->proccessUserData();

        try {
		    $user = $this->register();
        } catch ( \October\Rain\Database\ModelException $obException ) {
            $this->processValidationError($obException);
            return Result::get();
        }

		$token = null;
		if ($user->is_activated || $user->is_guest) {
			$token = JWTAuth::fromUser($user);
		}

		Event::fire('Err404.user.beforeReturnUser', [$user]);

		$userResourceClass = config('err404.user::resources.user');
		$response = [
			'user' 	=> new $userResourceClass($user),
			'token' => $token
		];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'status' => true,
				'data'   => $response,
                'message' => trans('err404.user::lang.registration.success'),
                'code'   => 201,
			], 201);
		});
	}

	protected function register()
	{
        $data = $this->arUserData;

		Event::fire('rainlab.user.beforeRegister', [&$data]);

		$autoActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
		$userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;

        if ( @$data['is_guest'] && $data['is_guest'] == true ) {
            $user = Auth::registerGuest($data);
        } else
            $user = Auth::register($data, $autoActivation);

		Event::fire('rainlab.user.register', [$user, Input::post()]);

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

    protected function proccessUserData()
    {
        $data = Input::post('user');

        $sPassword = str_random(32);

        $arUserData = [];

        if ( !@$data['password'] )
            $arUserData = [
                'password' => $sPassword,
                'password_confirmation' => $sPassword,
            ];

        $arUserData['name'] = $data['firstName'];
        unset($data['firstName']);

        $arUserData['surname'] = $data['lastName'];
        unset($data['lastName']);

        $this->arUserData = array_merge( $data, $arUserData);

    }
}
