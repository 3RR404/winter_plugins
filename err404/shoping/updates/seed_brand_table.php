<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Updates\Seeder;
use Lovata\Shopaholic\Models\Brand;

class SeedBrandTable extends Seeder
{

	public function run()
	{
		Brand::create([
			'name' => 'Test Brand',
			'slug' => 'test-brand',
			'active' => true
		]);
	}
}
