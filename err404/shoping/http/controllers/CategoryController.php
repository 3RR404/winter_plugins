<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Shoping\Classes\Event\ShopingHook;
use Err404\Shoping\Http\Resources\CategoryResource;
use Lovata\Shopaholic\Models\Category;
use Winter\Storm\Support\Facades\Event;

class CategoryController extends ShopingController
{
	public function handle()
	{
        $response = [];

        $category = Category::isActive()->get();

        Event::fire('Err404.shoping.beforeReturnCategories', [$category]);

        $categoryResourceClass = config('err404.shoping::resources.category');
        $response = [
            'categories' => $categoryResourceClass::collection($category),
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
		$category = Category::isActive()
			->where('slug', $key)
			->orWhere('id', $key)
			->firstOrFail();

		return new CategoryResource($category);
	}
}
