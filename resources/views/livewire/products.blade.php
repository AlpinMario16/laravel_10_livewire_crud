<div class="row justify-content-center mt-3">
    <div class="col-md-12">

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    {{-- Form Tambah/Edit Produk --}}
    <div class="card mb-4">
        <div class="card-header">{{ $isEdit ? 'Edit Product' : 'Add New Product' }}</div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group mb-3">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" class="form-control" wire:model="name" placeholder="Enter product name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3">
    <label for="description">Product Description</label>
    <textarea id="description" class="form-control" wire:model="description" placeholder="Enter product description"></textarea>
    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .then(editor => {
            // Mengatur CKEditor untuk tetap sinkron dengan wire:model
            editor.model.document.on('change:data', () => {
                // Memperbarui Livewire dengan nilai CKEditor
                Livewire.emit('input', 'description', editor.getData());
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>


                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-success">{{ $isEdit ? 'Update Product' : 'Add Product' }}</button>
                    @if($isEdit)
                    <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Produk --}}
    <div class="card">
        <div class="card-header">Product List</div>
        <div class="card-body">
            <input type="text" wire:model="search" placeholder="Cari produk..." class="form-control mb-3" />

            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr wire:key="{{ $product->id }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>   

                                <button wire:click="$emit('triggerDelete', {{ $product->id }})" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <span class="text-danger">
                                    <strong>No Product Found!</strong>
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Tampilkan pagination links -->
            {{ $products->links() }}
        </div>
    </div>
</div>
</div>

<script>
    // Listener untuk SweetAlert sukses
    window.addEventListener('alert', event => {
        Swal.fire({
            icon: event.detail.type,
            title: event.detail.title || 'Success',
            text: event.detail.message,
        });
    });

    // Listener untuk konfirmasi penghapusan produk
    window.addEventListener('triggerDelete', event => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Menggunakan Livewire.emit untuk memanggil fungsi delete
                Livewire.emit('delete', event.detail.id);
                
                Swal.fire(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                );
            }
        });
    });
</script>
