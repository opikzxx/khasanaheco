<body id="page-top" class="bg-light">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- 404 Error Text -->
          <div class="text-center mt-5">
            <div class="error mx-auto" >Lakukan Pembayaran</div>
            
            
            <p class="text-gray-500 mb-1  mt-5">Nomor Transaksi</p>
            <p class="text-gray-500 mb-2"><b><?= $checkout['id']; ?></b></p>
            <p class="text-gray-500 mb-2">Batas Akhir Pembayaran</p>
            <p class="text-gray-500 mb-8"><b><?= $checkout['date']; ?></b></p>
            <p class="text-gray-500 mb-1 mt-8">Jumlah Pembayaran</p>
            <p class="lead text-gray-800 mb-1"><b>-0-</b></p>
            <p class="lead text-gray-500 mb-1 mt-5"><div class="alert alert-info">Kamu belum memilih metode pembayaran. Silakan klik tombol dibawah untuk memilih metode pembayaran yang diinginkan.</div>
            <button id="pay-button" class="btn btn-sm btn-secondary">Pilih Metode Pembayaran</button></P>
            <p class="text-gray-500 mb-1"><a class="btn btn-secondary" href="<?= base_url(); ?>"> Download Invoice</a></p>
            <p class="text-gray-500 mb-5"><a class="btn btn-primary" href="<?= base_url(); ?>"> Cek Status Order</a></p>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

</body>