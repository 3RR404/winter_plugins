<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Err404\User\Facades\JWTAuth;
use Illuminate\Support\Facades\Event;
use RainLab\User\Facades\Auth;
use Winter\Storm\Auth\AuthException;

class SigninController extends UserController
{
	public function handle()
	{
		$data = [
			'login' => post('login'),
			'password' => post('password')
		];

		$user = Event::fire('err404.user.beforeAuthenticate', [$data], true);
		if (is_null($user)) {
			$user = Auth::authenticate($data, false);
		}

		if ($user->isBanned()) {
			throw new AuthException('rainlab.user::lang.account.banned');
		}

		$token = JWTAuth::fromUser($user);

		Event::fire('err404.user.beforeReturnUser', [$user]);

		$userResourceClass = config('err404.user::resources.user');
		$response = ['user' => new $userResourceClass($user), 'token' => $token];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'data'   => $response,
				'status' => 200,
			], 200);
		});
	}
}
