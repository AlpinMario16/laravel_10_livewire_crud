<?php
namespace App\Livewire;

use Livewire\Component;

class Ckeditor extends Component
{
    public $message;

    public function submit()
    {
        // Simpan atau proses $this->message
        dd($this->message); // hanya untuk melihat apakah data dari CKEditor berhasil
    }

    public function render()
    {
        return view('livewire.ckeditor');
    }
}
