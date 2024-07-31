<div class="wrapper">
  <div class="p-2 p-lg-5 align-items-center" style="background-image:url(https://images.pexels.com/photos/7130560/pexels-photo-7130560.jpeg);background-size:cover">
    <div class="row product-wrapper">
      <div class="col-md-6 text-center order-1 order-md-2 mb-3 mb-md-0">
        <img src="https://images.pexels.com/photos/18662650/pexels-photo-18662650/free-photo-of-orange-lens-in-the-dark.png" class="img-fluid rounded-circle w-50" alt="">
      </div>
      <div class="col-md-6 order-2 order-md-1">
        <h1>Khasanah Eco Bakery Cake</h1>
        <p>Toko Roti Khasanah Eco Bakery and Cake adalah sebuah toko roti yang menawarkan berbagai produk roti dan kue dengan kualitas tinggi dan perhatian terhadap detail.</p>
        <div class="d-flex gap-2">
        <a href="#product-section" class="btn btn-dark">Lihat Produk</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="category-menu">
    <div class="main-category">
      
      <?php foreach($categoriesLimit->result_array() as $c): ?>
        <a href="<?= base_url(); ?>">
          <div class="item">
              <img src="<?= base_url(); ?>assets/images/icon/<?= $c['icon']; ?>">
              <p><?= $c['name']; ?></p>
          </div>
        </a>
      <?php endforeach; ?>

      <div class="item" data-toggle="modal" data-target="#modalMoreCategory">
          <img src="<?= base_url(); ?>assets/images/icon/category-more.svg">
          <p>Lainnya</p>
      </div>
    </div>
</div>



<div class="product-wrapper">
 
</div>
<div class="product-wrapper" id="product-section">
<div class="product-wrapper">
  <div class="row">
    <div class="col-md-12">
     <h2 class="title text-center">PRODUK KAMI</h2>
     <hr>
     <div class="main-product">
      <?php if($recent->num_rows() > 0){ ?>
        <?php foreach($recent->result_array() as $p): ?>
          <a href="<?= base_url(); ?>products/detail_product/<?= $p['id']; ?>">
          <div class="card d-flex flex-column">
          <img src="<?= base_url(); ?>assets/images/product/<?= $p['img']; ?>" class="card-img-top img-fluid" alt="Product Image" style="height: 90px; object-fit: contain;">
          <div class="card-body d-flex flex-column flex-grow-1">
            <p class="card-text mb-0" style="height: 50px;"><?= $p['title']; ?></p>
            <p class="newPrice">Rp <?= str_replace(",", ".", number_format($p['price'])); ?></p>
          </div>
        </div>
          </a>
        <?php endforeach; ?>
        <div class="clearfix"></div>
      <?php }else{ ?>
        <div class="alert alert-warning">Upss.. Belum ada produk!</div>
      <?php } ?>
    </div>
    <br><br>
    <h2 class="title text-center">PRODUK POPULER</h2>
    <hr>
    <div class="main-product">
      <?php if($best->num_rows() > 0){ ?>
        <?php foreach($best->result_array() as $p): ?>
          <a href="<?= base_url(); ?>products/detail_product/<?= $p['id']; ?>">
            <div class="card">
            <img src="<?= base_url(); ?>assets/images/product/<?= $p['img']; ?>" class="card-img-top img-fluid" alt="Product Image" style="height: 90px; object-fit: contain;">
            <div class="card-body">
                <p class="card-text mb-0" style="height: 50px;"><?= $p['title']; ?></p>
                <p class="newPrice">Rp <?= str_replace(",",".",number_format($p['price'])); ?></p>

              </div>
            </div>
          </a>
        <?php endforeach; ?>
        <div class="clearfix"></div>
      <?php }else{ ?>
        <div class="alert alert-warning">Upss.. Belum ada produk!</div>
      <?php } ?>
    </div>
  </div>
      </div>
<!-- 
  <div class="col-md-3">
    <h2 class="title">PRODUK POPULER</h2>
    <hr>
    <div class="product-wrapper" style="max-width: 250px;">
      <?php foreach($best->result_array() as $p): ?>
        <div>
          <a style="color: black;" href="<?= base_url(); ?>products/detail_product/<?= $p['id']; ?>">
            <div class="card" >
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="<?= base_url(); ?>assets/images/product/<?= $p['img']; ?>" class="card-img-top">
                </div>
                <div class="col-md-8">
                  <div class="main-product">
                    <div class="card-body">
                      <p class="card-text mb-0"><?= $p['title']; ?></p>
                    </div>


                  </div>
                </div>
              </div>


            </div>
          </a>
        </div>
        <br>
      <?php endforeach; ?>
    </div>
  </div> -->
</div>
</div>