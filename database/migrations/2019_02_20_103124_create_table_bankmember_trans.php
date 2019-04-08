<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBankmemberTrans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ok_bankmember_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('Nạp / Rút / Thanh toán đơn hàng / hoàn tiền do hủy đơn hàng Nạp (DEPOSIT): + Rút (WITHDRAW): - Một giao dịch mua hàng sẽ xuất hiện 2 bản ghi: (bản ghi trừ tiền của người mua và bản nghi cộng tiền của người bán) thanh toán đơn hàng (BUY): - Hoàn tiền vì hủy đơn hàng (GETBACK): + Người bán: Nhận tiền bán hàng: (SELL) + Hoàn tiền vì hủy đơn hàng (REFUND)');
            $table->integer('bankmember_id')->comment('Nạp: để trống [0] - Rút: Lưu thông tin tài khoản nhận')->nullable();
            $table->integer('sender_id')->comment('id người gửi hàng')->nullable();
            $table->integer('receiver_id')->comment('id người nhận hàng')->nullable();
            $table->integer('order_id')->nullable();
            $table->decimal('total', 10, 2)->default(0)->comment('Tổng này cần chú ý nếu dư có là + còn lại là -');
            $table->decimal('fee', 10, 2)->default(0)->comment('Phí giao dịch');
            $table->text('note')->nullable();
            $table->string('verifyToken')->nullable();
            $table->tinyInteger('states')->default(0)->comment('0: đặt cọc, không được rút về 1: đã duyệt có thể rút về');
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
        Schema::dropIfExists('ok_bankmember_trans');
    }
}
