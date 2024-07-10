<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Produk</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="<?= base_url(); ?>administrator/add_product"
				class="btn btn-primary btn-sm"
				>Tambah Produk</a
			>
			
		</div>
		<div class="card-body">
            <?php echo $this->session->flashdata('failed'); ?> 
            <?php if($getProducts->num_rows() > 0){ ?>
				<div class="table-responsive">
					<table
						class="table table-bordered"
						id="dataTable"
						width="100%"
						cellspacing="0"
					>
						<thead>
							<tr>
								<th>#</th>
								<th>Foto</th>
								<th>Judul</th>
								<th>Harga</th>
								<th>Kategori</th>
								<th style="width: 130px">Aksi</th>
							</tr>
						</thead>
						<tfoot></tfoot>
						<tbody class="data-content">
							<?php $no = $this->uri->segment(3) + 1; ?>
							<?php foreach($getProducts->result_array() as $data): ?>
							<tr>
								<td><?= $no ?></td>
								<td><img style="width: 50px" src="<?= base_url(); ?>assets/images/product/<?= $data['productsImg']; ?>"></td>
								<td><?= $data['productsTitle']; ?></td>
								<td><?= str_replace(",",".",number_format($data['productsPrice'])); ?></td>
								<td><?= $data['categoriesName']; ?></td>
								<td>
									<a href="<?= base_url() ;?>administrator/edit_product/<?= $data['productsId']; ?>" class="btn btn-sm btn-info"><i class="fa fa-pen"></i></a>
									<a href="<?= base_url() ;?>administrator/delete_product/<?= $data['productsId']; ?>" onclick="return confirm('Yakin ingin menghapus produk?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
								</td>
							</tr>
							<?php $no++ ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?= $this->pagination->create_links(); ?>
				</div>
				<?php }else{ ?>
				<div class="alert alert-warning" role="alert">
					Opss, produk masih kosong, yuk tambah produk sekarang.
				</div>
				<?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
