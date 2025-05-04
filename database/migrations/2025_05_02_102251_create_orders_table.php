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
            $table->id();
            $table->unsignedBigInteger('id_product'); 
            $table->string('kode_pembayaran');  
            $table->string('name_pelanggan');
            $table->string('no_telpon');
            $table->string('alamat');
            $table->string('email');
            $table->enum('status', ['pending', 'dibayar'])->default('pending');
            $table->string('name_seles');
            $table->timestamps();
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
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
