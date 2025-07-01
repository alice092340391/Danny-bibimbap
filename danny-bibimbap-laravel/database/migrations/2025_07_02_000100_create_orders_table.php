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
        Schema::create('orders', function (Blueprint $table) {
            // 使用我們之前約定好的 'OrderID' 作為主鍵
            $table->id('OrderID'); 
            
            $table->string('customerName')->default('現場客');
            $table->string('customerPhone')->nullable();
            $table->string('tableNumber');
            $table->json('menuChoices')->comment('此欄位可考慮棄用');
            $table->decimal('totalPrice', 10, 2);
            $table->string('orderStatus')->default('待處理');
            
            // Laravel 預設會需要 timestamps
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

