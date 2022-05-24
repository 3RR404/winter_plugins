<?php

namespace Err404\Shoping\Classes\Extend;

use Lovata\PropertiesShopaholic\Models\PropertyValue;

class PropertyValueModelExtend
{

    public static $propertyValueList = null;

    public static function _addDynamicMethod()
    {
        PropertyValue::extend(function($model)
        {

            $model->addDynamicMethod('getPropertyValueList', function () use ($model) {

                if (self::$propertyValueList) {
                    return self::$propertyValueList;
                }

                return self::$propertyValueList = $model::orderBy('value', 'asc')->lists('value', 'id');

            });
        });
    }
}
