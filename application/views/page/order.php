<div class="wrapper">
    <?php include 'menu.php'; ?>
    <div class="core">
        <h2 class="title">Pesanan Anda</h2>
        <hr>
        <?php if($transaction->num_rows() > 0){ ?>
            <table class="table table-bordered">
                <tr>
                    <th>Order ID</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
                <?php foreach($transaction->result_array() as $d): ?>
                    <tr>
                        <td><?= $d['id']; ?></td>
                        <td><?= $d['date']; ?></td>
                        <td>Rp<?= number_format($d['total']+$d['ongkir'],0,",","."); ?></td>
                        <?php if($d['pay_status'] == 'pending' || $d['pay_status'] == ""){ ?>
                            <td>Belum dibayar</td>
                        <?php }else if($d['status'] == 0 && $d['pay_status'] == 'settlement'){ ?>
                            <td>Menunggu konfirmasi</td>
                        <?php }else if($d['status'] == 2){ ?>
                            <td>Sedang diproses</td>
                        <?php }else if($d['status'] == 3){ ?>
                            <td>Selesai</td>
                        <?php } ?>
                        <td><small><a href="<?= base_url(); ?>profile/checkout/<?= $d['id']; ?>" class="text-info">Detail</a></small></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php }else{ ?>
            <div class="alert alert-warning">Tidak ada pesanan. Yuk Belanja.</div>
        <?php } ?>
    </div>
</div>