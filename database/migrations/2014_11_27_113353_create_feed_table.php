<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedTable extends Migration
{

    /**
     * Run the migrations.
     * 热点表
     * @return void
     */
    public function up()
    {
        //
        Schema::create('feed', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('fid')->comment('热点ID');
            $table->string('fkey',12)->unique()->comment('fkey');
            $table->bigInteger('uid')->index()->comment('用户ID');
            $table->integer('bid')->index()->comment('版块ID');
            $table->string('title', 500)->comment('标题');
            $table->string('link', 300)->nullable()->comment('链接');
            $table->string('domain', 100)->nullable()->comment('链接域名');
            $table->integer('up_num')->default(0)->comment('up次数');
            $table->integer('down_num')->default(0)->comment('down次数');
            $table->integer('comment_num')->default(0)->comment('评论次数');
            $table->integer('fav_num')->default(0)->comment('收藏次数');
            $table->dateTime('interact_at')->nullable()->comment('最后互动时间');
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
        Schema::dropIfExists('feed');
    }

}
