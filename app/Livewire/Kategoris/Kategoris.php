<?php

namespace App\Livewire\Kategoris;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\kategori;

class kategoris extends Component
{
    use WithPagination;

    public $searchTerm;

    public $extraCategories = [];

    public $inputs = [];

    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    


    #[Locked]
    public $kategori_id;

    #[Validate('required')]
    public $name = '';

    public $isEdit = false;

    public $isAdd = true;

    public $title = 'Add New kategori';

    protected $paginationTheme = 'bootstrap';

    public function resetFields()
    {
        $this->title = 'Add New kategori';

        $this->reset('name');

        $this->isEdit = false;

        $this->isAdd = true;
    }

    public function index()
{
    return view('livewire.kategori'); // Mengarahkan ke resources/views/livewire/kategori.blade.php
}


public function addMore()
    {
        $this->extraCategories[] = ['name' => '']; // Tambah input baru ke array
    }
    public function save()
    {
        // Validasi input dasar
        $this->validate([
            'name' => 'required',  // Validasi untuk field name
            'inputs.*.name' => 'required', // Validasi untuk setiap input dalam array inputs
        ]);
    
        // Menyimpan atau memperbarui kategori utama
        $kategori = kategori::updateOrCreate(['id' => $this->kategori_id], [
            'name' => $this->name
        ]);
    
        // Jika ada inputs tambahan yang ditambahkan menggunakan Add More, simpan ke database
        foreach ($this->inputs as $input) {
            // Sesuaikan logika ini jika kamu ingin menyimpan input ke tabel yang terpisah
            // Misalnya menyimpan ke tabel terkait dengan kategori yang sama
            kategori::create([
                'kategori_id' => $kategori->id,  // Hubungkan dengan kategori utama yang baru saja disimpan
                'name' => $input['name']  // Simpan nama dari input Add More
            ]);
        }
    
        // Menampilkan pesan sukses
        session()->flash('success', $this->kategori_id ? 'Kategori updated!' : 'Kategori created!');
    
        // Mereset form tanpa emit
        $this->reset(['name', 'inputs', 'kategori_id']);
    }
    


    public function edit($id)
    {
        $this->title = 'Edit kategori';

        $kategori = kategori::findOrFail($id);

        $this->kategori_id = $id;

        $this->name = $kategori->name;

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
    kategori::find($id)->delete();

    session()->flash('success', 'kategori has been deleted.');
}


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
{
    $kategoris = kategori::where('name', 'like', '%' . $this->searchTerm . '%')
                        ->paginate(5);

                        return view('livewire.kategoris.kategoris', [
                            'kategoris' => $kategoris,
                        ]);
}

}
