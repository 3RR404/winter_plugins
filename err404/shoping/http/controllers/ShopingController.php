<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Event\ShopingHook;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

abstract class ShopingController extends Controller
{
    abstract public function handle();

    public function __invoke(Request $request)
    {
        return ShopingHook::hook('beforeProcess', [$this], function () {
            return $this->handle();
        });
    }

}
