<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Menu::truncate();

        Schema::enableForeignKeyConstraints();

        DB::table('menus')->insert([
            [
                'name' => '經典韓式拌飯 (Bibimbap)',
                'description' => '豐富蔬菜搭配特製辣醬，營養均衡的經典選擇。',
                'price' => 180.00,
                'category' => '主餐',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '豪華牛肉拌飯',
                'description' => '在經典拌飯的基礎上，加入鮮嫩多汁的炒牛肉。',
                'price' => 220.00,
                'category' => '主餐',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '泡菜豬肉鍋 (Kimchi Jjigae)',
                'description' => '酸辣開胃的泡菜鍋，搭配豬五花與豆腐，附白飯一碗。',
                'price' => 250.00,
                'category' => '主餐',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => '韓式炸雞 (小份)',
                'description' => '酥脆外皮裹上甜辣醬汁，讓人吮指回味。',
                'price' => 120.00,
                'category' => '小菜',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '海鮮煎餅',
                'description' => '滿滿的蝦仁與花枝，每一口都是大海的滋味。',
                'price' => 150.00,
                'category' => '小菜',
                'is_available' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => '可口可樂',
                'description' => '清涼解渴的經典碳酸飲料。',
                'price' => 40.00,
                'category' => '飲料',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '韓國水梨汁',
                'description' => '喝得到果肉的道地韓國進口飲料。',
                'price' => 60.00,
                'category' => '飲料',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
