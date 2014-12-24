<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpDownTable extends Migration {

	/**
     *
	 * Run the migrations.
	 * up down操作
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('board', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('操作ID');
            $table->bigInteger('hid')->index()->comment('热点ID');
            $table->bigInteger('uid',0)->comment('用户ID');
            $table->tinyInteger('type')->index()->comment('操作类别1:up,-1,down');
            $table->tinyInteger('status', 1)->comment('状态');
            // created_at, updated_at DATETIME
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('up_down');
    }

}
