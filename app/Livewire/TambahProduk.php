<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Kategori;

class TambahProduk extends Component
{
    use WithFileUploads;

    public $name, $kategori_id, $description, $price, $image;
    

    public function saveProduct()
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

    public function resetFields()
{
    $this->name = '';
    $this->kategori_id = '';
    $this->description = '';
    $this->price = '';
    $this->image = null;
    // $this->isEdit = false; // Set ke false jika digunakan untuk menandakan mode edit
    $this->resetErrorBag(); // Reset error jika ada validasi yang sebelumnya gagal
    $this->resetValidation(); // Reset validasi untuk menghapus pesan error lama
}

public function updateDescription($value)
    {
        $this->description = $value;
    }


    public function render()
    {
        $kategoris = kategori::all();
        return view('livewire.products.tambah-produk', compact('kategoris'));
    }
}
