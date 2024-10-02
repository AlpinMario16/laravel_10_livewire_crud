<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark p-3  d-lg-block" id="sidebar">
        <h4 class="text-white">Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('products') }}" class="nav-link text-white">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('kategoris') }}" class="nav-link text-white">
                    <i class="fas fa-list"></i> Kategori
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('transaksi-form') }}" class="nav-link text-white">
                    <i class="fas fa-dollar-sign"></i> Transaksi
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laporan.transaksi') }}" class="nav-link text-white">
                    <i class="fas fa-file-alt"></i> Laporan Transaksi
                </a>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="flex-grow-1 p-3">
        <button class="btn btn-primary mb-3 d-lg-none" wire:click="toggleSidebar">
            <i class="fas fa-bars"></i> Toggle Sidebar
        </button>
    </div>
</div>
