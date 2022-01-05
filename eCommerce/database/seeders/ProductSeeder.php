<?php

namespace Database\Seeders;

use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name'=>'Samsung mobile',
            'price' =>'200',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi nesciunt culpa perferendis. Distinctio nobis pariatur deleniti quisquam molestiae corrupti corporis, ipsum quaerat nesciunt sed amet sint cum totam assumenda asperiores!',
            'category' => 'mobile',
            'gallery' => 'https://5.imimg.com/data5/NT/UC/WR/SELLER-82975943/samsung-galaxy-a7-a750-mobile-phone-500x500.jpg',
        ]);

        DB::table('products')->insert([
            'name'=>'Samsung TV',
            'price' =>'500',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi nesciunt culpa perferendis. Distinctio nobis pariatur deleniti quisquam molestiae corrupti corporis, ipsum quaerat nesciunt sed amet sint cum totam assumenda asperiores!',
            'category' => 'tv',
            'gallery' => 'https://images.samsung.com/is/image/samsung/rs-uhdtv-nu7100-ue43nu7192uxxh-frontblack-101551769?$684_547_PNG$',
        ]);

        DB::table('products')->insert([
            'name'=>'LG fridge',
            'price' =>'700',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi nesciunt culpa perferendis. Distinctio nobis pariatur deleniti quisquam molestiae corrupti corporis, ipsum quaerat nesciunt sed amet sint cum totam assumenda asperiores!',
            'category' => 'fridge',
            'gallery' => 'https://thegoodguys.sirv.com/products/50070239/50070239_712265.PNG?scale.height=505&scale.width=773&canvas.height=505&canvas.width=773&canvas.opacity=0&q=90',
        ]);
    }
}
