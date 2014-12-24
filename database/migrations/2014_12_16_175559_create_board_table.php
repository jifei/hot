<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardTable extends Migration {

	/**
	 * Run the migrations.
	 * 版块
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('board', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('bid')->comment('热点ID');
            $table->string('name',100)->unique()->comment('版块名称');
            $table->bigInteger('pid',0)->index()->comment('父ID');
            $table->bigInteger('aid',0)->index()->comment('祖先ID');
            $table->bigInteger('uid',0)->comment('用户ID');
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
        Schema::dropIfExists('board');
    }

}
