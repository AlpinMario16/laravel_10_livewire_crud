<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Transaksi</h2>
        <p>ID Transaksi : {{ $transaction->id }}</p>
        <p>Nama Customer : {{ $transaction->customer_name }}</p>
        <p>Tanggal : @if($transaction->tanggal)
                            {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
        </p>

        <!-- Detail Produk -->
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th> <!-- Tambahkan kolom harga -->
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
    @foreach($transaction->detailTransaksi as $item)
        <tr>
            <td>
                @if($item->product)
                    {{ $item->product->name }} <!-- Nama produk -->
                @else
                    Produk tidak ditemukan
                @endif
            </td>
            <td>{{ $item->jumlah }}</td>
            <td>
                @if($item->product)
                    Rp {{ number_format($item->product->price, 0, ',', '.') }} <!-- Harga produk -->
                @else
                    -
                @endif
            </td>
            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</tbody>

        </table>

        <h3>Total Harga: Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</h3>
    </div>
</body>
</html>
