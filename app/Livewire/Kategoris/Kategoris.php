<?php

namespace App\Livewire\kategoris;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\kategori;

class kategoris extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'updateDescription' => 'setDescription', // Listener untuk CKEditor
    ];
    


    #[Locked]
    public $kategori_id;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $description = '';

    public $isEdit = false;

    public $isAdd = true;

    public $title = 'Add New kategori';

    protected $paginationTheme = 'bootstrap';

    public function resetFields()
    {
        $this->title = 'Add New kategori';

        $this->reset('name', 'description');

        $this->isEdit = false;

        $this->isAdd = true;
    }

    public function index()
{
    return view('livewire.kategori'); // Mengarahkan ke resources/views/livewire/kategori.blade.php
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
    kategori::updateOrCreate(['id' => $this->kategori_id], [
        'name' => $this->name,
        'description' => $this->description,
    ]);

    // Menampilkan pesan sukses
    session()->flash('success', $this->kategori_id ? 'kategori updated!' : 'kategori created!');

    // Mereset properti form tanpa emit
    $this->reset(['name', 'description', 'kategori_id']);
}



    public function edit($id)
    {
        $this->title = 'Edit kategori';

        $kategori = kategori::findOrFail($id);

        $this->kategori_id = $id;

        $this->name = $kategori->name;

        $this->description = $kategori->description;

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

    public function updateDescription($value)
    {
        $this->description = $value; // Update deskripsi dari CKEditor
    }

    public function render()
{
    $kategoris = kategori::where('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                        ->paginate(5);

                        return view('livewire.kategoris.kategoris', [
                            'kategoris' => $kategoris,
                        ]);
}

}
