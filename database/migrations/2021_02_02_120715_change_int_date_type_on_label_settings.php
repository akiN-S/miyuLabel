<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIntDateTypeOnLabelSettings extends Migration
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
            $table->renameColumn('startDate', 'startDateOldInt');
            $table->renameColumn('deliveryDate', 'deliveryDateOldInt');
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
            $table->renameColumn('startDateOldInt', 'startDate');
            $table->renameColumn('deliveryDateOldInt', 'deliveryDate');
        });
    }
}
