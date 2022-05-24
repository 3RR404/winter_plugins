<?php

return [
    'resources' => [
        'country' => \Err404\Location\Http\Resources\CountryResource::class,
        'state' => \Err404\Location\Http\Resources\StateResource::class,
    ],
    'routes' => [
        'prefix' => 'api/v1/location',
        'middlewares' => [
            \Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware::class
        ],
        'actions' => [
            'country_list' => [
                'route' => '/country',
                'method' => 'GET',
                'controller' => 'LocationController@country',
                'middlewares' => []
            ],
            'state_list' => [
                'route' => '/state',
                'method' => 'GET',
                'controller' => 'LocationController@state',
                'middlewares' => []
            ],
        ],
    ],
];
