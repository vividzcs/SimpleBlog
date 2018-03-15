<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('link_id');
            $table->string('link_name',50)->default('')->comment('//名称');
            $table->string('link_title')->default('')->comment('//简介');
            $table->string('link_url')->default('')->comment('//链接');
            $table->integer('link_order')->default(0)->comment('//排序');
            $table->integer('pubtime')->default(0)->comment('//发布时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
