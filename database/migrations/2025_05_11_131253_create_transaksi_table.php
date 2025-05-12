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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran'); 
            $table->string('name_pelanggan');
            $table->string('no_telpon');
            $table->string('alamat');
            $table->string('email');
            $table->string('name_seles'); 
            $table->string('metode_pembayaran')->nullable();;
            $table->integer('total_belanja');
            $table->integer('uang_dibayar')->nullable();;
            $table->integer('kembalian')->nullable();
            $table->enum('status', ['pending', 'dibayar'])->default('pending');
            $table->timestamp('waktu_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
