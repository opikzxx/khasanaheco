<div class="wrapper">
    <div class="navigation">
        <a href="<?= base_url(); ?>">Home</a>
        <i class="fa fa-caret-right"></i>
        <a href="<?= base_url(); ?>c/"><?= $product['name']; ?></a>
        <i class="fa fa-caret-right"></i>
        <a><?= $product['title']; ?></a>
    </div>
    <div class="top">
        <div class="main-top">
            <div class="img">
                <a href="<?= base_url(); ?>assets/images/product/<?= $product['img']; ?>" data-lightbox="img-1">
                    <img src="<?= base_url(); ?>assets/images/product/<?= $product['img']; ?>" alt="produk" class="jumbo-thumb">
                </a>
                <div class="img-slider">
                    <img src="<?= base_url(); ?>assets/images/product/<?= $product['img']; ?>" alt="gambar" class="thumb">
                </div>
            </div>
            <div class="ket">
                <h1 class="title"><?= $product['title']; ?></h1>
                <p class="subtitle"><?= $product['viewer']; ?>x Dilihat</p>
                <hr>
                <form action="<?= base_url(); ?>cart/add_cart"  method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <table>
                    
                        <tr>
                            <td class="t">Harga</td>
                            <td class="price">Rp <?= str_replace(",",".",number_format($product['price'])); ?></td>
                        </tr>
                   

                    <tr>
                        
                            <?php $priceP = $product['price']; ?>
                        <td class="t">Jumlah</td>
                        <td>
                            <button onclick="minusProduct(<?= $priceP; ?>)">-</button><!--
                        --><input disabled type="text" value="1" id="qtyProduct" class="valueJml"><!--
                        --><button onclick="plusProduct(<?= $priceP; ?>)">+</button>
                        </td>
                    </tr>
                    <input type="hidden" id="idProduct" name="idProduct" value="<?= $product['productId']; ?>"></input>
                    <tr>
                        <td class="t">Total</td>
                        <td>Rp <span id="detailTotalPrice"><?= str_replace(",",".",number_format($priceP)); ?></span></td>
                    </tr>
                </table>
                <hr>
                <button class="btn btn-primary" type="submit">Tambah ke Keranjang</button>
            </div>
        </div>
    </div>
    </form>
    <hr>
    <div class="description">
        <?= nl2br($product['description']); ?>
    </div>
    <hr>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    function plusProduct(price){
        let inputJml;
        inputJml = parseInt($("input.valueJml").val());
        inputJml = inputJml + 1;
        if(inputJml){
            $.ajax({
                url: `<?= base_url(); ?>products/getgrosir?product=<?= $product['productId']; ?>&stock=${inputJml}`,
                type: "get",
                async: true,
                success: function(response){
                    if(response){
                        $("input.valueJml").val(inputJml);
                        $("td.price").html("Rp " + number_format(response).split(",").join(".") + " <small style='font-size: 13px; font-weight: normal' class='badge badge-info'>grosir</small>");
                        const newPrice = inputJml * response;
                        const rpFormat = number_format(newPrice);
                        $("#detailTotalPrice").text(rpFormat.split(",").join("."));
                    }else{
                        $("input.valueJml").val(inputJml);
                        $("td.price").html("Rp " + number_format(price).split(",").join("."));
                        const newPrice = inputJml * price;
                        const rpFormat = number_format(newPrice);
                        $("#detailTotalPrice").text(rpFormat.split(",").join("."));
                    }
                }
            })
        }
    }

    function minusProduct(price){
        let inputJml;
        inputJml = parseInt($("input.valueJml").val());
        inputJml = inputJml - 1;
        if(inputJml >= 1){
            $.ajax({
                url: `<?= base_url(); ?>products/getgrosir?product=<?= $product['productId']; ?>&stock=${inputJml}`,
                type: "get",
                async: true,
                success: function(response){
                    if(response){
                        $("input.valueJml").val(inputJml);
                        $("td.price").html("Rp " + number_format(response).split(",").join(".") + " <small style='font-size: 13px; font-weight: normal' class='badge badge-info'>grosir</small>");
                        const newPrice = inputJml * response;
                        const rpFormat = number_format(newPrice);
                        $("#detailTotalPrice").text(rpFormat.split(",").join("."));
                    }else{
                        $("input.valueJml").val(inputJml);
                        $("td.price").html("Rp " + number_format(price).split(",").join("."));
                        const newPrice = inputJml * price;
                        const rpFormat = number_format(newPrice);
                        $("#detailTotalPrice").text(rpFormat.split(",").join("."));
                    }
                }
            })
        }
    }

    function number_format (number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        var s = ''

        var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
        }

        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
        }

        return s.join(dec)
    }

    function addCart(){
        $.ajax({
            url: "<?= base_url(); ?>cart/add_to_cart",
            type: "post",
            data: {
                id: <?= $product['productId']; ?>,
                qty: $("#qtyProduct").val()
            },
            success: function(data){
                $(".navbar-cart-inform").html(`<i class="fa fa-shopping-cart"></i> Keranjang(<?= count($this->cart->contents()) + 1; ?>)`);
                swal({
                    title: "Berhasil Ditambah ke Keranjang",
                    text: `<?= $product['title']; ?>`,
                    icon: "success",
                    buttons: true,
                    buttons: ["Lanjut Belanja", "Lihat Keranjang"],
                    })
                    .then((cart) => {
                    if (cart) {
                        location.href = "<?= base_url(); ?>cart"
                    }
                });
            }
        })
    }

    // slider product
    const containerImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img");
    const jumboImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img img.jumbo-thumb");
    const jumboHrefImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img a");
    const thumbsImgProduct = document.querySelectorAll("div.wrapper div.top div.main-top div.img div.img-slider img.thumb");
    
    containerImgProduct.addEventListener('click', function(e){
        if(e.target.className == 'thumb'){
            jumboImgProduct.src = e.target.src;
            jumboHrefImgProduct.href = e.target.src;
            
            thumbsImgProduct.forEach(function(thumb){
                thumb.className = 'thumb';
            })
        }
    })

</script>
