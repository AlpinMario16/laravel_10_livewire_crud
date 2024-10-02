<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <!-- <img src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow" width="30" height="30"> -->
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" href="{{ route('products') }}">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('kategoris') }}">Kategori</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('transaksi-form') }}">Transaksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('laporan.transaksi') }}">Laporan Transaksi</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
