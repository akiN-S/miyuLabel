<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateDateTypeOnLabelSettings extends Migration
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
            $table->date('startDate')->default('2021-02-01'); // needed a data to add a column;
            $table->date('deliveryDate')->default('2021-02-01'); // needed a data to add a column
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
            $table->dropColumn('startDate');  //カラムの削除
            $table->dropColumn('deliveryDate');  //カラムの削除
        });
    }
}
