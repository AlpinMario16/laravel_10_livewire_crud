<?php
namespace App\Livewire\Transaksi;

use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiForm extends Component
{
    use WithPagination;

    public $search = ''; // Properti untuk pencarian
    public $cart = [];
    public $totalHarga = 0;
    public $invoice;
    public $customerName;
    public $jml_bayar = 0;
    public $kembalian = 0;

    public function updatingSearch()
    {
        // Reset pagination saat melakukan pencarian baru
        $this->resetPage();
    }

    public function mount()
    {
        $this->invoice = 'INV' . date('Ymd') . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        $index = array_search($productId, array_column($this->cart, 'product_id'));

        if ($index !== false) {
            $this->cart[$index]['jumlah']++;
            $this->cart[$index]['subtotal'] += $product->price;
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'jumlah' => 1,
                'subtotal' => $product->price
            ];
        }

        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->totalHarga = array_sum(array_column($this->cart, 'subtotal'));
        $this->calculateKembalian();
    }

    public function deleteProductFromCart($productId)
    {
        $index = array_search($productId, array_column($this->cart, 'product_id'));

        if ($index !== false) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
            $this->updateTotal();
        }
    }

    public function updatedJmlBayar($value)
    {
        $this->calculateKembalian();
    }

    public function calculateKembalian()
    {
        if ($this->jml_bayar >= $this->totalHarga) {
            $this->kembalian = $this->jml_bayar - $this->totalHarga;
        } else {
            $this->kembalian = 0;
        }
    }

    public function processTransaction()
    {
        // Validasi dan pemrosesan transaksi
    }

    public function render()
    {
        // Menambahkan search dan pagination ke query produk
        $products = Product::where('name', 'like', '%'.$this->search.'%')
                            ->paginate(10); // Atur pagination
        
        return view('livewire.transaksi.transaksi-form', [
            'products' => $products,
        ]);
    }
}
