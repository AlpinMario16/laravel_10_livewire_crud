<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Detail Transaksi -->
    <div class="container-fluid">
    <div class="row">
    <!-- <div class="col-lg-6"> -->
        <div class="card card-outline card-warning p-3">
            <h4>Detail Transaksi</h4>
            <form>
            <div class="form-group">
                <label for="customerName">Nama Customer</label>
                <input type="text" id="customerName" wire:model="customerName" class="form-control" placeholder="Masukkan Nama Customer">
            </div>

                <div class="form-group mb-3">
                    <label for="invoiceNumber">No. Invoice</label>
                    <input type="text" class="form-control" id="invoiceNumber" value="{{ $invoice }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="transactionDate">Tanggal Transaksi</label>
                    <input type="date" class="form-control" id="transactionDate" wire:model="tanggal">
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- </div> -->


<!-- Daftar Produk -->
     <div class="container-fluid mt-4">
    <div class="row">
    <!-- <div class="col-lg-6"> -->
        <div class="card card-outline card-warning p-3">
        <h4>Pilih Produk</h4>
        <div class="form-group">
            <select class="form-control" wire:model="selectedProduct" wire:change="addToCart($event.target.value)">
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
</div>
     <!-- </div> -->

     <div class="container-fluid mt-4">
    <div class="row">
    <!-- <div class="col-lg-6"> -->
        <div class="card card-outline card-warning p-3">
            <h4>Keranjang</h4>
            @if(count($cart) > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td>
                    <!-- Tombol delete -->
                    <button class="btn btn-danger">Hapus</button>
                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>

                <div class="form-group mb-3">
                <label for="jml_bayar">Jumlah Bayar</label>
                <input type="number" class="form-control" id="jml_bayar" wire:model="jml_bayar" placeholder="Masukkan jumlah bayar">
            </div>

            <div class="form-group mb-3">
                <label for="kembalian">Kembalian</label>
                <input type="text" class="form-control" id="kembalian" value="Rp {{ number_format($kembalian, 0, ',', '.') }}" disabled>
            </div>

                <button class="btn btn-success" wire:click="processTransaction">Proses Transaksi</button>
            @else
                <p>Keranjang kosong.</p>
            @endif
        </div>
    </div>
</div>
     <!-- </div> -->

<script>
    // SweetAlert untuk transaksi sukses
    window.addEventListener('transactionSuccess', event => {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Transaksi berhasil!',
            showConfirmButton: false,
            timer: 1500
        });
    });

    // Konfirmasi penghapusan produk dari keranjang
    function deleteConfirmed(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data ini tidak bisa dikembalikan setelah dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, jalankan logika penghapusan item
                Livewire.emit('deleteProductFromCart', id); // Emit event untuk penghapusan item
                Swal.fire({
                    title: "Dihapus!",
                    text: "Produk telah dihapus dari keranjang.",
                    icon: "success"
                });
            }
        });
    }
</script>
