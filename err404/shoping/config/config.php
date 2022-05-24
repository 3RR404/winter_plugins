<?php

return [
    'resources' => [
        'product' => \Err404\Shoping\Http\Resources\ProductResource::class,
        'category' => \Err404\Shoping\Http\Resources\CategoryResource::class,
        'brand' => \Err404\Shoping\Http\Resources\BrandResource::class,
        'shipping' => \Err404\Shoping\Http\Resources\ShippingTypeResource::class,
        'payment' => \Err404\Shoping\Http\Resources\PaymentMethodResource::class,
        'tag' => \Err404\Shoping\Http\Resources\TagResource::class,
        'wishlist' => \Err404\Shoping\Http\Resources\WishlistResource::class,
        'order' => \Err404\Shoping\Http\Resources\OrderResource::class,
    ],
    'routes' => [
        'prefix' => 'api/v1',
        'middlewares' => [
            \Err404\ApiException\Http\Middlewares\ApiExceptionMiddleware::class,
            'api',
            \Err404\User\Http\Middlewares\Check::class,
            \Err404\Shoping\Http\Middlewares\HandleCart::class
        ],
        'actions' => [
            'product' => [
                'route' => 'product/{key}',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\ProductController@show',
                'middlewares' => []
            ],
            'catalog' => [
                'route' => 'catalog',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CatalogController@index',
                'middlewares' => []
            ],
            'categories' => [
                'route' => 'products/categories',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CategoryController',
                'middlewares' => []
            ],
            'category_detail' => [
                'route' => 'products/category/{key}',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CategoryController@show',
                'middlewares' => []
            ],
            'brands' => [
                'route' => 'products/brands',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\BrandController',
                'middlewares' => []
            ],
            'brand_detail' => [
                'route' => 'products/brand/{key}',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\BrandController@show',
                'middlewares' => []
            ],
            'cart' => [
                'route' => 'cart',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CartController',
                'middlewares' => []
            ],
            'cart-add' => [
                'route' => 'cart/add',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CartController@onAdd',
                'middlewares' => []
            ],
            'cart-update' => [
                'route' => 'cart/update',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CartController@onUpdate',
                'middlewares' => []
            ],
            'cart-remove' => [
                'route' => 'cart/remove',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CartController@onRemove',
                'middlewares' => []
            ],
            'cart-clear' => [
                'route' => 'cart/clear',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\CartController@onClear',
                'middlewares' => []
            ],
            'shipping-type' => [
                'route' => 'shipping-type',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\ShippingTypeController',
                'middlewares' => []
            ],
            'payment-methods' => [
                'route' => 'payment-methods',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\PaymentMethodController',
                'middlewares' => []
            ],
            'add-shipping-type' => [
                'route' => 'cart/add-shipping-type/{key}',
                'method' => 'GET',
                'controller' =>'Err404\Shoping\Http\Controllers\CartController@addShippingType',
                'middlewares' => []
            ],
            'add-payment-method' => [
                'route' => 'cart/add-payment-method/{key}',
                'method' => 'GET',
                'controller' =>'Err404\Shoping\Http\Controllers\CartController@addPaymentMethod',
                'middlewares' => []
            ],
            'filter' => [
                'route' => 'products/filter',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\FilterController@filter',
                'middlewares' => []
            ],
            'tag_list' => [
                'route' => 'products/tags',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\TagController@index',
                'middlewares' => []
            ],
            'tag_detail' => [
                'route' => 'products/tag/{key}',
                'method' => 'GET',
                'controller' => 'Err404\Shoping\Http\Controllers\TagController@show',
                'middlewares' => []
            ],
            'order_info' => [
                'route' => 'order/{key}',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\OrderController::class . "@onOrder",
                'middlewares' => []
            ],
            'order_create' => [
                'route' => 'order/create',
                'method' => 'POST',
                'controller' => \Err404\Shoping\Http\Controllers\OrderController::class . "@onCreate",
                'middlewares' => [
                    \Err404\User\Http\Middlewares\Check::class,
                ]
            ],
            'add-to-wishlist' => [
                'route' => 'cart/add-to-wishlist',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\CartController::class . "@onAddToWishlist",
                'middlewares' => []
            ],
            'remove-from-wishlist' => [
                'route' => 'cart/remove-from-wishlist',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\CartController::class . "@onRemoveFromWishList",
                'middlewares' => []
            ],
            'clear-wishlist' => [
                'route' => 'cart/clear-wishlist',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\CartController::class . "@onClearWishList",
                'middlewares' => []
            ],
            'user-wishlist' => [
                'route' => 'user/wishlist',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\UserController::class . "@onWishlist",
                'middlewares' => [
                    \Err404\User\Http\Middlewares\Authenticate::class
                ]
            ],
            'search' => [
                'route' => 'shop/search',
                'method' => 'GET',
                'controller' => \Err404\Shoping\Http\Controllers\FilterController::class . "@onSearch",
                'middlewares' => []
            ],
        ]
    ]
];
