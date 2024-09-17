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
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        $this->cart[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'jumlah' => 1,
            'subtotal' => $product->price
        ];

        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->totalHarga = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function processTransaction()
    {
        $transaksi = Transaksi::create([
            'tanggal' => now(),
            'total_harga' => $this->totalHarga,
        ]);

        foreach ($this->cart as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->flash('success', 'Transaksi berhasil!');
        $this->reset('cart', 'totalHarga');
    }

    public function render()
    {
        return view('livewire.transaksi.transaksi-form');
    }
}
