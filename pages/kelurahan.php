<div class="content-header">
	<h1>Kelurahan <small>Kelola Data Kelurahan</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
		<li class="active">Kelurahan</li>
	</ol>
</div>

<div class="content">
	<div class="row">
		<div class="col-lg-2">
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal1">
				<i class="fas fa-plus-circle mr-1"></i>
				Tambah
			</button>
		</div>
		<div class="col-lg-3 pull-right">
			<div style="position: relative;">
				<i class="fas fa-search" style="position: absolute; top: 8px; right: 10px;"></i>
				<input type="text" class="form-control" placeholder="Cari Kelurahan" onkeyup="table.search(this.value).draw()">
			</div>
		</div>
	</div>
	<br>
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tabel Kelurahan</h3>
		</div>
		<div class="box-body">
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Kelurahan</th>
						<th>Nama Kecamatan</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modal1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">			
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">
					<span aria-hidden="true">x</span>
				</button>
				<h4 class="modal-title">Tambah Kelurahan</h4>
			</div>
			<form method="post" action="proses/p_kelurahan.php">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Kelurahan</label>
						<input type="text" class="form-control" name="nama_kelurahan" value="" required>
					</div>
					<div class="form-group">
						<label>Kecamatan</label>
						<select name="id_kecamatan" class="form-control" required>
							<option value="">Pilih Kecamatan</option>
							<?php  
							$options = $db->get('kecamatan');
							foreach($options as $item){
								echo "<option value='$item[id_kecamatan]'>$item[nama_kecamatan]</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_kelurahan" value="0">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	var table = $('.table').DataTable({
		dom: 't<<"pull-left"i><"pull-right"p>>',
		processing: true,
		serverSide: true,
		order: [1, 'asc'],
		ajax: {
			type: 'post',
			url: 'datatables.php?fetch=kelurahan',
		},
		columns: [
			{data: 'no', width: '30px', orderable: false, class: 'text-center'},
			{data: 'nama_kelurahan'},
			{data: 'nama_kecamatan'},
			{data: null, orderable:false, width: '150px', class: 'text-right', render: function(data) {
				return `
				<button class='btn-no-style mr-1' data-edit><i class='fas fa-edit'></i></button>
				<form style="display: inline;" method="post" action="proses/p_kelurahan.php" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
					<input type="hidden" name="delete" value="${data.id_kelurahan}">
					<button type="submit" class='btn-no-style'><i class='fas fa-trash-alt mr-1'></i></button>
				</form>
				`;
			}}
		],
	});

	table.on('click', '[data-edit]', function(e){
		var data = table.row(e.target.closest('tr')).data();

		console.log(data);

		var modal = $('#modal1');
		modal.find('.modal-title').text('Ubah Kelurahan');
		modal.find('[name="nama_kelurahan"]').val(data.nama_kelurahan);
		modal.find('[name="id_kecamatan"]').val(data.id_kecamatan).change();
		modal.find('[name="id_kelurahan"]').val(data.id_kelurahan);
		modal.find('[type="submit"]').text("Simpan");

		modal.modal('show')
			.on('hidden.bs.modal', function(){
				modal.find('.modal-title').text('Tambah Kecamatan');
				modal.find('[name="nama_kelurahan"]').val('');
				modal.find('[name="id_kecamatan"]').val('').change();
				modal.find('[name="id_kelurahan"]').val('0');
				modal.find('[type="submit"]').text("Tambah");
			});
	})
</script>