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
        Schema::create('favorite', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('favorite_id')->comment('ID');
            $table->bigInteger('uid')->index()->comment('用户ID');
            $table->tinyInteger('is_public')->default(0)->comment('是否公开');
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
        Schema::dropIfExists('favorite');
    }

}
