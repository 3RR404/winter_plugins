<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Facades\JWTAuth;
use Illuminate\Support\Facades\Event;
use Err404\User\Classes\UserHook;

class InvalidateController extends UserController
{
	public function handle()
	{
		$response = [];

		$user = JWTAuth::getUser();

		JWTAuth::invalidate(JWTAuth::parseToken()->getToken(), true);

		Event::fire('err404.user.afterInvalidate', [$user]);

		$response = [
			'success' => true,
		];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'data'   => $response,
				'status' => 200,
			], 200);
		});
	}
}
