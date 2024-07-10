<!DOCTYPE html>
<html><head>
    <title></title>
    <style>
    body {
    	width: 90%;
    	margin: auto;
    }

    table {
		border: 1px solid #ddd;
		width: 100%;
		margin-top: 20px;
		margin-bottom: 12px;
		border-collapse: collapse;
		text-align: left;
	}

	td, th {
		border: 1px solid #ddd;
		padding: 6px;
	}

	table th {
		font-weight: bold;
		text-align: left;
	}

	span {
		margin-left: 20px;
	}

	.center {
		text-align: center;
	}

	#no {
		width: 30px;
	}

	</style>
</head><body>
	<h5>LAUNDRY</h5>
	<h1>Transaction Data Report</h1>
	<?php 
		echo '<p>The transaction is completed in the time range</p>';
		echo '<p>From: '.$dari.'<span>To: '.$sampai.'</span></p>';
	?>
    <table>
	<tr class="">
                                            <th>#</th>
                                            <th>Transc. ID</th>
                                            <th>Nama</th>
                                            <th>Total Pesanan</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Pay Status</th>
                                        </tr>
										<?php
                                            $no = 1;
                                            foreach ($data_transaksi->result_array() as $transaksi) {
                                        ?>
                                        <tr>
                                            <th><?php echo $no++ ?></th>
                                            <td><?= $transaksi['id']; ?></td>
                                            <td><?= $transaksi['uName']; ?></td>
                                            <td>Rp <?= number_format($transaksi['total']+$transaksi['ongkir'],0,",","."); ?></td>
                                            <td><?= $transaksi['date']; ?></td>
                                            <?php if($transaksi['pay_status'] == 'pending'){ ?>
                                                <td>Belum dibayar</td>
                                            <?php }else if($transaksi['pay_status'] == 'settlement'){ ?>
                                                <td>Lunas</td>
                                            <?php }else if($transaksi['pay_status'] == 'cancel'){ ?>
                                                <td>Dibatalkan</td>
                                            <?php }else if($transaksi['pay_status'] == 'failure'){ ?>
                                                <td>Gagal</td>
                                            <?php }else{ ?>
                                                <td>Belum dibayar</td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
		<tr>
			<td colspan="7"><b>Total Income</b></td>
			<td colspan="3"><b>$ <?php echo $total_pendapatan ?></b></td>
		</tr>
	</table>
	<p>Note: Year-month-day time format (yyyy-mm-dd)</p>
	<script type="text/javascript">
		window.print();
	</script>
</body></html>