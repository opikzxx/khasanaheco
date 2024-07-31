<head>
<script type="text/javascript"
    <?php if($this->config->item('midtrans_production')){ ?>
      src="https://app.midtrans.com/snap/snap.js"
    <?php }else{ ?>
      src="https://app.sandbox.midtrans.com/snap/snap.js"
    <?php } ?>
            data-client-key="SB-Mid-client-QlWFQcArLpAeoSIB"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<?php echo $this->session->flashdata('success'); ?>
<form id="payment-form" method="post" action="<?=base_url()?>snap/finish?invoice=<?= $ord['id']; ?>">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>
<div class="wrapper">
<?php include 'menu.php'; ?>
    <div class="core">
        <?php if($ord['pay_status'] == ""){ ?>
            <div class="alert alert-info">Kamu belum memilih metode pembayaran. Silakan klik tombol dibawah untuk memilih metode pembayaran yang diinginkan.</div>
            <button id="pay-button" class="btn btn-sm btn-secondary">Pilih Metode Pembayaran</button>
            <hr>
        <?php }else if($ord['pay_status'] == "pending"){ ?>
            <div class="alert alert-info">Kamu belum melakukan pembayaran. Klik tombol dibawah untuk melihat panduan pembayaran. (batas maksimal pembayaran 1x24jam)</div>
            <a href="<?= $ord['link_pay']; ?>" target="_blank" class="btn btn-sm btn-secondary">Panduan Pembayaran</a>
            <hr>
        <?php } ?>
        <h2 class="title">Detail Pesanan</h2>
        <hr>
        <table class="table table-sm table-borderless">
            <tr>
                <td>Order ID</td>
                <td><?= $ord['id']; ?></td>
            </tr>
            <tr>
                <td>Tanggal Pesan</td>
                <td><?= $ord['date']; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <?php if($ord['pay_status'] == 'pending' || $ord['pay_status'] == ''){ ?>
                    <td>Belum dibayar</td>
                <?php }else if($ord['pay_status'] == 'settlement' && $ord['status'] == 0){ ?>
                    <td>Menunggu konfirmasi</td>
                <?php }else if($ord['status'] == 2){ ?>
                    <td>Sedang diproses</td>
                <?php }else if($ord['status'] == 3){ ?>
                    <td>Selesai</td>
                <?php }else{ ?>
                    <td>Selesai</td>
                <?php } ?>
            </tr>
            <tr>
                <td>Total Pembayaran</td>
                <th class="text-primary">Rp<?= number_format($ord['total']+$ord['ongkir'],0,",","."); ?></th>
            </tr>
        </table>
        <hr>
        <h2 class="title">Metode: <b class="text-primary">Ambil Di Tempat</b></h2>
        <hr>

        <div class="row">
            <div class="col-md-7">
                <h2 class="title mb-3">Produk Pesanan</h2>
                <?php foreach($product_order->result_array() as $p): ?>
                    <div class="item-product">
                        <img src="<?= base_url(); ?>assets/images/product/<?= $p['pImg']; ?>" alt="produk <?= $p['title']; ?>" >
                        <a href="<?= base_url(); ?>products/detail_product_custom/<?= $p['pId']; ?>"><h3 class="product_name mb-0"><?= $p['title']; ?></h3></a>
                        <p class="mb-0">Jumlah: <?= $p['qty']; ?></p>
                        <p class="mb-0 price">Rp<?= number_format($p['total'],0,",","."); ?></p>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-5">
                <h2 class="title">Ringkasan Pembayaran</h2>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Jumlah Produk</td>
                        <td>: <?= $product_order->num_rows(); ?></td>
                    </tr>
                    <tr>
                        <td>Harga Produk</td>
                        <td>: Rp<?= number_format($ord['total'],0,",","."); ?></td>
                    </tr>
                    <tr>
                        <td>Total Belanja</td>
                        <td>: Rp<?= number_format($ord['total']+$ord['ongkir'],0,",","."); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
    </div>
</div>
<script type="text/javascript">

    const type_order = "<?= $ord['pay_status'] ?>";
    if(type_order == ""){

  modalMidtrans();
  $("#pay-button").click(function(){
      modalMidtrans();
    })
    }

    function modalMidtrans(){
      $.ajax({
        url: '<?=base_url()?>snap/token?invoice=<?= $ord['id']; ?>',
        cache: false,

        success: function(data) {
          //location = data;

          console.log('token = '+data);
          
          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');

          function changeResult(type,data){
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            //resultType.innerHTML = type;
            //resultData.innerHTML = JSON.stringify(data);
          }

          snap.pay(data, {
            
            onSuccess: function(result){
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result){
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result){
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        }
      });
    }

  </script>