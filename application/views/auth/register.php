<div class="wrapper">
    <a href="<?= base_url(); ?>"><h2 class="brand-name">Khasanah Eco</h2></a>
    <p class="subtitle">Daftar akun baru sekarang</p>
    <?php echo $this->session->flashdata('failed'); ?>
    <form action="<?= base_url(); ?>register" method="post">
        <div class="form-group">
            <input type="text" placeholder="Nama Lengkap"  name="name" class="form-control"  autocomplete="off" value="<?php echo set_value('name'); ?>">
            <small class="form-text text-danger pl-1"><?php echo form_error('name'); ?></small>
        </div>
        <div class="form-group">
            <input type="email" placeholder="Alamat Email"  name="email" class="form-control"  autocomplete="off" value="<?php echo set_value('email'); ?>">
            <small class="form-text text-danger pl-1"><?php echo form_error('email'); ?></small>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Password"  name="password" class="form-control"  autocomplete="off">
            <small class="form-text text-danger pl-1"><?php echo form_error('password'); ?></small>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Konfirmasi Password"  name="password1" class="form-control"  autocomplete="off">
            <small class="form-text text-danger pl-1"><?php echo form_error('password1'); ?></small>
        </div>
        <div class="form-group">
            <input type="text" placeholder="No Telfon"  name="telp" class="form-control"  autocomplete="off">
            <small class="form-text text-danger pl-1"><?php echo form_error('telp'); ?></small>
        </div>
        <div class="form-group">
          <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <select name="paymentSelectProvinces" id="paymentSelectProvinces" class="form-control" required>
                            <option></option>
                            <?php foreach($provinces as $p): ?>
                                <option value="<?= $p['province_id']; ?>"><?= $p['province']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <select name="paymentSelectRegencies" id="paymentSelectRegencies" class="form-control" required>
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
          <div class="form-group">
            <input type="text" placeholder="Address"  name="address" class="form-control"  autocomplete="off">
            <small class="form-text text-danger pl-1"><?php echo form_error('address'); ?></small>
        </div>
        </div>
        <small class="text-muted">Saya telah membaca dan menyetujui <a href="<?= base_url(); ?>terms" target="_blank">Syarat dan Ketentuan</a> serta <a href="<?= base_url(); ?>privacy-policy" target="_blank">Kebijakan Privasi</a> Heryuna Store</small>
        <button type="submit" class="btn btn-block btn-dark mt-3">Daftar</button>
        <hr>
        <p class="text-lead">Atau sudah punya akun? <a href="<?= base_url(); ?>login">Login</a> sekarang</p>
    </form>
</div>

<?php if($this->session->flashdata('success')){ ?>
<div class="modal fade" id="modalRegisterSuccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="checked" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Registrasi Berhasil</h5>
      </div>
      <div class="modal-body">
        <p class="text-center h1"><i class="fa text-dark fa-check-circle"></i></p>
        <p class="text-muted">Selamat Registrasi Akun Anda Berhasil</p>
        <a href="<?= base_url(); ?>login" class="btn btn-block btn-dark">Ke halaman login</a>
      </div>
    </div>
  </div>
</div>
<?php } ?>