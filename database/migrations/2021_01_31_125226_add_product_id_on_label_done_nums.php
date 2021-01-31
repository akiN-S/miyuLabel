<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdOnLabelDoneNums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('label_done_nums', function (Blueprint $table) {
            //
            $table->bigInteger('settingId');  //カラム追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('label_done_nums', function (Blueprint $table) {
            //
            $table->dropColumn('settingId');  //カラムの削除
        });
    }
}
