<?= $this->extend('template/indexhome'); ?>
<?= $this->section('page-content'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3>Daftar Peminjaman Buku</h3>
                            <form action="" method="post" style="margin-bottom: 20px;">
                                <input type="text" class="form-control" placeholder="Masukkan Keywork Pencarian Transaksi Buku" name="keywork">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-custom">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">ID Anggota</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($datasimpanpinjam as $ds) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $ds['isbn'] ?></td>
                                        <td><?= $ds['judul'] ?></td>
                                        <td><?= $ds['nomor'] ?></td>
                                        <td><?= $ds['nama'] ?></td>
                                        <td><?= $ds['kelas'] ?></td>
                                        <td><?= $ds['tgl_pinjam'] ?></td>
                                        <td><?= $ds['tgl_kembali'] ?></td>
                                        <td><?= \App\Controllers\Datasimpanpinjam::calculateDenda($ds['tgl_kembali']); ?></td>
                                        </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>