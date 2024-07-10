                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h4 class="my-auto font-weight-bold mb-0 ">Transaction Data Report</h4>
                        </div>
                        <div class="card-body">
                            <form name="form_filter_transaksi" action="<?php echo base_url().'administrator/laporan_filter_order' ?>" method="post" class="w-100 user needs-validation" novalidate>
                                <h5>Transactions are completed within the timeframe</h5>
                                <div class="row align-items-end">
                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label ">From</label>
                                            <input type="date"  class="form-control" name="dari" value="<?php echo set_value('dari')?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label ">To</label>
                                            <input type="date"  class="form-control" name="sampai" value="<?php echo set_value('sampai')?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button type="submit" class="flex-fill btn btn-primary rounded-0 btn-block px-4"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                        <a target="blank" href="<?php echo base_url().'transaksi/print/'.set_value('dari').'/'.set_value('sampai') ?>" class="btn btn-success btn-block rounded-0 shadow-sm"><i class="fas fa-print fa-sm text-white-500"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="">
                                            <th>#</th>
                                            <th>Transc. ID</th>
                                            <th>Nama</th>
                                            <th>Total Pesanan</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Pay Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            

            