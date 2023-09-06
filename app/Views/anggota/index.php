<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3>Kelola Data Anggota</h3>
                            <form action="" method="post" style="margin-bottom: 20px;">
                                <input type="text" class="form-control" placeholder="Masukkan Keywork Pencarian Anggota" name="keywork">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <a href="/anggota/create" class="btn btn-info mb-3"><i class="tim-icons icon-simple-add"></i></a>
                    <form method="post" action="/anggota/import" enctype="multipart/form-data" id="import-form">
                        <label for="import_file" class="btn btn-primary mb-3">
                            Import Anggota
                            <input type="file" class="form-control-file" id="import_file" name="import_file" style="display:none;">
                        </label>
                    </form>
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
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nomor ID</th>
                                    <th scope="col">Nama Anggota</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Nomor HP</th>
                                    <th scope="col">Kelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($anggota as $a) : ?>
                                    <tr>
                                        <td><img src="/img/<?= $a['foto']; ?>" alt="" class="foto"></td>
                                        <td><?= $a['nomor']; ?></td>
                                        <td><?= $a['nama']; ?></td>
                                        <td><?= $a['kelas']; ?></td>
                                        <td><?= $a['alamat']; ?></td>
                                        <td>0<?= $a['nomorhp']; ?></td>
                                        <div class="btn-container">
                                            <td>
                                                <a href="/anggota/edit/<?= $a['slug']; ?>" class="btn btn-success"><i class="tim-icons icon-pencil"></i></a>
                                                <a href="/anggota/delete/<?= $a['id']; ?>" class="btn btn-danger" onclick="return confirm('Apa anda ingn menghapus anggota?');"><i class="tim-icons icon-trash-simple"></i></a>
                                            </td>
                                        </div>
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