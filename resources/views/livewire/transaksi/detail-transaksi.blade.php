
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h3>Detail Transaksi</h3>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</h4>
        </div>
<!-- 
        <div class="col-md-4">
            <h4>Detail Pembeli</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Nama:</strong> {{ $transaction->buyer_name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $transaction->buyer_email }}</li>
                <li class="list-group-item"><strong>Alamat:</strong> {{ $transaction->buyer_address }}</li>
            </ul> -->

            <h4>Status Transaksi</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Status:</strong> {{ $transaction->status == 1 ? 'Sukses' : 'Pending' }}
                </li>
                <li class="list-group-item">
                    <strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d M Y H:i') }}
                </li>
            </ul>

            <button class="btn btn-primary mt-3" wire:click="printTransaction">Cetak Struk</button>
        </div>
    </div>
</div>
