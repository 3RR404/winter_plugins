<?php

namespace Err404\Shoping\Classes\Extend;

use Lovata\OrdersShopaholic\Controllers\Orders;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\Shopaholic\Models\Product;
use Winter\Storm\Support\Facades\Event;

class ProductExtend
{

	public static function _extendMethod()
	{
		Product::extend(function ($model) {

			$model->addDynamicMethod('scopeIsActive', function () use ($model) {

				return $model->where('active', true);
			});

		});

        Event::listen('backend.form.extendFields', function($obWidget){

            if ( !$obWidget->getController() instanceof Orders )
                return;

            if (!$obWidget->model instanceof Order) {
                return;
            }

            if ($obWidget->isNested) {
                return;
            }


            $arAdditionFields = [
                'campaign' => [
                    'type'    => 'partial',
                    'tab'     => 'err404.shoping::lang.tab.invoice',
                    'path'    => '$/err404/shoping/views/invoices/_button_invoice.htm',
                    'context' => ['update'],
                ],
            ];

            $obWidget->addTabFields($arAdditionFields);

        });
	}


}
