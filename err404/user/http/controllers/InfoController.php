<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Err404\User\Facades\JWTAuth;
use Err404\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Event;

class InfoController extends UserController
{
	public function handle()
	{
		$response = [];

		$user = JWTAuth::getUser();

		Event::fire('err404.user.beforeReturnUser', [$user]);

		$userResourceClass = config('err404.user::resources.user');
		$response = [
			'user' => new $userResourceClass($user),
		];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'data'   => $response,
				'status' => 200,
			], 200);
		});
	}
}
