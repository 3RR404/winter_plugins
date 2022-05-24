<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

class AddPaymentPriceColumnOrdersTable extends \Winter\Storm\Database\Updates\Migration
{
    const TABLE_NAME = 'lovata_orders_shopaholic_orders';

    public function up()
    {
        if( Schema::hasTable(self::TABLE_NAME) && Schema::hasColumns(self::TABLE_NAME, ['payment_price', 'payment_tax_percent']) )
            return;

        if( Schema::hasTable(self::TABLE_NAME) && !Schema::hasColumns(self::TABLE_NAME, ['payment_price', 'payment_tax_percent']) )
        {
            Schema::table(self::TABLE_NAME, function(Blueprint $table){
                $table->decimal('payment_price', 15, 2)->nullable();
                $table->decimal('payment_tax_percent')->nullable();
            });
        }
    }

    public function down()
    {
        if( Schema::hasTable(self::TABLE_NAME) && Schema::hasColumns(self::TABLE_NAME, ['payment_price', 'payment_tax_percent']) )
            Schema::table(self::TABLE_NAME, function(Blueprint $table){
                $table->dropColumn('payment_price', 'payment_tax_percent');
            });
    }
}
