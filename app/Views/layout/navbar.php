<?php 
$uri = current_url(true);
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url(); ?>">Kuro Employee</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= $uri->getSegment(1) == '' ? 'active' : '' ;?>" aria-current="page" href="<?= base_url(); ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $uri->getSegment(1) == 'about' ? 'active' : '' ;?>" href="<?= base_url('/about') ?>">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $uri->getSegment(1) == 'karyawan' ? 'active' : '' ;?>" href="<?= base_url('/karyawan') ?>">Employee</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $uri->getSegment(1) == 'insert-karyawan' ? 'active' : '' ;?>" href="<?= base_url('/insert-karyawan') ?>">Insert Employee</a>
        </li>
      </ul>
    </div>
  </div>
</nav>