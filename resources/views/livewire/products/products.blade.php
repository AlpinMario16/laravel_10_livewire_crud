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

       

        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">
                
                <!-- Baris untuk Cari Produk dan Tambah Produk -->
                <div class="d-flex justify-content-between mb-3">
                    <!-- Search Bar -->
                    <input type="text" wire:model.live="searchTerm" placeholder="Cari Produk..." class="form-control form-control-sm" aria-label="Search" style="width: 70%;">
                    
                    <!-- Tombol Tambah Produk -->
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
    <i class="bi bi-plus-circle"></i> Tambah Produk
</button>

<!-- Include Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdukModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('tambah-produk')
            </div>
        </div>
    </div>
</div>
                </div>

                <!-- Tabel Produk -->
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Description</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr wire:key="{{ $product->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->kategori_id->name ?? 'No Kategori' }}</td> <!-- Menampilkan nama kategori -->
                                <td>{{ $product->description ?? 'Tidak ada deskripsi' }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100">
                                    @else
                                        Gambar tidak tersedia.
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>   
                                    <button @click="deleteConfirmed({{ $product->id }})" wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm">
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
