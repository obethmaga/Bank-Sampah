<?php if(!isset($_GET['action'])): ?>
	<div class="content-header">
		<h1>Usaha <small>Kelola Data Usaha</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
			<li class="active">Usaha</li>
		</ol>
	</div>

	<div class="content">
		<div style="margin: .5em 0">
			<a href="index.php?page=usaha&action=tambah" class="btn btn-primary">
				<i class="fas fa-plus-circle mr-1"></i>
				Tambah
			</a>
			<div class='pull-right' style="position: relative;">
				<i class="fas fa-search" style="position: absolute; top: 8px; right: 10px;"></i>
				<input type="text" name="" class="form-control" placeholder="Cari Usaha" onkeyup="table.search(this.value).draw()">
			</div>
		</div>
		<div class="box box-primary">
			<div class="box-header with-border">
				<b class="box-title">Data Usaha</b>
			</div>
			<div class="box-body">
				<table class="table" style="width: 100%;">
					<thead class="text-muted">
						<tr> 
							<th>Nama Usaha</th>
							<th>No Ijin</th>
							<th>Pemilik</th>
							<th>Jenis Usaha</th>
							<th>Legalitas</th>
							<th class="none">Tgl. Operasi</th>
							<th class="none">Aset</th>
							<th class="none">Modal</th>
							<th class="none">Tenaga Kerja</th>
							<th class="none">Kelurahan</th>
							<th>Alamat</th>
							<th class="all"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var table = $('.table').DataTable({
			dom: 't<<"pull-left"i><"pull-right"p>>',
			processing: true,
			serverSide: true,
			responsive: {
				details: {
					display: DataTable.Responsive.display.modal({
						header: function(row){
							var data = row.data();
							return data.nama_usaha;
						}
					}),
					renderer: DataTable.Responsive.renderer.tableAll({
						tableClass: 'table'
					}),
					type: 'button',
					target: '.show-detail'
				}
			},
			order: [1, 'asc'],
			ajax: {
				type: 'post',
				url: 'datatables.php?fetch=usaha',
			},
			columns: [ 
				{data: 'nama_usaha'},
				{data: 'no_ijin'},
				{data: 'nama_pemilik'},
				{data: 'nama_jenis'},	
				{data: null, render: (data) => {
					var legalitas  = data.legalitas == "0" ? 'Tidak' : 'Ya';
					return legalitas;
				}},	
				{data: 'tgl_operasi'},	
				{data: 'aset'},
				{data: 'modal'},	
				{data: 'tenaga_kerja'},	
				{data: 'nama_kelurahan'},	
				{data: 'alamat'},	
				{data: null, orderable:false, class: 'text-right', render: function(data) {
					return `
					<a href="#" class='show-detail mr-1'><i class='fas fa-search fa-fw'></i></a>
					<a href='index.php?page=usaha&action=edit&id=${data.id_usaha}' class='mr-1'><i class='fas fa-pencil fa-fw'></i></a>
					<form style="display: inline;" method="post" action="proses/p_usaha.php" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
						<input type="hidden" name="delete" value="${data.id_usaha}">
						<button type="submit" class='btn-no-style'><i class='fas fa-trash fa-fw'></i></button>
					</form>
					`;
				}}
			],
		});
	</script>
<?php else: ?>
	<?php  
	$act = $_GET['action'];

	$record = [];
	$foto = null;
	if(isset($_GET['id'])) {
		$db->where('id_usaha', $_GET['id']);
		$record = $db->get('usaha')[0];
		$foto = !empty($record['foto']) ? $record['foto'] : null;
	}

	$_title = $act == 'tambah' ? 'Tambah' : 'Edit';
	?>

	<div class="content-header">
		<h1><?= $_title ?> Usaha</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Home</a></li>
			<li><a href="#">Usaha</a></li>
			<li class="active"><?= $_title ?> Usaha</li>
		</ol>
	</div>

	<div class="content">
		<form class="form-horizontal" method="post" action="proses/p_usaha.php" enctype="multipart/form-data">
			<input type="hidden" name="usaha" value="<?= time() ?>">
			<div class="row">
				<div class="col-lg-7">
					<div class="box box-primary">
						<div class="box-header with-border">
							<b class="box-title"><?= $_title ?></b>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="col-lg-3 control-label">No Ijin Usaha</label>
								<div class="col-lg-9">
									<input type="text" name="no_ijin" class="form-control" placeholder="Nomor Ijin Usaha" required value="<?= $record['no_ijin'] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Nama Usaha</label>
								<div class="col-lg-6">
									<input type="text" name="nama_usaha" class="form-control" placeholder="Nama Usaha" required value="<?= $record['nama_usaha'] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Jenis Usaha</label>
								<div class="col-lg-4">
									<select class="form-control" name="id_jenis">
										<option></option>
										<?php  
										$list_jenis_usaha = $db->get('jenis_usaha');
										foreach($list_jenis_usaha as $option){
											$record_jenis = $record['id_jenis'] ?? 0;
											$selected = $option['id_jenis'] == $record_jenis ? 'selected' : '';
											echo "<option value='$option[id_jenis]' title='$option[sektor]' $selected>$option[nama_jenis]</option>";
										}
										?>
									</select>
								</div>
								<div class="col-lg-4">
									<input type="text" name="sektor" class="form-control" placeholder="Sektor Usaha" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Pemilik Usaha</label>
								<div class="col-lg-9">
									<select name="id_pemilik" class="form-control">
										<option></option>
										<?php  
										$list_pemilik = $db->get('pemilik_usaha');
										foreach($list_pemilik as $option){
											$id_pemilik = $record['id_pemilik'] ?? 0;
											$selected = $option['id_pemilik'] == $id_pemilik ? 'selected' : '';
											echo "<option value='$option[id_pemilik]' $selected>$option[nama]</option>";
										}
										?>
									</select> 
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Tanggal Operasi</label>
								<div class="col-lg-4">
									<input type="date" name="tgl_operasi" class="form-control" placeholder="Tanggal Operasi" value="<?= $record['tgl_operasi'] ?? '' ?>">
									<span class="text-muted text-sm">Tanggal Usaha mulai beroperasi.</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Legalitas Usaha</label>
								<div class="col-lg-4">
									<?php  
									$legalitas = [0 => 'Tidak', 1 => 'Ya'];
									foreach($legalitas as $k => $v){
										$lgl = $record['legalitas'] ?? '';
										$checked = $k == $lgl ? 'checked' : '';
										?>
										<div class="radio"><label><input type="radio" name="legalitas" value="<?= $k ?>" <?= $checked ?>><?= $v ?></label></div>
										<?php
									}
									?> 
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Modal Usaha</label>
								<div class="col-lg-6">
									<input type="text" name="modal" class="form-control" placeholder="Modal Usaha" value="<?= $record['modal'] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Aset Usaha</label>
								<div class="col-lg-9">
									<textarea name="aset" class="form-control"><?= $record['aset'] ?? '' ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Tenaga Kerja</label>
								<div class="col-lg-3">
									<input type="number" name="tenaga_kerja" class="form-control" min="0" value="<?= $record['tenaga_kerja'] ?? 0 ?>">
									<span class="text-muted text-sm">Jumlah Tenaga Kerja</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Kelurahan</label>
								<div class="col-lg-4">
									<select class="form-control" name="id_kelurahan" required>
										<?php
										$kelurahan = $db->get('kelurahan');
										foreach($kelurahan as $row){
											$record_kel = $record['id_kelurahan'] ?? 0;
											$selected = $row['id_kelurahan'] == $record_kel ? 'selected' : '';
											$kecamatan = $db->where('id_kecamatan', $row['id_kecamatan'])->get('kecamatan')[0];
											echo "<option value='$row[id_kelurahan]' title='$kecamatan[nama_kecamatan]' $selected>$row[nama_kelurahan]</option>";
										}  
										?>
									</select>
								</div>
							</div>
							<!-- .form-group -->
							<div class="form-group">
								<label class="col-lg-3 control-label">Alamat</label>
								<div class="col-lg-9">
									<textarea name="alamat" class="form-control"><?= $record['alamat'] ?? '' ?></textarea>
								</div>
							</div>
							<!-- .form-group -->
							<div class="form-group">
								<label class="col-lg-3 control-label">Foto</label>
								<div class="col-lg-4">
									<input type="file" name="foto" class="dropify" data-height="100" data-allowed-file-extensions="jpg jpeg png" data-errors-position="outside" <?= !is_null($foto) ? "data-default-file='uploads/$foto'" : '' ?>>
									<?php if($act == 'edit'){ ?>
										<span class="text-muted text-sm">Tinggalkan kosong jika tidak diubah</span>
									<?php } ?>
								</div>
							</div>
						</div>
						<!-- end box-body -->
						<div class="box-footer">
							<div class="row">
								<div class="col-lg-3"></div>
								<div class="col-lg-9">
									<input type="hidden" name="id_usaha" value="<?= $record['id_usaha'] ?? 0 ?>">
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="box box-primary">
						<div class="box-header with-border">
							<b class="box-title">Lokasi Usaha</b>
						</div>
						<div class="box-body">
							<div id="map"></div>
							<div class="row">
								<div class="col-lg-6">
									<label class="control-label">Lat</label>
									<input type="text" name="lat" class="form-control" placeholder="Lat" required value="<?= $record['lat'] ?? '' ?>">
								</div>
								<div class="col-lg-6">
									<label class="control-label">Lng</label>
									<input type="text" name="lng" class="form-control" placeholder="Lng" required value="<?= $record['lng'] ?? '' ?>">
								</div>
							</div>
							<!-- end row -->
							<br>
							<button type="button" class="btn btn-default" onclick="addMarker()">Set Map</button>
						</div>
						<!-- end box-body -->
					</div>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$('.dropify').dropify();

		$('[name="id_jenis"]').select2({
			placeholder: 'Pilih Jenis Usaha',
			templateResult: function(data){
				return $(`<div>${data.text} <br> <small class='text-muted'>Sektor: ${data.title}</small></div>`);
			}
		}).on('change', function(){
			var data = $(this).select2('data')[0];
			$('[name="sektor"]').val(data.title);
		})

		$('[name="id_pemilik"]').select2({
			placeholder: 'Pilih Pemilik Usaha'
		});

		$('[name="id_kelurahan"]').select2({
			placeholder: 'Pilih Kelurahan',
			templateResult: function(data){
				return $(`<div>${data.text} <br> <small class=''>${data.title}</small></div>`);
			}
		}).on('change', function(){
			var data = $(this).select2('data')[0];
			$('[name="sektor"]').val(data.title);
		})

		mapboxgl.accessToken = '<?= MAPBOX_TOKEN ?>';
		const map = new mapboxgl.Map({
			container: 'map', // container ID
			center: [123.58057, -10.18096], // starting position [lng, lat]. Note that lat must be set between -90 and 90
			zoom: 11 // starting zoom
		});

	let marker = new mapboxgl.Marker();
	function addMarker(){
		marker.remove();
		var long = $('[name=lng]').val();
		var lat = $('[name=lat]').val();
		marker.setLngLat([long, lat]).addTo(map);
		map.setZoom(13)

		let coords = marker.getLngLat();
		map.flyTo({
			center: coords,
		})
	}

	<?php if($act == 'edit'){ echo 'addMarker();'; } ?>
	</script>
<?php endif; ?>