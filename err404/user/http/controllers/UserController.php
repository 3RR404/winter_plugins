<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

abstract class UserController extends Controller
{
	abstract public function handle();

	public function __invoke(Request $request)
	{
		return UserHook::hook('beforeProcess', [$this], function () {
			return $this->handle();
		});
	}

}
