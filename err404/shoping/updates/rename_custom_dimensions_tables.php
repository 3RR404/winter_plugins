<?php namespace Err404\Shoping\Updates;

use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class RemoveCustomDimensionsTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('err404_shoping_custom_dimensions');
        Schema::dropIfExists('lovata_shopaholic_offers_custom_dimensions');
        Schema::dropIfExists('lovata_shopaholic_products_custom_dimensions');
        Schema::dropIfExists('properties_vlaues_custom_dimensions');
    }

    public function down()
    {
        return;
    }
}
