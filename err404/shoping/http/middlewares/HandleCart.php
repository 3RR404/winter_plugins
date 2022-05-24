<?php

namespace Err404\Shoping\Http\Middlewares;

use Lovata\OrdersShopaholic\Classes\Processor\CartProcessor;
use Symfony\Component\HttpFoundation\Cookie;
use Winter\Storm\Support\Facades\Event;

class HandleCart
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        if (!\Cookie::get(CartProcessor::COOKIE_NAME)) {
            $cookie = \Cookie::make(
                CartProcessor::COOKIE_NAME,
                CartProcessor::instance()->getCartObject()->id,
                CartProcessor::$iCookieLifeTime
            );
        } else {
            $cookie = \Cookie::get(CartProcessor::COOKIE_NAME);

        }

        Event::fire('err404.cart.beforeReturnResource', [CartProcessor::instance()->getCartObject(), &$cookie]);

        if ( $cookie) {
            $response->withCookie($cookie);
        }

        return $response;
    }
}
