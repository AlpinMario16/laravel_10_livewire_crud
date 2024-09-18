<div class="container mt-4">
    <h3>Laporan Transaksi</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Laporan Transaksi -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Customer</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->tanggal->format('d-m-Y H:i') }}</td>
                    <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <button class="btn btn-info" wire:click="printTransaction({{ $transaction->id }})">Cetak</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $transactions->links() }}
</div>

<script>
    // Event listener untuk mencetak transaksi
    window.addEventListener('printTransaction', event => {
        const newWindow = window.open(event.detail.url, '_blank');
        newWindow.print();
    });
</script>
