<?= $this->extend('layout/template'); ?>
<?php 
$error_message = session()->getFlashdata('error_message');
$error_upload = session()->getFlashdata('error_upload');
$update_message = session()->getFlashdata('update_message');
?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row mt-5">
        <div class="col d-flex flex-column justify-content-center align-items-center">
        <?php if($update_message) {?>
          <div class="alert alert-success" role="alert">
            <b><?= $update_message ?></b>
          </div>
        <?php } ?>
        <?php if($error_upload) { ?>
          <div class="alert alert-danger" role="alert">
              <b><?= $error_upload ?><br/></b>
          </div>
        <?php } ?>  
        <?php if($error_message) { ?>
          <?php foreach($error_message as $error) { ?>
          <div class="alert alert-danger" role="alert">
              <b><?= $error ?><br/></b>
          </div>
          <?php } ?>
        <?php } ?>  
            <img class="rounded-pill" src="<?= base_url('/src/img/' . $data_table["picture"])?>" align="center" alt="Foto Profil">
            <div class="mt-3">
                <h3>Nama : <?= $data_table["employee_name"]; ?></h3>
                <h3>Gaji : Rp. <?= $data_table["employee_salary"]; ?></h3>
                <h3>Umur : <?= $data_table["employee_age"]; ?> Tahun</h3>
                <h3>Jabatan : <?= $data_table["nama_jabatan"]; ?></h3>
            </div>
            <div class="d-flex">
                <a class="btn btn-secondary m-2" href="<?= base_url('/karyawan')?>">Kembali</a>
                <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                <form method="post" action="<?= base_url('/delete-karyawan') ?>"><button class="btn btn-danger m-2" type="submit" name="id" value="<?= $data_table["id"]; ?>">Delete</button></form>
            </div>

            <form method="post" action="<?= base_url('/edit-karyawan') ?>" enctype="multipart/form-data">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?= $data_table["employee_name"]; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
              <?= csrf_field(); ?>
              <input type="hidden" name="id" value="<?= $data_table["id"]; ?>" />
              <input type="hidden" name="foto-lama" value="<?= $data_table["picture"]; ?>" />
        <div class="mt-3 mb-3">
          <label for="inputNama" class="form-label">Nama Karyawan</label>
          <input type="text" class="form-control is_invalid" name="nama" id="inputNama" placeholder="Masukkan Nama" value="<?= $data_table["employee_name"]; ?>" required>
        </div>
        <div class="mb-3">
          <label for="input Gaji" class="form-label">Gaji Karyawan</label>
          <input type="number" class="form-control" name="gaji" id="input Gaji" placeholder="Masukkan Gaji" value="<?= $data_table["employee_salary"]; ?>" required>
        </div>
        <div class="mb-3">
          <label for="inputUmur" class="form-label">Umur Karyawan</label>
          <input type="number" class="form-control" name="umur" id="inputUmur" placeholder="Masukkan Umur" value="<?= $data_table["employee_age"]; ?>" required>
        </div>
        <div class="mb-3">
          <label class="mb-2">Jabatan Karyawan</label>
          <select class="form-select" name="id_jabatan" aria-label="Default select example">
            <option selected value="<?= $data_table["id_jabatan"] ?>"><?= $data_table["nama_jabatan"] ?></option>
            <?php foreach ($data_jabatan as $data) { ?>
            <option value="<?= $data["id_jabatan"] ?>"><?= $data["nama_jabatan"] ?></option>
            <?php } ?>
        </select>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Pilih foto profil</label>
            <input class="form-control" name="foto" type="file" id="formFile"  accept="image/*" >
          </div>
    </div>
    <div class="modal-footer">    
        <div class="mb-3">
            <input type="submit" name="insert" class="btn btn-primary" value="Simpan" >
        </div>
    </form> 
  </div>
</div>
</div>
</div>
    </div>
</div>
<?= $this->endSection(); ?>