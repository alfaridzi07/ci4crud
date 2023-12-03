<?= $this->extend('layout/template'); ?>

<?php 
$error_message = session()->getFlashdata('error_message');
$error_value = session()->getFlashdata('error_value'); 
?>

<?= $this->section('content'); ?>
<div class="container">
        <div class="row">
            <div class="col">
            <form method="post" action="<?= base_url('/save-karyawan') ?>" enctype="multipart/form-data">
              <?= csrf_field(); ?>
            <?php if($error_message) { ?>
              <?php foreach($error_message as $error) { ?>
              <div class="alert alert-danger" role="alert">
                  <b><?= $error ?><br/></b>
              </div>
              <?php } ?>
            <?php } ?> 
            <?php if(session()->getFlashData('error_upload')) { ?>
              <div class="alert alert-danger" role="alert">
                <b><?= session()->getFlashData('error_upload') ?></b>
              </div>
            <?php } ?>
        <div class="mt-3 mb-3">
          <label for="inputNama" class="form-label">Nama Karyawan</label>
          <input type="text" class="form-control is_invalid" name="nama" id="inputNama" placeholder="Masukkan Nama" value="<?= $error_value ? $error_value["nama"] : ''; ?>" required>
        </div>
        <div class="mb-3">
          <label for="inputGaji" class="form-label">Gaji Karyawan</label>
          <input type="number" class="form-control" name="gaji" id="inputGaji" placeholder="Masukkan Gaji" value="<?= $error_value ? $error_value["gaji"] : ''; ?>" required>
        </div>
        <div class="mb-3">
          <label for="inputUmur" class="form-label">Umur Karyawan</label>
          <input type="number" class="form-control" name="umur" id="inputUmur" placeholder="Masukkan Umur" value="<?= $error_value ? $error_value["umur"] : ''; ?>" required>
        </div>
        <div class="mb-3">
          <label class="mb-2">Jabatan Karyawan</label>
          <select class="form-select" name="id_jabatan" aria-label="Default select example">
            <option selected value="nothing">Pilih Jabatan</option>
            <?php foreach ($data_jabatan as $data) { ?>
            <option value="<?= $data["id_jabatan"] ?>"><?= $data["nama_jabatan"] ?></option>
            <?php } ?>
        </select>
        </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Pilih foto profil</label>
            <input class="form-control" name="foto" type="file" id="formFile"  accept="image/*">
          </div>
        <div class="mb-3">
          <input type="submit" name="insert" class="btn btn-primary" value="Simpan">
        </div>
            </form>  
            </div>
        </div>
    </div>    
<?= $this->endSection(); ?>