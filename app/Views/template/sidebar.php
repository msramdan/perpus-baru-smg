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
                <a href="/Library">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'buku') echo 'active'; ?>">
                <a href="/buku">
                    <i class="tim-icons icon-components"></i>
                    <p>Kelola Buku</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'anggota') echo 'active'; ?>">
                <a href="/anggota">
                    <i class="tim-icons icon-badge"></i>
                    <p>Kelola Anggota</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'pinjamkembali') echo 'active'; ?>">
                <a href="/pinjamkembali">
                    <i class="tim-icons icon-refresh-02"></i>
                    <p>Transaksi Buku</p>
                </a>
            </li>
            <li class="<?php if (uri_string() == 'logpinjamkembali') echo 'active'; ?>">
                <a href="/logpinjamkembali">
                    <i class="tim-icons icon-notes"></i>
                    <p>Log Transaksi Buku</p>
                </a>
            </li>
        </ul>
    </div>
</div>