<?php

namespace Err404\Shoping\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class UserAddCompanyFields extends Migration
{
    const TABLE_NAME = 'users';

    public function up()
    {
        if (Schema::hasColumns(self::TABLE_NAME, ['ico', 'dic', 'icdph'])) {
            return;
        }

        Schema::table(self::TABLE_NAME, function(Blueprint $table)
        {
            $table->string('companyName', 100)->nullable();
            $table->string('ico', 100)->nullable();
            $table->string('dic', 100)->nullable();
            $table->string('icdph', 100)->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasTable(self::TABLE_NAME) && Schema::hasColumns(self::TABLE_NAME, ['companyName', 'ico', 'dic', 'icdph'])) {
            Schema::table(self::TABLE_NAME, function ($table) {
                $table->dropColumn(['companyName', 'ico', 'dic', 'icdph']);
            });
        }
    }
}
