<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateOldToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('label_settings', function (Blueprint $table) {
            //
            $table->text('startDateOldInt')->nullable()->change();
            $table->text('deliveryDateOldInt')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('label_settings', function (Blueprint $table) {
            //
            $table->text('startDateOldInt')->nullable(false)->change();
            $table->text('deliveryDateOldInt')->nullable(false)->change();
        });
    }
}
