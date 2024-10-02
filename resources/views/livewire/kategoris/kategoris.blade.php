


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

        @include('livewire.kategoris.updateOrCreate')

        <div class="card">
            <div class="card-header">Kategori List</div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <input type="text" wire:model.debounce.500ms="searchTerm" placeholder="Cari Kategori..." class="form-control form-control-sm" aria-label="Search">
                    </div>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $kategori)
                            <tr wire:key="{{ $kategori->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $kategori->name }}</td>
                                <td>
                                    <button wire:click="edit({{ $kategori->id }})" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>   

                                    <button wire:click="deleteConfirmed({{ $kategori->id }})" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger">
                                        <strong>No kategori Found!</strong>
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Kontrol Pagination -->
                <div class="mt-4">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>    
    </div>
</div>