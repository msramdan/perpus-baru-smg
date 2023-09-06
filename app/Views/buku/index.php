<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-6">
              <h3>Kelola Data Buku</h3>
              <form action="" method="post" style="margin-bottom: 20px;">
                <input type="text" class="form-control" placeholder="Masukkan Keywork Pencarian Buku" name="keywork">
              </form>
            </div>
          </div>
        </div>
        <div class="btn-container">
          <a href="/buku/create" class="btn btn-info"><i class="tim-icons icon-simple-add"></i></a>
          <form method="post" action="/buku/import" enctype="multipart/form-data" id="import-form">
            <label for="import_file" class="btn btn-primary">
              Import Buku
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
                  <th scope="col">Gambar</th>
                  <th scope="col">ISBN</th>
                  <th scope="col">Judul Buku</th>
                  <th scope="col">Jenis Buku</th>
                  <th scope="col">Jumlah Buku</th>
                  <th scope="col">Lokasi Buku</th>
                  <th scope="col">Kelola</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($buku as $b) : ?>
                  <tr>
                    <td><img src="/img/<?= $b['gambar']; ?>" alt="" class="gambar"></td>
                    <td><?= $b['isbn']; ?></td>
                    <td><?= $b['judul']; ?></td>
                    <td><?= $b['jenis']; ?></td>
                    <td><?= $b['jumlah']; ?></td>
                    <td><?= $b['lokasi']; ?></td>
                    <div class="btn-container">
                      <td>
                        <a href="/buku/<?= $b['slug']; ?>" class="btn btn-info"><i class="tim-icons icon-notes"></i></a>
                        <a href="/buku/edit/<?= $b['slug']; ?>" class="btn btn-success"><i class="tim-icons icon-pencil"></i></a>
                        <a href="/buku/delete/<?= $b['id']; ?>" class="btn btn-danger" onclick="return confirm('Apa anda ingin menghapus buku?');"><i class="tim-icons icon-trash-simple"></i></a>
                      </td>
                    </div>
                  </tr>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div> <!-- Div dari table responsive-->
        </div> <!-- Div dari card body-->
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>