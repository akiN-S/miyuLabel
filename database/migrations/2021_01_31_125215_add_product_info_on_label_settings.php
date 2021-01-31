<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductInfoOnLabelSettings extends Migration
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
            $table->integer('startDate');
            $table->string('name');
            $table->string('explanation')->nullable();
            $table->double('unitPrice');
            $table->boolean('isSelected')->default(false);
            $table->boolean('isDeleted')->default(false);


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
            $table->dropColumn('name');  //カラムの削除
            $table->dropColumn('explanation');  //カラムの削除
            $table->dropColumn('unitPrice');  //カラムの削除
            $table->dropColumn('isSelected');  //カラムの削除
            $table->dropColumn('isDeleted');  //カラムの削除
        });
    }
}
