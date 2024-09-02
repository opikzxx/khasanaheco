<form action="<?= base_url(); ?>payment/succesfully" method="post">
    <div class="wrapper">
        <div class="core">
            <div class="products">
                <table class="table">
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                    <?php foreach($this->cart->contents() as $item): ?>
                    <tr>
                        <td># <?= $item['name']; ?><br>
                        <td class="text-center"><?= $item['qty']; ?></td>
                        <td>Rp<?= number_format($item['price'] * $item['qty'],0,",","."); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="address">
                <!-- Bagian alamat -->
            </div>
            <div class="line mt-4"></div>
            <div class="send">
                <h2 class="title">Metode Pengiriman</h2>
                <div class="form-group mt-3" id="groupPaymentSelectKurir">
                    <select name="courier_option" id="paymentSelectKurir" class="form-control" required>
                        <option value="Ambil Di Tempat">Ambil Di Tempat</option>
                        <option value="Antar (Maks 5KM)">Antar (Maks 5KM)</option>
                    </select>
                </div>
            </div>
        </div>
        
        <?php
            $totalall = 0;
            $totalitem = 0;
            $ongkir = 0;
            foreach($this->cart->contents() as $c):
                $totalall += intval($c['price']) * intval($c['qty']);
                $totalitem += intval($c['qty']);
            endforeach;
        ?>
        
        <input type="hidden" id="ongkosKirim" name="ongkosKirim" value="0">
        <input type="hidden" id="paymentPriceTotalAll" value="<?= $totalall; ?>">
        
        <div class="total shadow">
            <h2 class="title">Ringkasan Belanja</h2>
            <hr>
            <div class="list">
                <p>Total Belanja</p>
                <p>Rp<?= number_format($totalall,0,",","."); ?></p>
            </div>
            <div class="list">
                <p>Ongkos Kirim</p>
                <p id="ongkirDisplay">Rp0</p>
            </div>
            <hr>
            <div class="list">
                <p>Total Tagihan</p>
                <p id="paymentTotalAll">Rp<?= number_format($totalall+$ongkir,0,",","."); ?></p>
            </div>
            <?php if($this->cart->total_items() > 0){ ?>
                <button class="btn btn-dark btn btn-block mt-2" id="btnPaymentNow" type="submit">Bayar Sekarang</button>
            <?php }else{ ?>
                <div class="alert mt-2 alert-warning">Keranjangmu masih kosong.</div>
                <a href="<?= base_url(); ?>">
                    <button class="btn btn-dark btn btn-block mt-2">Belanja Dulu</button>
                </a>
            <?php } ?>
        </div>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectKurir = document.getElementById('paymentSelectKurir');
    const ongkirDisplay = document.getElementById('ongkirDisplay');
    const totalDisplay = document.getElementById('paymentTotalAll');
    const initialTotal = parseInt(document.getElementById('paymentPriceTotalAll').value);
    const ongkosKirimInput = document.getElementById('ongkosKirim');
    const ongkir = 10000;

    selectKurir.addEventListener('change', function() {
        let ongkosKirim = 0;

        if (selectKurir.value === 'Antar (Maks 5KM)') {
            ongkosKirim = ongkir;
        } 

        // Update nilai ongkos kirim dan total
        ongkirDisplay.textContent = 'Rp' + ongkosKirim.toLocaleString('id-ID');
        totalDisplay.textContent = 'Rp' + (initialTotal + ongkosKirim).toLocaleString('id-ID');
        ongkosKirimInput.value = ongkosKirim; // Update input hidden untuk ongkos kirim
    });
});
</script>
