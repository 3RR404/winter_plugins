<?php

namespace Err404\Shoping\Updates;

use Lovata\OrdersShopaholic\Models\OrderProperty;
use Winter\Storm\Database\Updates\Seeder;

class UpdateOrderAdditionalFields extends Seeder
{
    public function run()
    {
        $obOrder = OrderProperty::getBySlug('last_name');

        if ( empty($obOrder) )
            return;

        $obOrder->update([
           'slug' => 'surname',
           'code' => 'surname'
        ]);
    }
}
