<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Event\ShopingHook;
use Err404\Shoping\Http\Resources\BrandResource;
use Lovata\Shopaholic\Models\Brand;
use Winter\Storm\Support\Facades\Event;

class BrandController extends ShopingController
{
	public function handle()
	{
        $response = [];

        $brands = Brand::isActive()->get();

        Event::fire('Err404.shoping.beforeReturnBrands', [$brands]);

        $brandResourceClass = config('err404.shoping::resources.brand');
        $response = [
            'brands' => $brandResourceClass::collection($brands),
        ];

        return $afterProcess = ShopingHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
	}

	public function show($key)
	{
		$brand = Brand::isActive()
			->where('slug', $key)
			->orWhere('id', $key)
			->firstOrFail();

		return new BrandResource($brand);
	}
}
