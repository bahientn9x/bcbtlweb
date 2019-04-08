<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('cate_id');
            $table->string('product_name');
            $table->text('description');
            $table->text('icon');
            $table->string('type')->comment('BUY/SELL')->nullable();
            $table->string('states')->comment('seller : SENT (seller đã gửi hàng) . buyer : RECEIVED (buyer đã nhận được hàng), COMPLETE (admin đã chuyển tiền cho seller')->nullable();
            $table->decimal('num', 20, 10)->default(0)->comment('Số lượng');
            $table->decimal('price', 10, 2)->default(0)->comment('Đơn giá (VND)');
            $table->decimal('total', 10, 2)->default(0)->comment('tổng thành tiền = num*priceusd');
            $table->integer('order_id')->default(0)->comment('là order_id của người tạo ra bản ghi trước')->nullable();
            $table->string('address')->nullable();
            $table->string('phonenumber')->nullable();
            $table->text('img_sent')->nullable();
            $table->text('img_recv')->nullable();
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
        Schema::dropIfExists('ok_orders');
    }
}
