<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Kategori;
use Livewire\TemporaryUploadedFile;

class EditProduk extends Component
{
    use WithFileUploads;

    public $product; // Properti untuk menyimpan data produk
    public $name, $kategori_id, $description, $price, $image;

    // Metode mount untuk mengambil data produk yang akan diedit
    public function mount($productId)
    {
        $this->product = Product::find($productId);

        if ($this->product) {
            $this->name = $this->product->name;
            $this->kategori_id = $this->product->kategori_id; 
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->image = $this->product->image;
        }
    }

    public function edit($id)
{
    $this->product = Product::find($id); 
    // Pastikan $this->product mengisi variabel form seperti $this->name, $this->price, dsb.
}


    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'kategori_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024',
        ]);

        // Upload gambar jika ada
        if ($this->image instanceof TemporaryUploadedFile) {
            $imageName = $this->image->store('products', 'public');
        } else {
            $imageName = $this->product->image; // Pertahankan gambar lama jika tidak ada gambar baru
        }

        $this->product->update([
            'name' => $this->name,
            'kategori_id' => $this->kategori_id,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imageName,
        ]);

        session()->flash('success', 'Produk berhasil diperbarui!');
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->kategori_id = '';
        $this->description = '';
        $this->price = '';
        $this->image = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $kategoris = Kategori::all();
        return view('livewire.products.edit-produk', compact('kategoris'));
    }
}
