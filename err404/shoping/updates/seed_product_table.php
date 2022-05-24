<?php

namespace Err404\Shoping\Updates;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use Winter\Storm\Database\Updates\Seeder;

class SeedProductTable extends Seeder
{

	public function run()
	{

        $categories = Category::lists('id');

        $miestnost = Category::getBySlug('miestnost')->first();

		Product::create([
			'name' => 'Test Product',
			'slug' => 'test-product',
			'active' => true,
			'preview_text' => 'Elit cupidatat eu anim est ullamco in sint id deserunt enim duis ad. Nostrud eiusmod dolore cillum Lorem. Voluptate incididunt duis exercitation qui eiusmod do incididunt laboris mollit. Ad deserunt in dolore anim quis nulla eiusmod cupidatat nostrud enim velit. Adipisicing amet excepteur ut ut aliquip.',
			'description' => 'Lorem ipsum sit dolor amet',
            'category_id' => $miestnost->id,
            'additional_category' => $categories,
		]);

		Product::create([
			'name' => 'Test Product 2',
			'slug' => 'test-product-2',
			'active' => true,
			'preview_text' => 'Elit cupidatat eu anim est ullamco in sint id deserunt enim duis ad. Nostrud eiusmod dolore cillum Lorem. Voluptate incididunt duis exercitation qui eiusmod do incididunt laboris mollit. Ad deserunt in dolore anim quis nulla eiusmod cupidatat nostrud enim velit. Adipisicing amet excepteur ut ut aliquip.',
			'description' => 'Lorem ipsum sit dolor amet',
            'category_id' => $miestnost->id,
            'additional_category' => $categories,
		]);

        $this->call(SeedPropertiesSetTable::class);
        $this->call(SeedPropertiesTable::class);
        $this->call(SeedPropertyValueTable::class);
        $this->call(SeedOfferTable::class);
	}
}
