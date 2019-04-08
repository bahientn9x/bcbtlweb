<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBankadminTras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_bankadmin_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('type')->comment('BUY/SELL');
            $table->integer('bankadmin_id')->default(0)->comment('Nạp thì đay là tài khoản nhận (lấy tài khoản có số dư ít nhất của admin); còn lại = 0');
            $table->integer('bankmember_id')->comment('Là tài khoản nhận trong trường hợp yêu cầu rút, còn lại = 0');
            $table->decimal('total', 10, 2)->default(0)->comment('Số tiền giao dịch');
            $table->decimal('fee', 10, 2)->default(0)->comment('Phí giao dịch');
            $table->text('note')->nullable();
            $table->tinyInteger('states')->default(0)->comment('0: đặt cọc, không được rút về, 1: đã duyệt có thể rút về');
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
        Schema::dropIfExists('ok_bankadmin_trans');
    }
}
