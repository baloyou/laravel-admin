<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pid')->default(0); //上级菜单id
            $table->string('name',100)->default(''); //菜单名称
            $table->string('link',255)->default(''); //点击后去到哪里
            $table->string('auth',255)->default(''); //受哪个权限约束
            $table->string('icon',100)->default('fa-bars'); //显示的icon图标，参考：https://fontawesome.com/start
            $table->smallInteger('position')->default(1); //显示位置（只有1，表示左侧菜单栏）
            $table->smallInteger('sort')->default(0); //排序（asc）
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
        Schema::dropIfExists('menus');
    }
}
