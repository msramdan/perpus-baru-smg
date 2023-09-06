<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="javascript:void(0)" class="simple-text logo-normal d-flex align-items-center justify-content-center">
                Aplikasi Perpustakaan
            </a>
            <a href="javascript:void(0)" class="simple-text logo-normal d-flex align-items-center justify-content-center">
                SMP Barunawati
            </a>
        </div>
        <ul class="nav">
            <li class="<?php if (uri_string() == '') echo 'active'; ?>">
                <a href="/home">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'databuku') echo 'active'; ?>">
                <a href="/databuku">
                    <i class="tim-icons icon-book-bookmark"></i>
                    <p>Daftar Buku</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'dataanggota') echo 'active'; ?>">
                <a href="/dataanggota">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Daftar Anggota</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'datapinjamkembali') echo 'active'; ?>">
                <a href="/datapinjamkembali">
                    <i class="tim-icons icon-refresh-02"></i>
                    <p>Daftar Transaksi</p>
                </a>
            </li>
        </ul>
    </div>
</div>