<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>
<div class="content">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h1>Tambah Peminjaman Buku</h1>
                </div>
                <div class="card-body">
                    <form action="/pinjamkembali/peminjaman" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label for="isbn">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="judul">Judul</label>
                            <select class="form-control" id="judul" name="judul" required>
                                <?php foreach ($buku as $b) : ?>
                                    <option value="<?= $b['judul'] ?>"><?= $b['judul'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jumlah">Jumlah Buku yang Tersedia</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nomor">Nomor ID</label>
                            <input type="text" class="form-control" id="nomor" name="nomor" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama Anggota</label>
                            <select class="form-control" id="nama" name="nama" required="">
                                <?php foreach ($anggota as $a) : ?>
                                    <option value="<?= $a['nama'] ?>"><?= $a['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" readonly>
                        </div>



                        <div class="form-group mb-3">
                            <label for="tgl_pinjam">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="tgl_kembali">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" required="">
                        </div>

                        <td><a href="/pinjamkembali/" class="btn btn-danger">Kembali</a></td>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>