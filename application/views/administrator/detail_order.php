<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-0 text-gray-800">Order ID = <?= $orders['id']; ?></h1>
    <?php if($orders['status'] == 4){ ?>
        <h3 class="text-success">Transaksi Selesai</h3>
    <?php }else if($orders['status'] == 0){ ?>
    <?php if($orders['pay_status'] == 'pending'){ ?>
        <p class="lead">Belum dibayar</p>
    <?php }else if($orders['pay_status'] == 'settlement'){ ?>
        <p class="lead text-success">Sudah dibayar</p>
    <?php }else if($orders['pay_status'] == 'cancel'){ ?>
        <p class="lead text-danger">Dibatalkan</p>
    <?php }else if($orders['pay_status'] == 'failure'){ ?>
        <p class="lead text-danger">Gagal</p>
    <?php }else{ ?>
        <p class="lead">Belum dibayar</p>
    <?php } ?>
    <?php } ?>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <a href="<?= base_url(); ?>administrator/orders" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Kembali</a>
		</div>
		<div class="card-body">
            <h3 class="lead">Data Pembeli</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Nama Penerima</td>
                            <td><?= $orders['uName']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= $orders['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td><?= $orders['telp']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
		</div>
	</div>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                <?php $no=1; foreach($order->result_array() as $data): ?>
                </tr>
                    <td><?= $no; ?></td>
                    <td><?= $data['title']; ?></td>
                    
                    <td class="text-center"><?= $data['qty']; ?></td>
                    <td>Rp <?= number_format($data['price'],0,",","."); ?></td>
                    <td>Rp <?= number_format($data['total'],0,",","."); ?></td>
                    
                <tr>
                <?php $no++; endforeach; ?>
                </tr>
            </table>
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>Total Harga</th>
                        <th>Rp <?= number_format($data['total'],0,",","."); ?></th>
                    </tr>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th>Rp <?= number_format($data['total']+$data['ongkir'],0,",","."); ?></th>
                    </tr>
                </table>
            </div>
            <hr>
            <?php if($data['pay_status'] == 'settlement' && $data['status'] == 0){ ?>
                <a href="<?= base_url(); ?>administrator/process_order/<?= $data['id']; ?>" onclick="return confirm('Yakin ingin mengubah status pesanan menjadi sedang di proses?');" class="btn btn-info btn-sm">Proses Pesanan</a>
            <?php }else if($data['status'] == 2){ ?>
                <a href="<?= base_url(); ?>administrator/send_order/<?= $data['id']; ?>" class="btn btn-info btn-sm">Kirim Pesanan</a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

