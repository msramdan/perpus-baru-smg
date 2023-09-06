<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3>Riwayat Transaksi Buku</h3>
                            <form action="" method="post" style="margin-bottom: 20px;">
                                <input type="text" class="form-control" placeholder="Masukkan Keywork Pencarian Transaksi Buku" name="keywork">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <a href="/logpinjamkembali/cetak-laporan" class="btn btn-primary mb-3"><i class="tim-icons icon-printer"></i> Cetak Laporan</a>
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
                                    <th scope="col">Nomor Anggota</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Denda <i class="tim-icons icon-alert-circle-exc" style="cursor: pointer;" data-toggle="modal" data-target="#infoDendaModal"></i></th>
                                    <!-- <th scope="col">Akumulasi Denda</th> -->
                                    <th scope="col">status</th>
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($logpinjamkembali as $lp) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $lp['isbn'] ?></td>
                                        <td><?= $lp['judul'] ?></td>
                                        <td><?= $lp['nomor'] ?></td>
                                        <td><?= $lp['nama'] ?></td>
                                        <td><?= $lp['kelas'] ?></td>
                                        <td><?= $lp['tgl_pinjam'] ?></td>
                                        <td><?= $lp['tgl_kembali'] ?></td>
                                        <td><?= \App\Controllers\Datapinjamkembali::calculateDenda($lp['tgl_kembali']); ?></td>
                                        <!-- <td>
                                            <?php if ($lp['status'] == 'Pengembalian') : ?>
                                                <button type="button" class="btn btn-info btn-sm info-button" data-toggle="modal" data-target="#infoModal" data-transaksi='<?= json_encode($lp); ?>'>Info</button>
                                            <?php endif; ?>
                                        </td> -->
                                        <td><?= $lp['status'] ?></td>
                                        <td><?= $lp['tgl_dibuat'] ?></td>
                                        </td>
                                        <td><a href="/logpinjamkembali/delete/<?= $lp['id']; ?>" class="btn btn-danger" onclick="return confirm('Apa anda ingin menghapus riwayat transaksi buku?');"><i class="tim-icons icon-trash-simple"></i></a>
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