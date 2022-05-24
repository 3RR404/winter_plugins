<?php namespace Err404\Shoping\Updates;

use Lovata\OrdersShopaholic\Models\Cart;
use Seeder;
use Lovata\OrdersShopaholic\Models\OrderProperty;

/**
 * Class SeederDefaultOrderProperties
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederCompanyOrderProperties extends Seeder
{
    public function run()
    {
        $arPropertyList = [
            [
                'active' => true,
                'name' => 'err404.shoping::lang.field.company_name',
                'code' => 'company_companyName',
                'slug' => 'company_companyName',
                'type' => 'input',
                'settings' => ['tab' => 'err404.shoping::lang.field.company'],
                'sort_order' => 23
            ], [
                'active' => true,
                'name' => 'err404.shoping::lang.field.ico',
                'code' => 'company_ico',
                'slug' => 'company_ico',
                'type' => 'input',
                'settings' => ['tab' => 'err404.shoping::lang.field.company'],
                'sort_order' => 24
            ], [
                'active' => true,
                'name' => 'err404.shoping::lang.field.dic',
                'code' => 'company_dic',
                'slug' => 'company_dic',
                'type' => 'input',
                'settings' => ['tab' => 'err404.shoping::lang.field.company'],
                'sort_order' => 25
            ], [
                'active' => true,
                'name' => 'err404.shoping::lang.field.icdph',
                'code' => 'company_icdph',
                'slug' => 'company_icdph',
                'type' => 'input',
                'settings' => ['tab' => 'err404.shoping::lang.field.company'],
                'sort_order' => 26
            ], [
                'active' => true,
                'name' => 'err404.shoping::lang.field.order_notice',
                'code' => 'order_notice',
                'slug' => 'order_notice',
                'type' => 'textarea',
                'settings' => ['tab' => 'err404.shoping::lang.field.order_notice'],
                'sort_order' => 27
            ],
        ];

        foreach ($arPropertyList as $arPropertyData) {
            OrderProperty::create($arPropertyData);
        }
    }
}
