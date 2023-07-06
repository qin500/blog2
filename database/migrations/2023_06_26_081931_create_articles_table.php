<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment('标题');
            $table->string("cid")->comment('分类id');
            $table->string("publish")->comment('是否公开');
            $table->string("views")->comment('点击量');
            $table->string("tag")->comment('标签');
            $table->string("log_text")->comment('原始文本');
            $table->string("strip_text")->comment('去除标签后文本');
            $table->string("cover")->comment('封面图片');
            $table->string("istop")->default("0")->comment('是否置顶');
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
        Schema::dropIfExists('articles');
    }
}
