<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Daftar Produk -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h4>Pilih Produk</h4>
            <div class="list-group">
                @foreach($products as $product)
                    <button class="list-group-item list-group-item-action" wire:click="addToCart({{ $product->id }})">
                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Keranjang -->
        <div class="col-md-4">
            <h4>Keranjang</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>

            <button class="btn btn-success" wire:click="processTransaction">Proses Transaksi</button>
        </div>
    </div>
</div>
