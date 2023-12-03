<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col overflow-auto">
            <h2>Lihat Data Karyawan</h2>
        <form method="pos" action="">
          <div class="mt-3 mb-3 d-flex">
            <input type="text" class="form-control" name="keyword" id="inputSearching" placeholder="Cari Karyawan Disini">
            <button type="submit" class="btn btn-primary ms-3">Cari</button>
          </div>
        </form>
            <?php if(session()->getFlashdata('insert_message')) {?>
              <div class="alert alert-success" role="alert">
                <b><?=   session()->getFlashData('insert_message')  ?></b>
              </div>
            <?php } ?>
            <?php if(session()->getFlashdata('delete_message')) { ?>
              <div class="alert alert-success" role="alert">
                <b><?= session()->getFlashData('delete_message') ?></b>
              </div>
            <?php } ?>
            <?php if(session()->getFlashdata('secret')) { ?>
              <div class="alert alert-danger" role="alert">
                <b><?= session()->getFlashData('secret') ?></b>
              </div>
            <?php } ?>
            <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Gaji</th>
      <th scope="col">Umur</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php       
    $i = 1 + (4 * ($page - 1));
    foreach($data_table as $dt) {
    ?>
    <tr>
      <th scope="row"><?= $i++ ?></th>
      <td><?= $dt["employee_name"] ?></td>
      <td>Rp. <?= $dt["employee_salary"] ?></td>
      <td><?= $dt["employee_age"] ?> Tahun</td>
      <td class="d-flex">
      <a class="btn btn-primary m-2" href="<?= base_url('/karyawan/'. $dt["id"]) ?>">Detail</a>
      <form method="post" action="<?= base_url('/delete-karyawan') ?>"><button class="btn btn-danger m-2" type="submit" name="id" value="<?= $dt["id"]; ?>">Delete</button></form>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php
if($pager != false) {
 echo $pager->links('default', 'custom'); 
}
?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>