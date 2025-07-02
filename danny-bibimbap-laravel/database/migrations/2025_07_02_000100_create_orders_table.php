<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderID'); 
            
            $table->string('customerName')->default('現場客');
            $table->string('customerPhone')->nullable();
            $table->string('tableNumber');
            $table->json('menuChoices')->comment('此欄位可考慮棄用');
            $table->decimal('totalPrice', 10, 2);
            $table->string('orderStatus')->default('待處理');
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

