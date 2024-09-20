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
    public $invoice; // Nomor invoice
    public $customerName; // Nama customer
    public $jml_bayar = 0; // Jumlah bayar yang diinput
    public $kembalian = 0; // Kembalian yang dihitung
    public function mount()
    {
        // Mengambil semua produk dari database
        $this->products = Product::all();

        // Menghasilkan nomor invoice otomatis
        $this->invoice = 'INV' . date('Ymd') . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);

        // Inisialisasi keranjang dan harga total
        $this->cart = [];
        $this->totalHarga = 0;
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
        
        // Hitung kembalian setelah update total harga
        $this->calculateKembalian();

    }
    
    public function deleteProductFromCart($productId)
    {
        // Mencari produk di keranjang berdasarkan ID
        $index = array_search($productId, array_column($this->cart, 'product_id'));
        
        if ($index !== false) {
            // Hapus produk dari keranjang
            unset($this->cart[$index]);
            
            // Reindex array setelah item dihapus
            $this->cart = array_values($this->cart);
            
            // Update total harga setelah penghapusan
            $this->updateTotal();
        }
    }
    public function updatedJmlBayar($value)
{
    $this->calculateKembalian();
}

public function calculateKembalian()
{
    // Menghitung kembalian jika jumlah bayar lebih besar dari atau sama dengan total harga
    if ($this->jml_bayar >= $this->totalHarga) {
        $this->kembalian = $this->jml_bayar - $this->totalHarga;
    } else {
        $this->kembalian = 0;
    }
}


    public function processTransaction()
    {
        // Validasi apakah jumlah bayar cukup
        if ($this->jml_bayar < $this->totalHarga) {
            session()->flash('error', 'Jumlah bayar tidak mencukupi!');
            return;
        }

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'invoice' => $this->invoice,               // Nomor invoice
            'customer_name' => $this->customerName,    // Nama customer
            'tanggal' => now(),              // Tanggal transaksi
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

        // Reset semua data yang relevan setelah transaksi selesai
        $this->reset('cart', 'totalHarga', 'customerName', 'jml_bayar', 'kembalian');

        // Generate invoice baru untuk transaksi selanjutnya
        $this->invoice = 'INV' . date('Ymd') . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        // Menampilkan view livewire untuk form transaksi
        return view('livewire.transaksi.transaksi-form');
    }
}
