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
        Schema::create('board', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('bid')->comment('热点ID');
            $table->string('name',100)->unique()->comment('版块名称');
            $table->string('code',20)->unique()->comment('版块code');
            $table->bigInteger('pid')->default(0)->index()->comment('父ID');
            $table->bigInteger('aid')->default(0)->index()->comment('祖先ID');
            $table->bigInteger('uid')->default(0)->comment('用户ID');
            $table->string('desc',500)->comment('描述');
            $table->integer('display_sort')->default(100)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态');
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
