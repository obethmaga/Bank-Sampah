<div class="content-header">
	<h1>Jenis Usaha <small>Kelola Data Jenis Usaha</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
		<li class="active">Jenis Usaha</li>
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
				<input type="text" class="form-control" placeholder="Cari Jenis Usaha" onkeyup="table.search(this.value).draw()">
			</div>
		</div>
	</div>
	<br>
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tabel Jenis Usaha</h3>
		</div>
		<div class="box-body">
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Jenis Usaha</th>
						<th>Sektor</th>
						<th>Ikon</th>
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
				<h4 class="modal-title">Tambah Jenis Usaha</h4>
			</div>
			<form method="post" action="proses/p_jenis-usaha.php">
				<div class="modal-body">
					<div class="form-group">
						<label>Jenis Usaha</label>
						<input type="text" class="form-control" name="nama_jenis" value="" required>
					</div>
					<div class="form-group">
						<label>Sektor Usaha</label>
						<input type="text" class="form-control" name="sektor" value="" required>
					</div>
					<div class="form-group">
						<label>Ikon</label>
						<select class="form-control ikon" style="width: 100%;" name="ikon">
							<option value=""></option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_jenis" value="0">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	var options = [
		{id: 'jasa.png', text: 'Jasa'},
		{id: 'kafe.png', text: 'Kafe'},
		{id: 'mobil.png', text: 'Rental Mobil'},
		{id: 'penginapan.png', text: 'Penginapan'},
		{id: 'rumahmakan.png', text: 'Rumah Makan'},
		{id: 'toko.png', text: 'Toko'},
		{id: 'wisata.png', text: 'Wisata'},
	];

	$('.ikon').select2({
		placeholder: 'Pilih Ikon',
		data: options,
		templateResult: function(data){
			var baseurl = "assets/icon/marker";
			return $(`<span><img style="width: 24px; margin-right: .5em;" src='${baseurl}/${data.id}'>${data.text}</span>`);
		},

	})

	var table = $('.table').DataTable({
		dom: 't<<"pull-left"i><"pull-right"p>>',
		processing: true,
		serverSide: true,
		order: [1, 'asc'],
		ajax: {
			type: 'post',
			url: 'datatables.php?fetch=jenis-usaha',
		},
		columns: [
			{data: 'no', width: '30px', orderable: false, class: 'text-center'},
			{data: 'nama_jenis'},
			{data: 'sektor'},
			{data: null, render: data =>{
				return `<img width='24px' src='assets/icon/marker/${data.ikon}'>`;
			}},
			{data: null, orderable:false, width: '150px', class: 'text-right', render: function(data) {
				return `
				<button class='btn-no-style mr-1' data-edit><i class='fas fa-edit'></i></button>
				<form style="display: inline;" method="post" action="proses/p_jenis-usaha.php" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
					<input type="hidden" name="delete" value="${data.id_jenis}">
					<button type="submit" class='btn-no-style'><i class='fas fa-trash-alt'></i></button>
				</form>
				`;
			}}
		],
	});

	table.on('click', '[data-edit]', function(e){
		var data = table.row(e.target.closest('tr')).data();

		var modal = $('#modal1');
		modal.find('.modal-title').text('Ubah Jenis USaha');
		modal.find('[name="nama_jenis"]').val(data.nama_jenis);
		modal.find('[name="sektor"]').val(data.sektor);
		modal.find('[name="id_jenis"]').val(data.id_jenis);
		modal.find('[name="ikon"]').val(data.ikon).trigger('change');
		modal.find('[type="submit"]').text("Simpan");

		modal.modal('show')
			.on('hidden.bs.modal', function(){
				modal.find('.modal-title').text('Tambah Jenis Usaha');
				modal.find('[name="nama_jenis"]').val('');
				modal.find('[name="sektor"]').val('');
				modal.find('[name="id_jenis"]').val('0');
				modal.find('[name="ikon"]').val('').trigger('change');
				modal.find('[type="submit"]').text("Tambah");
			});
	})
</script>