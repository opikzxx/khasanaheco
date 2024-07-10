
<?php if($this->session->userdata('login')){ ?>
  <?php
  $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
  $order = $this->db->get_where('transaction', ['idUser' => $this->session->userdata('id'), 'status !=' => 4]);
  ?>
<?php } ?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" style="background-color: #d3441c !important">
  <div class="container">
  <a class="navbar-brand mr-5" href="<?= base_url(); ?>">
  <!-- <img src="<?= base_url(); ?>assets/images/logo/hryn.png" width="50"> -->
  <b>KHASANAH ECO</b></a>

    <div class="collapse navbar-collapse ml-3" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
        </li>
      </ul>
      <br>
      <div>
      </div>
        <a href="<?= base_url(); ?>cart" class="text-light navbar-cart-inform">
          <i class="fa fa-shopping-cart"></i>
            Cart
        </a>
        <br>
        <br>
        <br>
    </div>

    <?php if(!$this->session->userdata('login')){ ?>
      <div class="for-hidden">
      <i class="fa search-icon-desktop text-light ml-3 icon-search-navbar fa-search"></i>
        <a href="<?= base_url(); ?>login" class="btn btn-sm btn-outline-light ml-2"><i class="fa fa-sign-in-alt"></i> Masuk</a>
        <a href="<?= base_url(); ?>register" class="btn btn-sm btn-outline-light ml-2"><i class="fa fa-user"></i> Daftar</a>
      </div>
    <?php }else{ ?>
      <div>
      <i class="fa search-icon-desktop text-light ml-3 icon-search-navbar fa-search"></i>
      <img src="<?= base_url(); ?>assets/images/profile/default.png" class="photo-profile-mobile" alt="Photo Profile <?= $user['name']; ?>" class="photo" data-toggle="dropdown" id="dropdownPhotoProfileNavbarMobile" aria-haspopup="true" aria-expanded="false">
      <div class="dropdown-menu dropdownPhotoProfileNavbarMobile" aria-labelledby="dropdownPhotoProfileNavbarMobile">
        <a class="dropdown-item" href="<?= base_url(); ?>cart">
            Keranjang
        </a>
        <?php if($order->num_rows() > 0){ ?>
          <a class="dropdown-item" href="<?= base_url(); ?>profile/transaction">Transaksi <small class="badge badge-sm badge-info"><?= $order->num_rows(); ?></small></a>
        <?php }else{ ?>
          <a class="dropdown-item" href="<?= base_url(); ?>profile/transaction">Transaksi</a>
        <?php } ?>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= base_url(); ?>profile/edit-profile">Edit Profil</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= base_url(); ?>logout">Keluar</a>
      </div>
    </div>
    <?php } ?>

    <div>
      <i class="fa search-mobile text-light mr-3 icon-search-navbar fa-search"></i>
      <i class="fa fa-bars btn-for-dropdown"></i>
    </div>

  </div>
</nav>
<div class="dropdown-mobile-menu" style="background-color: RED !important">
  <div class="mt-3"></div>
  <?php if($this->session->userdata('login')){ ?>
    <a href="<?= base_url(); ?>profile" class="text-light"><i class="fa fa-user"></i> <?= $user['name']; ?></a>
    <a href="" class="text-light">
      <i class="fa fa-shopping-cart"></i>
      Keranjang
    </a>
    <?php if($order->num_rows() > 0){ ?>
          <a class="text-light" href="<?= base_url(); ?>profile/transaction">Transaksi <small class="badge badge-sm badge-info"><?= $order->num_rows(); ?></small></a>
        <?php }else{ ?>
          <a class="text-light" href="<?= base_url(); ?>profile/transaction">Transaksi</a>
        <?php } ?>
        <a class="text-light" href="<?= base_url(); ?>logout">Keluar</a>
  <?php }else{ ?>
    <a href="<?= base_url(); ?>login" class="text-light"><i class="fa fa-sign-in-alt"></i> Masuk</a>
    <a href="<?= base_url(); ?>register" class="text-light"><i class="fa fa-user"></i> Daftar</a>
  <?php } ?>
</div>

<div class="top-nav"></div>
