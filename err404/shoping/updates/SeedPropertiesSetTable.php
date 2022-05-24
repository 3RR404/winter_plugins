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

class SeedPropertiesSetTable extends Seeder
{
    protected $arPropertySetData = [
        'name' => 'mind set',
        'code' => 'mind-set',
    ];

    public function run()
    {
        PropertySet::create($this->arPropertySetData);

    }
}
