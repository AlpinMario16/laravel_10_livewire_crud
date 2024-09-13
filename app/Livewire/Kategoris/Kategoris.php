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




    public function save()
{
    // Validasi input
    $this->validate([
        'name' => 'required'
    ]);

    // Menyimpan atau memperbarui produk
    kategori::updateOrCreate(['id' => $this->kategori_id], [
        'name' => $this->name
    ]);

    // Menampilkan pesan sukses
    session()->flash('success', $this->kategori_id ? 'kategori updated!' : 'kategori created!');

    // Mereset properti form tanpa emit
    $this->reset(['name', 'kategori_id']);
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
