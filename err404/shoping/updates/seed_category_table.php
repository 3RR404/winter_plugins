<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Updates\Seeder;
use Lovata\Shopaholic\Models\Category;

class SeedCategoryTable extends Seeder
{

	public function run()
	{
        $parents = [
            [
                'name' => 'Miestnosť',
                'slug' => 'miestnost',
                'active' => true
            ],
            [
                'name' => 'Pocit',
                'slug' => 'pocit',
                'active' => true
            ],
            [
                'name' => 'Téma',
                'slug' => 'tema',
                'active' => true
            ]
        ];

        foreach( $parents as $main )
		    Category::create($main);


        $miestnost = Category::getBySlug('miestnost')->first();
        $pocit = Category::getBySlug('pocit')->first();
        $tema = Category::getBySlug('tema')->first();

        $childs = [
            [
                'name' => 'Obývačka',
                'slug' => 'obyvacka',
                'active' => true,
                'parent_id' => $miestnost->id
            ],
            [
                'name' => 'Detská izba',
                'slug' => 'detska-izba',
                'active' => true,
                'parent_id' => $miestnost->id
            ],
            [
                'name' => 'oddýchnuto',
                'slug' => 'oddychnuto',
                'active' => true,
                'parent_id' => $pocit->id
            ],
            [
                'name' => 'pohodlne',
                'slug' => 'pohodlne',
                'active' => true,
                'parent_id' => $pocit->id
            ],
            [
                'name' => 'ako na vesmírnej expedícií',
                'slug' => 'ako-na-vesmirnej-expedicii',
                'active' => true,
                'parent_id' => $tema->id
            ],
            [
                'name' => 'ako milovník techniky',
                'slug' => 'ako-milovnik-techniky',
                'active' => true,
                'parent_id' => $tema->id
            ]
        ];

        foreach ( $childs as $child)
            Category::create($child);

	}
}
