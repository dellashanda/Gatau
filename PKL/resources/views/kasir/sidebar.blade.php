<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="/dashboard">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/kasir/barang">
        <i class="icon-layout menu-icon"></i>
        <span class="menu-title">Barang</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/kasir/pembelian">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Pembelian</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/kasir/anggota">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Anggota</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/kasir/transaksi">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Transaksi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/kasir/pengajuan_kredit">
        <i class="icon-contract menu-icon"></i>
        <span class="menu-title">Pengajuan Kredit</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
        <i class="icon-layout menu-icon"></i>
        <span class="menu-title">Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="laporan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="/kasir/laporan">Penjualan</a></li>
          <li class="nav-item"> <a class="nav-link" href="/kasir/detail_transaksi">Detail Transaksi</a></li>
        </ul>
      </div>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="pages/documentation/documentation.html">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li> -->
  </ul>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const kasirLink = document.querySelector('.nav-link.kasir'); // Tambahkan kelas 'kasir' pada link Kasir
    const laporanLink = document.querySelector('.nav-link.laporan'); // Tambahkan kelas 'laporan' pada link Laporan

    // Fungsi untuk menonaktifkan kelas 'active'
    function deactivateLink(link) {
        if (link) {
            link.classList.remove('active');
            const parent = link.closest('.collapse');
            if (parent) {
                parent.classList.remove('show');
            }
        }
    }

    // Nonaktifkan kelas 'active' pada Laporan ketika Kasir diaktifkan
    if (kasirLink && kasirLink.classList.contains('active')) {
        deactivateLink(laporanLink);
    }
});
</script>



