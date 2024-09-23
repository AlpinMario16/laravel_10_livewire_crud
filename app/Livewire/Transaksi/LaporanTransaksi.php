<?php
namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class LaporanTransaksi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Mengambil data transaksi dengan paginasi
        $transactions = Transaksi::orderBy('tanggal', 'desc')->paginate(10);

        // Menampilkan tampilan laporan transaksi
        return view('livewire.transaksi.laporan-transaksi', [
            'transactions' => $transactions,
        ]);
    }

    public function printTransaction($transactionId)
    {
        // Mengambil data transaksi berdasarkan ID
        $transaction = Transaksi::with('detailTransaksi')->findOrFail($transactionId);
    
        // Membuat file PDF transaksi
        $pdf = PDF::loadView('livewire.transaksi.cetak-transaksi', ['transaction' => $transaction]);
    
        // Menghasilkan file PDF untuk di-download atau ditampilkan
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'transaksi_' . $transactionId . '.pdf');
    }
    
    
}
