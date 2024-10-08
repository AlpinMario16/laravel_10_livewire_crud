<div>
    <form wire:submit.prevent="saveProduct">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" placeholder="Masukkan nama produk" wire:model="name" required>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" wire:model="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" wire:ignore x-data x-init="
    ClassicEditor
        .create($refs.editor)
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('description', editor.getData());
            });
        })
        .catch(error => {
            console.error(error);
        });
">
    <label for="description" class="form-label">Description</label>
    <textarea x-ref="editor" wire:model.defer="description" class="form-control" rows="4">{{ $description }}</textarea>
    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
</div>



        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" placeholder="Masukkan harga produk" wire:model="price" required>
        </div>
        <div class="mb-3 row">
    <label for="image" class="col-md-4 col-form-label text-md-end text-start">Image :</label>
    <div class="col-md-6">
        <input type="file" wire:model="image" id="image" class="form-control">
        
        <!-- Tampilkan preview gambar jika sudah dipilih -->
        @if($image)
            <div class="mt-2">
                <img src="{{ $image->temporaryUrl() }}" width="100" alt="Preview Image" class="img-thumbnail">
            </div>
        @endif
    </div>
</div>

        <button type="submit" class="btn btn-primary">Simpan Produk</button>
    </form>
</div>

<script>
 document.addEventListener('livewire:load', function () {
    ClassicEditor
        .create(document.querySelector('#description'))
        .then(editor => {
            // CKEditor berhasil dibuat, cek apakah inisialisasi berhasil
            console.log('CKEditor berhasil diinisialisasi.');

            // Set event listener untuk perubahan data pada editor
            editor.model.document.on('change:data', () => {
                // Emit perubahan ke Livewire
                Livewire.emit('updateDescription', editor.getData());

                // Log deskripsi untuk debug
                console.log('description', editor.getData());
            });
        })
        .catch(error => {
            console.error('Error menginisialisasi CKEditor:', error);
        });
});

function success() {
    Swal.fire({
        position: 'center',
        icon: "success",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
    });
}

function deleteConfirmed(id) {
    Swal.fire({
        title: "Deleted!",
        text: "Produk berhasil Dihapus.",
        icon: "success"
    });
}
</script>

