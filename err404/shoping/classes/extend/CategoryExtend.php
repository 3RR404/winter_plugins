<?php

namespace Err404\Shoping\Classes\Extend;

use Lovata\Shopaholic\Models\Category;

class CategoryExtend
{

	public static function _extendMethod()
	{
		Category::extend(function ($model) {

			$model->addDynamicMethod('isActive', function () use ($model) {

				return $model->where('active', true);
			});
		});
	}
}
