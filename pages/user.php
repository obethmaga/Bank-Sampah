<?php if(!isset($_GET['action'])): ?>
	<div class="content-header">
		<h1>Pengguna <small>Kelola Data Pengguna</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
			<li class="active">Pengguna</li>
		</ol>
	</div>

	<div class="content">

		<div style="margin: .5em 0">
			<a href="index.php?page=user&action=tambah" class="btn btn-primary">
				<i class="fas fa-plus-circle mr-1"></i>
				Tambah
			</a> 
		</div>

		<div class="box box-primary">
			<div class="box-header with-border">
				<strong class="box-title">Data Pengguna</strong>
			</div>
			<div class="box-body">
				<table class="table" style="width: 100%;">
					<thead>
						<tr>
							<th style="width: 30px; text-align: right;">No</th>
							<th>Nama</th>
							<th>Nama Pendek</th>
							<th>Email</th>
							<th style="width: 70px"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$rows = $db->get('admin');
						foreach($rows as $row){
							echo "<tr>";
							echo "<td class='text-right'>$no</td>";
							echo "<td>$row[nama]</td>";
							echo "<td>$row[nama_pendek]</td>";
							echo "<td>$row[email]</td>";
							echo "<td class='text-right'>";
              if($row['level'] != 'superadmin'){
                echo "<a href='index.php?page=user&action=edit&id=$row[id]' class='btn-no-style mr-1'><i class='fas fa-edit'></i></a>";
                echo '<form style="display: inline;" method="post" action="proses/p_user.php" onsubmit="return confirm(\'Anda yakin ingin menghapus data ini?\')">
                    <input type="hidden" name="delete" value="'.$row['id'].'">
                    <button type="submit" class=\'btn-no-style\'><i class="fas fa-trash-alt"></i></button>
                  </form>';
              }
							echo "</td>";
							echo "</tr>";
							$no++;
						}  
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php  
	$act = $_GET['action'];

	$title = $act == 'tambah' ? 'Tambah' : 'Edit';
	$row = [];

	if(isset($_GET['id'])){
		$db->where('id', $_GET['id']);
		$row = $db->get('admin')[0];
	}
	?>
	<div class="content-header">
		<h1><?= $title ?> Pengguna <small><?= $title ?> Data Pengguna</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
			<li><a href="#">Pengguna</a></li>
			<li class="active"><?= $title ?> Pengguna</li>
		</ol>
	</div>

	<div class="content">
		<div class="row">
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header">
						<strong class="box-title">Tambah User</strong>
					</div>
					<div class="box-body">
						<form method="post" action="proses/p_user.php" class="form-horizontal" onclick="return checkPassword()">
							<div class="form-group">
								<label class="control-label col-lg-4">Nama</label>
								<div class="col-lg-8">
									<input type="text" name="nama" class="form-control" required value="<?= $row['nama' ] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Nama Pendek</label>
								<div class="col-lg-8">
									<input type="text" name="nama_pendek" class="form-control" required value="<?= $row['nama_pendek' ] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Email</label>
								<div class="col-lg-8">
									<input type="text" name="email" class="form-control" required value="<?= $row['email' ] ?? '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Password</label>
								<div class="col-lg-8">
									<input type="password" name="password" class="form-control">
									<?php if($act == 'edit'): ?>
										<span class="text-sm text-muted">Tinggalkan kosong jika tidak diubah.</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Konfirmasi Password</label>
								<div class="col-lg-8">
									<input type="password" name="confirm" class="form-control">
									<?php if($act == 'edit'): ?>
										<span class="text-sm text-muted">Tinggalkan kosong jika tidak diubah.</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4"></div>
								<div class="col-lg-8">
									<input type="hidden" name="id" value="<?= $row['id'] ?? 0 ?>">
									<a href="index.php?page=user" class="btn btn-default mr-1">Batal</a>
									<button type="submit" class="btn btn-primary"><?= isset($row['id']) ? "Simpan" : "Tambah" ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<script type="text/javascript">
	function checkPassword(){
		var newpass = $('[name=password]').val();
		var newpasscon = $('[name=confirm]').val();

		if(newpass != newpasscon){
			alert('Konfirmasi Password tidak cocok!');
			return false;
		}
		else
			return true;
	}
</script>