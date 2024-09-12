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

    public function index()
{
    return view('livewire.product'); // Mengarahkan ke resources/views/livewire/product.blade.php
}



public function setDescription($value)
{
    $this->description = $value;
}

    public function save()
{
    // Validasi input
    $this->validate([
        'name' => 'required',
        'description' => 'required',
    ]);

    // Menyimpan atau memperbarui produk
    Product::updateOrCreate(['id' => $this->product_id], [
        'name' => $this->name,
        'description' => $this->description,
    ]);

    // Menampilkan pesan sukses
    session()->flash('success', $this->product_id ? 'Product updated!' : 'Product created!');

    // Mereset properti form tanpa emit
    $this->reset(['name', 'description', 'product_id']);
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

                        return view('livewire.products.products', [
                            'products' => $products,
                        ]);
}

}
