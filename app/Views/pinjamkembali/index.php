<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3>Kelola Peminjaman Buku</h3>
                            <form action="" method="post" style="margin-bottom: 20px;">
                                <input type="text" class="form-control" placeholder="Masukkan Keywork Pencarian Transaksi Buku" name="keywork">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <a href="/pinjamkembali/create" class="btn btn-info mb-3"><i class="tim-icons icon-simple-add"></i></a>
                    <a href="/pinjamkembali/cetak-laporan" class="btn btn-primary mb-3"><i class="tim-icons icon-printer"></i> Cetak Laporan</a>
                </div>
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
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
                                    <th scope="col">Denda <i class="tim-icons icon-alert-circle-exc" style="cursor: pointer;" data-toggle="modal" data-target="#infoDendaModal"></i></th>
                                    <th scope="col">Akumulasi Denda</th>
                                    <th scope="col">Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($pinjamkembali as $p) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $p['isbn'] ?></td>
                                        <td><?= $p['judul'] ?></td>
                                        <td><?= $p['nomor'] ?></td>
                                        <td><?= $p['nama'] ?></td>
                                        <td><?= $p['kelas'] ?></td>
                                        <td><?= $p['tgl_pinjam'] ?></td>
                                        <td><?= $p['tgl_kembali'] ?></td>
                                        <td><?= \App\Controllers\Pinjamkembali::calculateDenda($p['tgl_kembali']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm info-button" data-toggle="modal" data-target="#infoModal" data-transaksi='<?= json_encode($p); ?>'>Info</button>
                                        </td>
                                        <td><a href="/pinjamkembali/pengembalian/<?= $p['id']; ?>" class="btn btn-danger" onclick="return confirm('Apa anda ingin mengembalikan transaksi buku?');"><i class="tim-icons icon-upload"></i></a>
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