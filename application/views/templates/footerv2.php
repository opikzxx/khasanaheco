
 <?php
        if($this->session->userdata('login')){
            $totalall = 0;
            foreach($this->cart->contents() as $c){
                $totalall += intval($c['price']) * intval($c['qty']);
            }
        }
        ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/lightbox2-2.11.1/dist/js/lightbox.js"></script>
<script src="<?= base_url(); ?>assets/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
<script>
//loading screen
$(window).ready(function(){
    $(".loading-animation-screen").fadeOut("slow");
    $('#modalRegisterSuccess').modal('show');

    $("i.fa-bars").on('click', function(){
            $("div.dropdown-mobile-menu").slideToggle('fast');
        })
})


function paymentSelectKurir(){
            $("#paymentSelectKurir").select2({
                placeholder: 'Loading..',
                language: 'id'
            })
            $("#paymentTotalAll").text("Rp"+'<?= number_format($totalall,0,",","."); ?>');
            $("#paymentSendingPrice").text("Rp0");
            const destination = $("#paymentSelectRegencies").val();
            if(destination === ""){
                $("#paymentTextErrorAboveSelectKurir").show();
            }else{
                $("#paymentTextErrorAboveSelectKurir").hide();
                $.ajax({
                    url: "<?= base_url(); ?>payment/getService",
                    type: "post",
                    dataType: "json",
                    async: true,
                    data: {
                        destination: destination
                    },
                    success: function(data){
                        $("#paymentSelectKurir").select2({
                            placeholder: 'Pilih Salah Satu',
                            language: 'id'
                        })
                        $("#paymentSelectKurir").html(data);
                    }
                });
            }
        }

        $("#paymentSelectKurir").change(paymentSelectService);

        function paymentSelectService(){
            let id = $("#paymentSelectKurir").val();
            id = id.split('-');
            id = id[0];
            if(id === ""){
                id = 0;
            }
            $("#paymentSendingPrice").text("Rp"+number_format(id).split(",").join("."));
            const price = $("#paymentPriceTotalAll").val();
            const total = parseInt(price) + parseInt(id);
            $("#paymentTotalAll").text("Rp"+number_format(total).split(",").join("."));
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

        

        
</script>
</body>
</html>