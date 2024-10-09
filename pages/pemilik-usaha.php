<?php if(!isset($_GET['action'])): ?>
	<div class="content-header">
		<h1>Pemilik Usaha <small>Kelola Data Pemilik Usaha</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Home</a></li>
			<li class="active">Pemilik Usaha</li>
		</ol>
	</div>

	<div class="content">
		<div class="row">
			<div class="col-lg-2">
				<a class="btn btn-primary" href="index.php?page=pemilik-usaha&action=tambah">
					<i class="fas fa-plus-circle mr-1"></i>
					Tambah
				</a>
			</div>
			<div class="col-lg-3 pull-right">
				<div style="position: relative;">
					<i class="fas fa-search" style="position: absolute; top: 8px; right: 10px;"></i>
					<input type="text" name="" class="form-control" placeholder="Cari Pemilik Usaha" onkeyup="table.search(this.value).draw()">
				</div>
			</div>
		</div>
		<br>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Tabel Pemilik Usaha</h3>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>No KTP</th>
							<th>TTL</th>
							<th>Email</th>
							<th>Telepon</th>
							<th>Alamat</th>
							<th>Kecamatan</th>
							<th>Kelurahan</th>
							<th class="text-right">Jml UKM</th>
							<th></th>
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
			order: [1, 'asc'],
			ajax: {
				type: 'post',
				url: 'datatables.php?fetch=pemilik-usaha',
			},
			columns: [
				{data: 'no', width: '30px', orderable: false, class: 'text-center'},
				{data: 'nama'},
				{data: 'no_ktp'},
				{data: null, render: function(data){
					return `${data.tempat_lahir}, ${data.tanggal_lahir}`;
				}},
				{data: 'email'},
				{data: 'telepon'},
				{data: 'alamat'},
				{data: 'nama_kecamatan'},
				{data: 'nama_kelurahan'},
				{data: 'ukm', class: 'text-right'},
				{data: null, orderable:false, class: 'text-right', render: function(data) {
					return `
					<a href="index.php?page=pemilik-usaha&action=edit&id=${data.id_pemilik}" class='btn-no-style mr-1' data-edit><i class='fas fa-fw fa-edit'></i></a>
					<form style="display: inline;" method="post" action="proses/p_pemilik-usaha.php" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
						<input type="hidden" name="delete" value="${data.id_pemilik}">
						<button type="submit" class='btn-no-style'><i class='fas fa-fw fa-trash-alt'></i></button>
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
	if(isset($_GET['id'])) {
		$db->where('id_pemilik', $_GET['id']);
		$record = $db->get('pemilik_usaha')[0];
	}

	$_title = $act == 'tambah' ? 'Tambah' : 'Edit';
	?>
	<div class="content-header">
		<h1><?= $_title ?> Pemilik Usaha</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
			<li><a href="#">Pemilik Usaha</a></li>
			<li class="active"><?= $_title ?> Pemilik Usaha</li>
		</ol>
	</div>
	<div class="content">
		<div class="box box-primary" style="max-width: 800px;">
			<div class="box-header with-border">
				<div class="box-title"><?= $_title ?> Pemilik Usaha</div>
			</div>
			<form class="form-horizontal" role="form" method="post" action="proses/p_pemilik-usaha.php">
				<div class="box-body">
					<div class="form-group">
						<label class="col-lg-3 control-label">Nomor KTP</label>
						<div class="col-lg-4">
							<input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP" required value="<?= $record['no_ktp'] ?? '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Nama Lengkap</label>
						<div class="col-lg-9">
							<input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Pemilik Usaha" required value="<?= $record['nama'] ?? '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Jenis Kelamin</label>
						<div class="col-lg-4">
							<?php  
							$rec_jekel = $record['jenis_kelamin'] ?? '';
							$jekel = ['laki-laki', 'perempuan'];

							foreach($jekel as $j){
								echo "<div class='radio'><label><input type='radio' name='jenis_kelamin' value='$j' required ".($rec_jekel == $j ? 'checked' : '').">".ucwords($j)."</label></div>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Tempat / Tanggal Lahir</label>
						<div class="col-lg-6">
							<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?= $record['tempat_lahir'] ?? '' ?>">
						</div>
						<div class="col-lg-3">
							<input type="date" name="tanggal_lahir" class="form-control" value="<?= $record['tanggal_lahir'] ?? '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Agama</label>
						<div class="col-lg-3">
							<select name="agama" class="form-control">
								<option value="">Pilih Agama</option>
								<?php  
								$rec_agama = $record['agama'] ?? '';
								$options = ['Kristen', 'Katolik', 'Islam', 'Hindu', 'Budha'];
								foreach($options as $option){
									echo "<option value='$option' ".($rec_agama == $option ? 'selected' : '').">$option</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Email & Telepon</label>
						<div class="col-lg-6">
							<input type="text" name="email" class="form-control" placeholder="Alamat Email" value="<?= $record['email'] ?? '' ?>">
						</div>
						<div class="col-lg-3">
							<input type="text" name="telepon" class="form-control" placeholder="Nomor Telepon" value="<?= $record['telepon'] ?? ''?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Alamat</label>
						<div class="col-lg-9">
							<textarea name="alamat" class="form-control" placeholder="Alamat Pemilik Usaha"><?= $record['alamat'] ?? '' ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Kecamatan</label>
						<div class="col-lg-3">
							<select name="id_kecamatan" class="form-control">
								<option value="">Pilih Kecamatan</option>
								<?php 
								foreach($db->get('kecamatan') as $row){
									$selected = "";
									if($row['id_kecamatan'] == $row['id_kecamatan'])
										$selected = "selected";
									echo "<option value='$row[id_kecamatan]' $selected>$row[nama_kecamatan]</optino>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Kelurahan</label>
						<div class="col-lg-3">
							<select name="id_kelurahan" class="form-control">
								<option value="">Pilih Kelurahan</option>
								<?php 
								foreach($db->get('kelurahan') as $row){
									$selected = "";
									if($row['id_kelurahan'] == $row['id_kelurahan'])
										$selected = "selected";
									echo "<option value='$row[id_kelurahan]' $selected>$row[nama_kelurahan]</optino>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="hidden" name="id_pemilik" value="<?= $record['id_pemilik']  ?? 0?>">
					<a href="index.php?page=pemilik-usaha" class="btn btn-default">Batal</a>
					<button type="submit" class="btn btn-primary pull-right">Simpan</button>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		
	</script>
<?php endif; ?>