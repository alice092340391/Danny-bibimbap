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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // 關聯到 orders 資料表的 OrderID
            $table->foreignId('order_id')->constrained(
                table: 'orders', column: 'OrderID'
            )->onDelete('cascade');

            // 關聯到 menus 資料表的 id
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('price', 8, 2); // 儲存下單時的單價
            $table->timestamps();
        });

        // 我們已經把修改 menus 資料表的邏輯移到它自己的 migration 檔案中了
        // 所以這裡不再需要那段 Schema::table('menus', ...) 的程式碼
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
