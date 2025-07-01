<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 這個 migration 現在會完整定義 menus 資料表的所有欄位
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // 標準的自動增長主鍵
            $table->string('name'); // 餐點名稱
            $table->text('description')->nullable(); // 餐點描述，可以為空
            $table->decimal('price', 8, 2); // 餐點價格
            $table->string('category')->default('主餐'); // 餐點分類
            $table->boolean('is_available')->default(true); // 是否上架（可點餐）
            $table->timestamps(); // created_at 和 updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
