<?php

namespace App\Livewire\Products;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class Products extends Component
{
    use WithFileUploads, WithPagination;

    public $searchTerm, $kategori_id, $price = 0.00, $product_id, $name = '', $description = '', $image;
    public $isEdit = false, $isAdd = true, $title = 'Add New Product';

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'updateDescription' => 'setDescription', // Listener untuk CKEditor
    ];

    public function resetFields()
    {
        $this->reset(['name', 'description', 'price', 'kategori_id', 'image']);
        $this->title = 'Add New Product';
        $this->isEdit = false;
        $this->isAdd = true;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
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
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Validasi gambar
        ]);

        // Upload gambar jika ada
        $imageName = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'name' => $this->name,
            'kategori_id' => $this->kategori_id,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imageName,
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan!');
        $this->resetFields(); // Reset form setelah simpan
    }

    public function edit($id)
    {
        $this->title = 'Edit Product';

        $product = Product::findOrFail($id);

        $this->product_id = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->kategori_id = $product->kategori_id;

        $this->isEdit = true;
        $this->isAdd = false;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'kategori_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Validasi gambar
        ]);

        $product = Product::findOrFail($this->product_id);

        // Upload gambar baru jika ada
        if ($this->image) {
            $imageName = $this->image->store('products', 'public');
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'name' => $this->name,
            'kategori_id' => $this->kategori_id,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imageName,
        ]);

        session()->flash('success', 'Produk berhasil diupdate!');
        $this->resetFields();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->searchTerm . '%')
                            ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                            ->paginate(5);

        $kategoris = Kategori::all(); // Ambil semua kategori dari model Kategori

        return view('livewire.products.products', [
            'products' => $products,
            'kategoris' => $kategoris,
        ]);
    }
}
