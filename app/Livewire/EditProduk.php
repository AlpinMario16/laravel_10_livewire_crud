<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Kategori;

class EditProduk extends Component
{
    use WithFileUploads;

    public $productId, $name, $kategori_id, $description, $price, $image;

    // Metode mount untuk mengambil data produk yang akan diedit
    public function mount($productId)
    {
        $product = Product::find($productId);
        
        if ($product) {
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->kategori_id = $product->kategori_id; // Pastikan ini sesuai dengan relasi yang ada
            $this->description = $product->description;
            $this->price = $product->price;
            $this->image = $product->image; // Hanya untuk menampilkan nama file, jika diperlukan
        }
    }

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'kategori_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Validasi gambar
        ]);

        // Upload gambar jika ada
        $imageName = $this->image ? $this->image->store('products', 'public') : null;

        $product = Product::find($this->productId);
        
        if ($product) {
            $product->update([
                'name' => $this->name,
                'kategori_id' => $this->kategori_id,
                'description' => $this->description,
                'price' => $this->price,
                'image' => $imageName ?? $product->image, // Tetap gunakan gambar lama jika tidak ada yang diupload
            ]);

            session()->flash('success', 'Produk berhasil diperbarui!');
            $this->resetFields(); // Reset form setelah simpan
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->kategori_id = '';
        $this->description = '';
        $this->price = '';
        $this->image = null;
        $this->resetErrorBag(); // Reset error jika ada validasi yang sebelumnya gagal
        $this->resetValidation(); // Reset validasi untuk menghapus pesan error lama
    }

    public function render()
    {
        $kategoris = Kategori::all(); // Pastikan nama model dengan huruf kapital
        return view('livewire.products.edit-produk', compact('kategoris'));
    }
}
