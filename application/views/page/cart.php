<div class="wrapper">
    <div class="navigation">
        <a href="<?= base_url(); ?>">Home</a>
        <i class="fa fa-caret-right"></i>
        <a>Troli</a>
    </div>
    <div class="core mt-4">
        <div class="product">
            <?php foreach ($this->cart->contents() as $item): ?>
            <div class="item">
                <div class="item-main">
                    <img src="<?= base_url(); ?>assets/images/product/<?= $item['imgProduct']; ?>" alt="<?= $item['imgProduct']; ?>">
                    <a href=""><h2 class="title mb-0"><?= $item['name']; ?></h2></a>
                    <small class="text-muted">Jumlah: <?= $item['qty']; ?></small><br>
                    <h3 class="price mt-0 mb-0">Rp <?= number_format($item['price'] * $item['qty'],0,",","."); ?></h3>
                    <div class="clearfix"></div>
                </div>
                <a href="<?= base_url(); ?>cart/hapus_cart/<?= $item['rowid']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini dari troli?')"><i class="fa fa-trash"></i></a>
            </div>
            <hr>
            <?php endforeach; ?>
            <a href="<?= base_url(); ?>cart/delete_cart" onclick="return confirm('Apakah Anda yakin akan mengosongkan Troli?')"><button class="btn btn-outline-dark">Kosongkan Troli</button></a>
            
        </div>
        <?php
        $totalall = 0;
        $totalitem = 0;
        foreach ($this->cart->contents() as $c){
            $totalall += intval($c['price']) * intval($c['qty']);
            $totalitem += intval($c['qty']);
        }
        ?>
        <div class="total shadow">
            <h2 class="title">Ringkasan Belanja</h2>
            <hr>
            <div class="list">
                <p>Total Jumlah Barang</p>
                <p><?= $totalitem; ?></p>
            </div>
            <div class="list">
                <p>Total Harga Barang</p>
                <p>Rp <?= number_format($totalall,0,",","."); ?></p>
            </div>
                <a href="<?= base_url(); ?>payment">
                    <button class="btn btn-dark btn btn-block mt-2">Lanjut ke Pembayaran</button>
                </a>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>

    function showModalAddKet(id){
        $("#bodyModalAddKet").html(`<div class="form-group">
            <textarea name="ket_product" id="ket_product" class="form-control form-control-sm" placeholder="Model, ukuran, warna, dll."></textarea>
            <input type="hidden" id="rowid_pro" value=${id}>
        </div>`);
    }

    function showModalEditKet(id){
        $.ajax({
            url: "<?= base_url(); ?>cart/get_item",
            type: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: function(res){
                $("#bodyModalEditKet").html(`<div class="form-group">
                    <textarea name="ket_product" id="ket_product_edit" class="form-control form-control-sm" placeholder="Model, ukuran, warna, dll.">${res.ket}</textarea>
                    <input type="hidden" id="rowid_pro_edit" value=${id}>
                </div>`);      
            }
        })
    }

    $("#btnSaveKetProduct").on('click', function(){
        const rowid = $("#rowid_pro").val();
        const ket = $("#ket_product").val();
        $.ajax({
            url: "<?= base_url(); ?>cart/add_ket",
            type: "post",
            data: {
                rowid: rowid,
                ket: ket
            },
            success: function(){
                $("small.desc_product_"+rowid).html("ket: " + ket + ` <a href="#" class="text-dark" data-toggle="modal" data-target="#modalEditDescription" onclick="showModalEditKet('${rowid}')"><i class="fa text-info fa-edit"></i></a>`);
            }
        })
    })

    $("#btnEditKetProduct").on('click', function(){
        const rowid = $("#rowid_pro_edit").val();
        const ket = $("#ket_product_edit").val();
        $.ajax({
            url: "<?= base_url(); ?>cart/add_ket",
            type: "post",
            data: {
                rowid: rowid,
                ket: ket
            },
            success: function(){
                $("small.desc_product_"+rowid).html("ket: " + ket + ` <a href="#" class="text-dark" data-toggle="modal" data-target="#modalEditDescription" onclick="showModalEditKet('${rowid}')"><i class="fa text-info fa-edit"></i></a>`);
            }
        })
    })

</script>
