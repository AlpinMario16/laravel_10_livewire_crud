<div x-data="{ showForm: true, isProcessing: false, initializeEditor: () => {
    setTimeout(() => {
        if (!ClassicEditor.instances['description']) {
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => console.error(error));
        }
    }, 50); // Tunda untuk memastikan elemen sudah di-render
}}" class="row justify-content-center mt-3 mb-3">
    <div class="col-md-12">

        <!-- Formulir -->
        <div x-show="showForm" class="card">
            <div class="card-header">
                <div class="float-start">
                    {{ $title }}
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="isProcessing = true; $wire.save().then(() => isProcessing = false)">

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Name :</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kategori_id" class="col-md-4 col-form-label text-md-end text-start">Product Kategori :</label>
                        <div class="col-md-6">
                            <select class="form-control" id="kategori_id" wire:model="kategori_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3 row" wire:ignore>
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Product Description :</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model.defer="description"></textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Product Price :</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="price" wire:model="price" placeholder="Enter product price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tambahkan input file untuk gambar -->
                    <div class="mb-3 row">
                        <label for="image" class="col-md-4 col-form-label text-md-end text-start">Image :</label>
                        <div class="col-md-6">
                            <input type="file" wire:model="image" id="image" class="form-control">
                            @if($image)
                                <img src="{{ $image->temporaryUrl() }}" width="100" class="mt-2" alt="Preview Image">
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <button type="submit" class="col-md-3 offset-md-5 btn btn-success" :disabled="isProcessing">
                            Simpan
                        </button>
                    </div>

                    @if($isEdit)
                        <div class="mb-3 row">
                            <button @click="showForm = false" wire:click="cancel" class="col-md-3 offset-md-5 btn btn-danger">
                                Cancel
                            </button>
                        </div>
                    @endif

                    <!-- Tombol Add More -->
                    @if($isAdd)
                        <div class="mb-3 row">
                            <button type="button" class="col-md-3 offset-md-5 btn btn-primary" @click="inputs.push({ name: '', description: '' })">
                                Add More
                            </button>
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <span x-show="isProcessing" class="col-md-3 offset-md-5 text-primary">Processing...</span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan skrip CKEditor -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const descriptionElement = document.querySelector('#description');
    let editorInstance;

    if (descriptionElement) {
        ClassicEditor
            .create(descriptionElement)
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => {
                console.error('Error initializing ClassicEditor:', error);
            });
    } else {
        console.error('Element with id #description not found.');
    }

    // Emit data sebelum form submit
    Livewire.on('submitForm', () => {
        const descriptionData = editorInstance.getData();
        Livewire.emit('updateDescription', descriptionData); // Emit data CKEditor ke Livewire
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
