<?php

namespace Err404\Shoping\Classes\Processor;

use App\CustomDimension\Classes\Item\CartPositionItem;
use Lang;
use Err404\Shoping\Classes\Item\PaymentMethodItem;
use Kharanenka\Helper\Result;
use Winter\Storm\Support\Facades\Event;

class OrderProcessor extends \Lovata\OrdersShopaholic\Classes\Processor\OrderProcessor
{
    protected function initCartPositionList()
    {
        if (!Result::status()) {
            return;
        }

        //Get cart element list
        $this->obCartPositionList = CartProcessor::instance()->get();

        /** @var CartPositionItem $obCartPositionItem */
        foreach ($this->obCartPositionList as $obCartPositionItem) {
            $obProcessor = $obCartPositionItem->getOrderPositionProcessor();
            if (!$obProcessor->validate()) {
                $this->obCartPositionList->exclude($obCartPositionItem->id);
            }
        }

        if ($this->obCartPositionList->isEmpty()) {
            $sMessage = Lang::get('lovata.ordersshopaholic::lang.message.empty_cart');
            Result::setFalse()->setMessage($sMessage);
        }
    }
}
