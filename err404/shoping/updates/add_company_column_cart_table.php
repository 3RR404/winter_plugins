<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

class AddCompanyColumnCartTable extends \Winter\Storm\Database\Updates\Migration
{
    const TABLE_NAME = 'lovata_orders_shopaholic_carts';

    public function up()
    {
        if ( !Schema::hasTable(self::TABLE_NAME) )
            return;

        if ( Schema::hasTable(self::TABLE_NAME) && Schema::hasColumn(self::TABLE_NAME, 'company'))
            return;

        Schema::table(self::TABLE_NAME, function(Blueprint $table){
            $table->text('company')->nullable();
        });
    }

    public function down()
    {
        if ( Schema::hasTable(self::TABLE_NAME) && Schema::hasColumn(self::TABLE_NAME, 'company'))
            Schema::table(self::TABLE_NAME, function(Blueprint $table){
                $table->dropColumn('company');
            });
    }
}
