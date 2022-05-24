<?php

namespace Err404\Shoping\Classes\Extend;

use Lovata\Shopaholic\Models\Brand;

class BrandExtend
{

	public static function _extendMethod()
	{
		Brand::extend(function ($model) {

			$model->addDynamicMethod('isActive', function () use ($model) {

				return $model->where('active', true);
			});
		});
	}
}
