<?php

namespace Err404\Shoping\Classes\Event;

use Illuminate\Support\Facades\Event;

class ShopingHook
{
    public static function hook($hook, $data, $callback)
    {
        $hook = Event::fire(sprintf('err404.shoping.%s', $hook), $data, true);
        if (!is_null($hook)) {
            return $hook;
        }

        return $callback();
    }
}
