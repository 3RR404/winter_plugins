<?php

namespace Err404\Shoping\Updates;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Winter\Storm\Database\Updates\Seeder;

class SeedOfferTable extends Seeder
{

    protected $arOffers = [
        [
            'active'                => true,
            'name'                  => 'Plátno - 50x89cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Plátno - 150x150cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Plátno - 100x100cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Plagát / Fotopapier - 150x150cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Fototapeta - vlies - 50x89cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Fototapeta - plátno - 150x150cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Fototapeta - hladká - 50x89cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ],
        [
            'active'                => true,
            'name'                  => 'Fototapeta - hladká - 100x100cm',
            'price'                 => 6.10,
            'quantity'              => 1,
            'quantity_in_unit'      => 1,
        ]
    ];

	public function run()
	{
        foreach ( $this->arOffers as $offer )
        {
            $product = Product::getBySlug('test-product')->first();
            $offer['product'] = $product->id;
            Offer::create($offer);
        }
        foreach ( $this->arOffers as $offer )
        {
            $product = Product::getBySlug('test-product-2')->first();
            $offer['product'] = $product->id;
            Offer::create($offer);
        }
	}
}
