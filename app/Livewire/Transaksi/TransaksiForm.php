<?php
namespace App\Livewire\Transaksi;

use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Livewire\Component;

class TransaksiForm extends Component
{
    public $products;
    public $cart = [];
    public $totalHarga = 0;

    public function mount()
    {
        // Mengambil semua produk dari database
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        // Cek apakah produk sudah ada di dalam keranjang
        $index = array_search($productId, array_column($this->cart, 'product_id'));

        if ($index !== false) {
            // Jika produk sudah ada di keranjang, tambahkan jumlahnya
            $this->cart[$index]['jumlah']++;
            $this->cart[$index]['subtotal'] += $product->price;
        } else {
            // Jika produk belum ada di keranjang, tambahkan produk baru ke dalam keranjang
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'jumlah' => 1,
                'subtotal' => $product->price
            ];
        }

        // Update total harga
        $this->updateTotal();
    }

    public function updateTotal()
    {
        // Menghitung total harga keranjang
        $this->totalHarga = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function processTransaction()
    {
        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'tanggal' => now(),
            'total_harga' => $this->totalHarga,
        ]);

        // Simpan detail transaksi
        foreach ($this->cart as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Tampilkan pesan sukses dan reset keranjang
        session()->flash('success', 'Transaksi berhasil!');
        $this->reset('cart', 'totalHarga');
    }

    public function render()
    {
        // Menampilkan view livewire untuk form transaksi
        return view('livewire.transaksi.transaksi-form');
    }
}
