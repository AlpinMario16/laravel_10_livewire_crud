<?php

namespace App\Livewire;

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
        'updateDescription' => 'updateDescription', // Listener untuk CKEditor
    ];
    


    #[Locked]
    public $product_id;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $description = '';

    public $isEdit = false;

    public $title = 'Add New Product';

    protected $paginationTheme = 'bootstrap';

    public function resetFields()
    {
        $this->title = 'Add New Product';

        $this->reset('name', 'description');

        $this->isEdit = false;
    }

    public function save()
{
    $this->validate([
        'name' => 'required',
        'description' => 'required',
    ]);

    Product::updateOrCreate(['id' => $this->product_id], [
        'name' => $this->name,
        'description' => $this->description,
    ]);

    session()->flash('success', $this->product_id ? 'Product updated!' : 'Product created!');

    // Emit untuk mereset editor setelah menyimpan
    $this->emit('resetFields');
    $this->resetFields();
}


    public function edit($id)
    {
        $this->title = 'Edit Product';

        $product = Product::findOrFail($id);

        $this->product_id = $id;

        $this->name = $product->name;

        $this->description = $product->description;

        $this->isEdit = true;
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

    return view('livewire.products', [
        'products' => $products,
    ]);
}

}
