<?php

namespace Err404\User\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class UserRemoveShippingCompanyColumns extends Migration
{
    const TABLE_NAME = 'users';

    public function up()
    {
        if (Schema::hasColumns(self::TABLE_NAME, [
                'shipAddress',
                'shipCity',
                'shipZipCode',
                'country_id',
                'state_id',
                'ship_country_id',
                'zip',
                'city',
                'street_addr',
                'company',
                'companyName',
                'ico',
                'dic',
                'icdph',
                'mobile'
            ]
        )) {
            Schema::table(self::TABLE_NAME, function(Blueprint $table)
            {
                $table->dropColumn([
                    'shipAddress',
                    'shipCity',
                    'shipZipCode',
                    'country_id',
                    'state_id',
                    'ship_country_id',
                    'zip',
                    'city',
                    'street_addr',
                    'company',
                    'companyName',
                    'ico',
                    'dic',
                    'icdph',
                    'mobile'
                ]);
            });
        }
    }

    public function down()
    {
        return;
    }
}
