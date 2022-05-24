<?php

namespace Err404\Shoping\Updates;

use Illuminate\Database\Seeder;
use Lovata\PropertiesShopaholic\Models\Property;
use Lovata\PropertiesShopaholic\Models\PropertyValue;

class SeedPropertyValueTable extends Seeder
{
    protected $arPropertyValueData = [
        'material' => [
            [
                'value' => 'Plátno',
                'slug' => 'platno',
            ],[
                'value' => 'Plagát/Fotopapier',
                'slug' => 'plagatfotopapier',
            ],[
                'value' => 'Fototapeta - vlies',
                'slug' => 'fototapetavlies',
            ],[
                'value' => 'Fototapeta - plátno',
                'slug' => 'fototapetaplc3a1tno',
            ],[
                'value' => 'Fototapeta - hladká',
                'slug' => 'fototapetahladkc3a1',
            ]
        ],
        'rozmery' => [
            [
                'value' => '50x89cm',
                'slug' => '50x89cm',
            ],[
                'value' => '150x150cm',
                'slug' => '150x150cm',
            ],[
                'value' => '100x100cm',
                'slug' => '100x100cm',
            ]
        ]
    ];

    public function run()
    {
        foreach ($this->arPropertyValueData as $key => $propertyValue){

            foreach ( $propertyValue as $value )
            {
                $prop = Property::getBySlug($key)->first();
                $value['property'] = $prop;

                PropertyValue::create($value);
            }

        }
    }
}
