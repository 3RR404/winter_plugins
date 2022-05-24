<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware;

Route::group([
    'prefix'     => 'api/v1',
//  'namespace'  => 'Err404\Shoping\Http\Controllers',
    'middleware' => config('err404.shoping::routes.middlewares', []),
], function () {

    $actions = config('err404.shoping::routes.actions', []);

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
