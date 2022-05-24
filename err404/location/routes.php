<?php

use Illuminate\Support\Facades\Route;
use Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware;

Route::group([
    'prefix'     => config('err404.location::routes.prefix', 'api/v1/location'),
    'namespace'  => '\Err404\Location\Http\Controllers',
    'middleware' => [
        ApiExceptionMiddleware::class,
        'api',
    ],
], function () {

    $actions = config('err404.location::routes.actions', []);

    foreach ($actions as $a) {
        $methods = $a['method'];

        if (!is_array($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            Route::{$method}($a['route'], $a['controller'])
                ->middleware($a['middlewares']);
        }
    }
});
