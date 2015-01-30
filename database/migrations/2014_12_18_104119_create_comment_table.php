<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{

    /**
     *
     * Run the migrations.
     * 评论
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->bigInteger('uid')->index()->comment('用户ID');
            $table->bigInteger('reply_uid')->nullable()->comment('用户ID');
            $table->bigInteger('fid')->comment('热度点ID');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('status')->default(1)->comment('状态');
            // created_at, updated_at DATETIME
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *$
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('comment');
    }
}
