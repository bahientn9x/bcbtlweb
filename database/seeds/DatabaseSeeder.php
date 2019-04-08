<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
        DB::table('ok_users')->insert([
            'id' => 1,
           'name' => 'Admin',
           'email' => 'admin@gmail.com',
           'password' => '$2y$10$CppaatO1f2E0lsSAEVhlJe3.fRvaJx3WFDOIWunyfCdv7q5g.wY1.',
            'phone' => '0912345678',
            'balance' => '10000000',
            'states' => 1,
        ]);

//        DB::table('ok_banks')->insert([
//           'bank_name' => 'Vietinbank',
//           'bank_fullname' => 'Vietinbank Thai Nguyen'
//        ]);
//
//        DB::table('ok_bankadmin')->insert([
//           'admin_id' => 1,
//            'account_name' => "0104423452334",
//            'account_number' => 'asdk12j3k12j3k21lj3',
//            'bank_name' => 'Vietinbank',
//            'department' => 'Thái Nguyên',
//            'balance' => '10000000',
//            'states' => 1
//        ]);
//
//        DB::table('ok_category')->insert([
//           'name' => "Đồ điện tử",
//           'desc' => "Mơi mua bán điện thoại, máy tính, tivi ....",
//            'icon' => 'img/Icon/cate4.png'
//        ]);
//
//        DB::table('ok_category')->insert([
//            'name' => "Quần áo",
//            'desc' => "Mơi mua bán quần áo ....",
//            'icon' => 'img/Icon/cate1.png'
//        ]);
//
//        DB::table('ok_category')->insert([
//            'name' => "Đồ gia dụng",
//            'desc' => "Mơi mua bán đồ gia dụng cho cuộc sống ....",
//            'icon' => 'img/Icon/cate6.png'
//        ]);
//
//        DB::table('ok_category')->insert([
//            'name' => "Đồ gỗ",
//            'desc' => "Mơi mua bán bàn ghế, tủ ....",
//            'icon' => 'img/Icon/cate5.png'
//        ]);
//
//        DB::table('ok_category')->insert([
//            'name' => "Nhà truyện",
//            'desc' => "Mơi mua bán sách đọc, tài liệu ....",
//            'icon' => 'img/Icon/cate8.png'
//        ]);
    }
}
