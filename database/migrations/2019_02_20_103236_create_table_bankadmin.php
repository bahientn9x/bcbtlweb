<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBankadmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_bankadmin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->string('account_name')->comment('Tên tài khoản');
            $table->string('account_number')->comment('Số tài khoản');
            $table->string('bank_name')->comment('Tên ngân hàng');
            $table->string('department')->comment('Chi nhánh của ngân hàng');
            $table->decimal('balance', 10, 2)->default(0)->comment('Số dư, tiền sẽ được chuyển vào tài khoản có số dư nhỏ nhất');
            $table->tinyInteger('states')->default(0)->comment('Trang thái: 0 không kích hoạt, 1 kích hoạt Admin có nhiều tài khoản, chỉ những tài khoản được kích hoạt mới có thể giao dịch nhận $');
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
        Schema::dropIfExists('ok_bankadmin');
    }
}
