<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->comment('Sử dụng email làm username luôn');
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('phone')->nullable();
            $table->string('address')->comment('Địa chỉ theo chúng minh thư')->nullable();
            $table->string('so_cmnd')->comment('Số chứng minh thư')->nullable();
            $table->string('cmt_1')->comment('Mặt trước CMND')->nullable();
            $table->string('cmt_2')->comment('Mặt sau CMND')->nullable();
            $table->string('cmt_3')->comment('CMND chụp cùng gương mặt')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('ok_members');
    }
}
