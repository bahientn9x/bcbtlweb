<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('ok_products', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('member_id');
//            $table->integer('cate_id');
//            $table->string('name');
//            $table->text('desc')->nullable();
//            $table->string('website')->comment('Link website')->nullable();
//            $table->text('icon')->comment('Đường dẫn file ảnh')->nullable();
//            $table->integer('states')->nullable();
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ok_products');
    }
}
