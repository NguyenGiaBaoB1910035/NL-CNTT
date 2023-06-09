<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\StaffHistory;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //////////////////////////////////////////////////////
        //Điền thông tin ở đâyyyyy
        $user_quantity = 0;//Số người dùng random
        $product_quantity = 0;//Số sản phẩm random
        //////////////////////////////////////////////////////

        UserType::insert([
            ['user_type' => 'Admin'],
            ['user_type' => 'Staff'],
            ['user_type' => 'Client'],
        ]);

        User::insert([
            [
                'role'  => 1,
                'fullname' => 'Adminstrator',
                'email' => 'admin',
                'address' => 'Cần Thơ',
                'phone' => 'admin',
                'gender' => 'Nam',
                'password' => bcrypt('admin'),
            ],
            [
                'role'  => 2,
                'fullname' => 'Staff',
                'email' => 'staff',
                'address' => 'Cần Thơ',
                'phone' => 'staff',
                'gender' => 'Nam',
                'password' => bcrypt('staff'),
            ],
            [
                'role'  => 3,
                'fullname' => 'Nguyễn Gia Bảo',
                'email' => 'nbao@gmail.com',
                'phone' => '0377808122',
                'address' => 'Cần Thơ',
                'gender' => 'Nam',
                'password' => bcrypt('123456'),
            ],
        ]);


        ProductType::insert([
            ['name_type' => 'Nhẫn'],
            ['name_type' => 'Bông Tai'],
            ['name_type' => 'Dây Chuyền'],
            ['name_type' => 'Lắc & Vòng Tay'],
            ['name_type' => 'Dây Cổ'],
            ['name_type' => 'Charm'],
        ]);

        User::factory($user_quantity)->create();//create user random(staff, client)

        $u = User::all();

        foreach($u as $v){
            StaffHistory::insert([
                'staff_id' => $v->id,
                'title' => 'Tài khoản đã được tạo',
                'content' => "Tài khoản đã được tạo:\n".
                "● Full Name: $v->fullname\n".
                "● Giới tính: $v->gender\n".
                "● Địa chỉ: $v->address\n".
                "● Số điện thoại: $v->phone\n".
                "● Email: $v->email\n",
            ]);
        }

        Product::factory($product_quantity)->create();//Create product

        for ($i = 1; $i <= $product_quantity; $i++) {//create product images
            for ($j = 1; $j <= 3; $j++) {
                ProductImage::factory()->create([
                    'product_id' => $i,
                ]);

            }
        }
    }
}
