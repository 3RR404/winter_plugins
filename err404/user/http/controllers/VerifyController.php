<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use RainLab\User\Models\User;
use Winter\Storm\Exception\ApplicationException;

class VerifyController extends UserController
{
	public function handle()
	{
        list($user_id, $activation_code) = explode('!', post('activation'));

        $user = User::where('id', $user_id)->firstOrFail();

        if (!$user->attemptActivation($activation_code)) {
            throw new ApplicationException('Activation code is not valid');
        }

        $response = ['success' => true];

        return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
	}
}
