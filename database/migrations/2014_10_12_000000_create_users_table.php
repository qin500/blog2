<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('logo')->comment('logo');
            $table->string('copyright')->comment('版权');
            $table->string('keywords')->comment('关键字');
            $table->string('description')->comment('网站描述');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('blog_title')->default('在路上博客');
            $table->string('tongji')->nullable();
            $table->string('say')->default("这个家伙什么也没写");
            $table->string('avatar')->default("头像");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
