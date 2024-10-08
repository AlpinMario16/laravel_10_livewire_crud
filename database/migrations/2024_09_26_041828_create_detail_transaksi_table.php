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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id(); // Primary Key

            // Kolom relasi ke tabel transaksi dan produk
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Kolom tambahan
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
