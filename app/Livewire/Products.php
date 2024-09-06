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

    public $search;

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

        $this->reset('name', 'description', 'product_id');

        $this->isEdit = false;
    }

    public function save()
{
    // Validasi secara eksplisit
    $this->validate([
        'name' => 'required',
        'description' => 'required',
    ]);

    Product::updateOrCreate(['id' => $this->product_id], [
        'name' => $this->name,
        'description' => $this->description,
    ]);

    // Reset field setelah menyimpan
    $this->resetFields();

    // Kirim notifikasi sukses ke browser
    $this->dispatchBrowserEvent('alert', [
        'type' => 'success',
        'message' => $this->product_id ? 'Product is updated.' : 'Product is added.'
    ]);
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

    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent('triggerDelete', ['id' => $id]);
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        
        $this->dispatchBrowserEvent('alert',[
             'type'=>'success',
             'message'=>'Product deleted successfully.'
         ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::latest()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('livewire.products', [
            'products' => $products,
        ]);
    }
}
