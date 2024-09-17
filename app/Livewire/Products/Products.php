<?php

namespace App\Livewire\Products;

use App\Models\Kategori;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Products extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'updateDescription' => 'setDescription', // Listener untuk CKEditor
    ];
    
    

    public $kategori_id;

    public $price = 0.00; // default value

    #[Locked]
    public $product_id;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $description = '';

    public $isEdit = false;

    public $isAdd = true;

    public $title = 'Add New Product';

    protected $paginationTheme = 'bootstrap';

    public function resetFields()
    {
        $this->title = 'Add New Product';

        $this->reset('name', 'description');

        $this->isEdit = false;

        $this->isAdd = true;
    }
    public function resetForm()
    {
        $this->name = '';
        $this->kategori_id = '';
        $this->description = '';
        $this->price = '';
    }
    
    public function index()
{
    return view('livewire.product'); // Mengarahkan ke resources/views/livewire/product.blade.php
}


public function kategori()
{
    return $this->belongsTo(Kategori::class, 'kategori_id');
}


public function setDescription($value)
{
    $this->description = $value;
}

public function save()
{
    $this->validate([
        'name' => 'required',
        'kategori_id' => 'required',
        'description' => 'required',
        'price' => 'required|numeric|min:0',
    ]);

    Product::updateOrCreate(['id' => $this->product_id], [
        'name' => $this->name,
        'kategori_id' => $this->kategori_id,
        'description' => $this->description,
        'price' => $this->price, // Menyimpan harga produk
    ]);

    session()->flash('success', 'Product saved!');
    $this->resetForm();
}



    public function edit($id)
    {
        $this->title = 'Edit Product';

        $product = Product::findOrFail($id);

        $this->product_id = $id;

        $this->name = $product->name;

        $this->description = $product->description;

        $this->isEdit = true;
        $this->isAdd = false;
    }

    public function cancel()
    {
        $this->resetFields();
    }

    public function deleteConfirmed($id)
{
    // Panggil method delete untuk menghapus produk
    $this->delete($id);
}

public function delete($id)
{
    Product::find($id)->delete();

    session()->flash('success', 'Product has been deleted.');
}


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateDescription($value)
    {
        $this->description = $value; // Update deskripsi dari CKEditor
    }

    public function render()
{
    $products = Product::where('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                        ->paginate(5);

    $kategoris = Kategori::all(); // Ambil semua kategori dari model Kategori

    return view('livewire.products.products', [
        'products' => $products,
        'kategoris' => $kategoris,  // Kirim data kategori ke view
    ]);
}


}
