<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

class UpdatePaymentMethodsTable extends \Winter\Storm\Database\Updates\Migration
{
    const TABLE_NAME = 'lovata_orders_shopaholic_payment_methods';

    public function up()
    {
        if ( Schema::hasColumn( self::TABLE_NAME, 'price' ) )
            return;

        Schema::table( self::TABLE_NAME, function (Blueprint $table){
            $table->decimal('price', 15, 2)->nullable();
        });
    }

    public function down()
    {
        if ( Schema::hasColumn( self::TABLE_NAME, 'price' ) )

            Schema::table( self::TABLE_NAME, function (Blueprint $table){
                $table->dropColumn('price');
            });
    }
}
