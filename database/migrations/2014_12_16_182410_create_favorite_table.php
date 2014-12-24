<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteTable extends Migration {

    /**
     *
     * Run the migrations.
     * 收藏
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comment', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->bigInteger('hid')->index()->comment('热点ID');
            $table->bigInteger('uid')->index()->comment('用户ID');
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
        Schema::dropIfExists('comment');
    }

}
