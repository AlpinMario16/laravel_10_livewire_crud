<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Data has been saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @include('livewire.updateOrCreate')

        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">
            <div class="input-group mb-3">
    <input type="text" wire:model="searchTerm" placeholder="Cari Produk..." class="form-control form-control-sm" aria-label="Search">
<div class="input-group-append">

    <button class="btn btn-info btn-sm ml-2" type="button" wire:click="$refresh">Cari</button>
</div>
            </div>





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
                                <td>{!! $product->description !!}</td> <!-- Support untuk konten HTML -->
                                <td>
                                    <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>   

                                    <button wire:click="deleteConfirmed({{ $product->id }})" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
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

                <!-- Kontrol Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- Inisialisasi CKEditor -->


<script>
    document.addEventListener('livewire:load', function () {
        // Inisialisasi CKEditor untuk description
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                // Sinkronkan data CKEditor dengan Livewire
                editor.model.document.on('change:data', () => {
                    Livewire.emit('updateDescription', editor.getData()); // Emit ke Livewire
                });
            })
            .catch(error => {
                console.error(error);
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
                Livewire.emit('deleteConfirmed', event.detail.id);
                
                Swal.fire(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                );
            }
        });
    });
</script>