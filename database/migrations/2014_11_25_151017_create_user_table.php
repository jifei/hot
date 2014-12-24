<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{

    /**
     * Run the migrations.
     * 用户表
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('uid')->comment('用户ID');
            $table->string('name')->nullable()->unique()->comment('用户名');
            $table->tinyInteger('user_type')->default(1)->comment('用户类别');//1:普通用户，10:采集用户
            $table->tinyInteger('level_id')->default(1)->comment('用户等级');
            $table->string('nickname')->nullable()->unique()->comment('用户昵称');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('password', '100')->nullable()->comment('密码');
            $table->string('email', '60')->unique()->comment('邮箱');
            $table->integer('mobile')->nullable()->unique()->comment('手机号');
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
        Schema::dropIfExists('user');
    }

}
