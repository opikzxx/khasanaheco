
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

        $("#paymentSelectProvinces").select2({
            placeholder: 'Pilih Provinsi',
            language: 'id'
        })

        $("#paymentSelectRegencies").select2({
            placeholder: 'Pilih Kabupaten/Kota',
            language: 'id'
        })

        $("#paymentSelectKurir").select2({
            placeholder: 'Pilih Salah Satu',
            language: 'id'
        })

        $("#paymentSelectProvinces").change(function(){
            $("#paymentSelectRegencies").select2({
                placeholder: 'Loading..',
                language: 'id'
            })
            const id = $(this).val();
            $.ajax({
                url: "<?= base_url(); ?>payment/getLocation",
                type: "post",
                dataType: "json",
                async: true,
                data: {
                    id: id
                },
                success: function(data){
                    $("#paymentSelectRegencies").select2({
                        placeholder: 'Pilih Kabupaten/Kota',
                        language: 'id'
                    })
                    $("#paymentSelectRegencies").html(data);
                    $("#paymentTextErrorAboveSelectKurir").hide();
                }
            });
        })

        $("#paymentSelectProvinces").change(paymentSelectKurir);

        $("#paymentSelectRegencies").change(paymentSelectKurir);

       

        

        
</script>
</body>
</html>