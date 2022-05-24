<?php

use Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
	'prefix' 	=> config('err404.user::routes.prefix', 'api/v1/auth'),
	'middleware' => config('err404.user::routes.middlewares', [
		ApiExceptionMiddleware::class,
		'api'
	])
], function () {
	$actions = config('err404.user::routes.actions', []);

	foreach ($actions as $a) {
		$methods = $a['method'];

		if (!is_array($methods))
			$methods = [$methods];

		foreach ($methods as $method) {
			Route::{$method}($a['route'], $a['controller'])
				->middleware($a['middlewares']);
		}
	}
});
