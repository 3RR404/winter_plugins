<?php

namespace Err404\User\Classes;

use Illuminate\Support\Facades\Event;

class UserHook
{
	public static function hook($hook, $data, $callback)
	{
		$hook = Event::fire(sprintf('err404.user.%s', $hook), $data, true);
		if (!is_null($hook)) {
			return $hook;
		}

		return $callback();
	}
}
