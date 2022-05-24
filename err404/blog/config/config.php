<?php

return [
    'resources' => [
        'article' => 'Err404\Blog\Http\Resources\ArticleResource',
        'category' => 'Err404\Blog\Http\Resources\CategoryResource',
    ],
    'routes' => [
        'prefix' => 'api/v1/blog',
        'middlewares' => [
            \Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware::class
        ],
        'actions' => [
            'article_list' => [
                'route' => '/',
                'method' => 'GET',
                'controller' => 'Err404\Blog\Http\Controllers\BlogController@index',
                'middlewares' => []
            ],
            'categories' => [
                'route' => '/categories',
                'method' => 'GET',
                'controller' => 'Err404\Blog\Http\Controllers\BlogController@categories',
                'middlewares' => []
            ],
            'article_detail' => [
                'route' => '/{key}',
                'method' => 'GET',
                'controller' => 'Err404\Blog\Http\Controllers\BlogController@show',
                'middlewares' => []
            ],
        ]
    ]
];
