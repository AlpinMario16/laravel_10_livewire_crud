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
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Jangan tambahkan kembali kolom id jika sudah ada
            // $table->id(); // Kolom ini dihapus atau dikomentari

            // Kolom relasi ke tabel transaksi dan product
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
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan jika rollback
            $table->dropForeign(['transaksi_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['transaksi_id', 'product_id', 'jumlah', 'subtotal']);
        });
    }
};
