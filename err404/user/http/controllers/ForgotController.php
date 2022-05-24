<?php

namespace Err404\User\Http\Controllers;

use Carbon\Carbon;
use Err404\User\Classes\UserHook;
use Err404\User\Http\Controllers\UserController;
use RainLab\User\Models\User;
use Illuminate\Support\Facades\Event;
use Winter\Storm\Exception\ApplicationException;

class ForgotController extends UserController
{
	public function handle()
	{
		$response = [];

		$params = [
			'email' => input('email'),
		];

		$user = User::where('email', $params['email'])->firstOrFail();

		if (!$user->is_activated) {
			throw new ApplicationException('User not activated');
		}

		$this->sendResetPasswordCode($user);

		$response = [
			"success" => true,
		];

		return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
			return response()->make([
				'data'   => $response,
				'status' => 200,
			], 200);
		});
	}

	protected function sendResetPasswordCode($user)
	{
		$resetPasswordCode = mt_rand(100000, 999999);
		$dbResetPasswordCode = Carbon::now()->timestamp . '!' . $resetPasswordCode;

		$user->reset_password_code = $dbResetPasswordCode;
		$user->save();

		return Event::fire('err404.user.sendResetPasswordCode', [$user, $resetPasswordCode, $dbResetPasswordCode], true);
	}
}
