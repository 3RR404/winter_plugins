<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Err404\User\Facades\JWTAuth;
use Illuminate\Support\Facades\Event;
use Tymon\JWTAuth\Exceptions\JWTException;

class RefreshController extends UserController
{
	public function handle()
	{
		$response = [];

		if (!$newToken = JWTAuth::parseToken()->refresh()) {
			throw new JWTException();
		}

		$user = JWTAuth::setToken($newToken)->authenticate();

		Event::fire('err404.user.beforeReturnUser', [$user]);

		$userResourceClass = config('err404.user::resources.user');
		$response = [
			'success' => true,
			'token'   => $newToken,
			'user'    => new $userResourceClass($user),
		];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'data'   => $response,
				'status' => 200,
			], 200);
		});
	}
}
