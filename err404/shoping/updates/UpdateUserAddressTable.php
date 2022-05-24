<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

class UpdateUserAddressTable extends \Winter\Storm\Database\Updates\Migration
{
    const TABLE_NAME = 'lovata_orders_shopaholic_user_addresses';

    public function up()
    {
        if( !Schema::hasTable(self::TABLE_NAME) )
            return;

        if ( Schema::hasColumn(self::TABLE_NAME, 'country'))
            Schema::table(self::TABLE_NAME, function( Blueprint $obTable){
                $obTable->dropColumn('country');

                $obTable->integer('country_id')->default(204)->nullable();
            });
    }

    public function down()
    {
        return;
    }
}
