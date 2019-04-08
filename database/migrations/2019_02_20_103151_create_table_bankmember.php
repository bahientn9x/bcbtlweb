<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBankmember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_bankmember', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('account_name')->comment('Tên tài khoản');
            $table->string('account_number')->comment('Số tài khoản');
            $table->string('bank_name')->comment('Tên ngân hàng');
            $table->string('department')->comment('Chi nhánh ngân hàng');
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
        Schema::dropIfExists('ok_bankmember');
    }
}
