<?php

namespace Err404\Shoping\Updates;

use Lovata\PropertiesShopaholic\Models\Property;
use Lovata\PropertiesShopaholic\Models\PropertySet;
use Lovata\PropertiesShopaholic\Models\PropertyValue;
use Lovata\PropertiesShopaholic\Models\PropertyValueLink;
use Lovata\PropertiesShopaholic\Updates\TableCreateProperties;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Winter\Storm\Database\Updates\Seeder;
use Winter\Storm\Support\Facades\Schema;

class SeedPropertiesTable extends Seeder
{

    /** @var  Property */
    protected $obProperty;

    protected $arPropertiesData = [
        [
            'active'      => true,
            'name'        => 'Material',
            'slug'        => 'material',
            'code'        => 'material',
            'type'        => 'radio',
            'description' => 'description',
            'settings'    => [
                'tab' => 'Properties'
            ]
        ],[
            'active'      => true,
            'name'        => 'Rozmery',
            'slug'        => 'rozmery',
            'code'        => 'rozmery',
            'type'        => 'select',
            'description' => 'description',
            'settings'    => [
                'tab' => 'Properties'
            ]
        ]
    ];

    public function run()
    {
        foreach( $this->arPropertiesData as $arProperty ) {
            Property::create($arProperty);
        }
    }
}
