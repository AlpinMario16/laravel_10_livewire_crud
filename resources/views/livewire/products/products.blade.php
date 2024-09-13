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

        @include('livewire.products.updateOrCreate')

        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">
            <div class="input-group mb-3">
            <div class="input-group-append">
    <input type="text" wire:model.live="searchTerm" placeholder="Cari Produk..." class="form-control form-control-sm" aria-label="Search">
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

                                    
                    <button 
         
                          @click="deleteConfirmed({{ $product->id }})" wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm">
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

