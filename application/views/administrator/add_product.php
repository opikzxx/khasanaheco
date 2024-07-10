<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Tambah Produk</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="<?= base_url(); ?>administrator/products" class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Batal</a
			>
		</div>
		<div class="card-body">
			<?php echo $this->session->flashdata('failed'); ?>
			<form
				action="<?= base_url(); ?>administrator/add_product"
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Judul</label>
							<input
								type="text"
								class="form-control"
								id="title"
								name="title"
								placeholder="Isikan Judul Produk"
								autocomplete="off"
                                required
                                value="<?php echo set_value('title'); ?>"
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga</label>
							<input
								type="number"
								class="form-control"
								id="price"
								name="price"
								placeholder="Harga Produk"
								autocomplete="off"
                                required
                                value=<?php echo set_value('price'); ?>
							/>
							<small id="priceHelp" class="form-text text-muted"
								>Isikan tanpa tanda pemisah. Contoh pengisian 300000</small
							>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="cat">Kategori</label>
							<select class="form-control" id="cat" name="category">
								<option selected disabled value="0">--Pilih Kategori--</option>
								<?php foreach($categories->result_array() as $c): ?>
								<option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="img">Foto Utama</label>
							<input
								type="file"
								name="img"
								id="img"
								class="form-control"
                                required
                                value=<?php echo set_value('img'); ?>
							/>
						</div>
                    </div>
				</div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<textarea
						class="form-control"
						id="description"
						name="description"
						rows="7"
					><?php echo set_value('description'); ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Unggah Produk</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
