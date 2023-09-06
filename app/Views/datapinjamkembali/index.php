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
                                    <th scope="col">Denda <i class="tim-icons icon-alert-circle-exc" style="cursor: pointer;" data-toggle="modal" data-target="#infoDendaModal"></i></th>
                                    <th scope="col">Akumulasi Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($datapinjamkembali as $dp) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $dp['isbn'] ?></td>
                                        <td><?= $dp['judul'] ?></td>
                                        <td><?= $dp['nomor'] ?></td>
                                        <td><?= $dp['nama'] ?></td>
                                        <td><?= $dp['kelas'] ?></td>
                                        <td><?= $dp['tgl_pinjam'] ?></td>
                                        <td><?= $dp['tgl_kembali'] ?></td>
                                        <td><?= \App\Controllers\Datapinjamkembali::calculateDenda($dp['tgl_kembali']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm info-button" data-toggle="modal" data-target="#infoModal" data-transaksi='<?= json_encode($dp); ?>'>Info</button>
                                        </td>
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