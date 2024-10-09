<?php  
$db->where('id', $_SESSION['user']['id']);
$user = $db->get('admin')[0];
?>

<div class="content-header">
	<h1>Profil <small>Kelola Profil Anda</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fas fa-home"></i> Home</a></li>
		<li class="active">Profil</li>
	</ol>
</div>

<div class="content">
	<div class="row">
		<div class="col-12 col-lg-6">
			<div class="box box-primary">
				<div class="box-body">
					<h4 class="text-bold">General</h4>
					<table class="table">
						<tr>
							<td style="width: 125px">Nama</td>
							<td><a href="#" id="nama" data-type="text" data-pk="<?= $user['id'] ?>" data-url="proses/p_profil.php" data-title="Masukkan Nama Anda"><?= $user['nama'] ?></a></td>
						</tr>
						<tr>
							<td style="width: 125px">Nama Pendek</td>
							<td><a href="#" id="nama_pendek" data-type="text" data-pk="<?= $user['id'] ?>" data-url="proses/p_profil.php" data-title="Masukkan Nama Pendek Anda"><?= $user['nama_pendek'] ?></a></td>
						</tr>
						<tr>
							<td style="width: 125px">Email</td>
							<td><a href="#" id="email" data-type="text" data-pk="<?= $user['id'] ?>" data-url="proses/p_profil.php" data-title="Masukkan Email Anda"><?= $user['email'] ?></a></td>
						</tr>
					</table>

					<div style="border-bottom: 1px dashed #ccc; margin: 10px 0"></div>

					<h4 class="text-bold">Password</h4>

					<?php  
					if(isset($_SESSION['error'])){
						?>
						<div class="alert alert-warning"><?= $_SESSION['error'] ?></div>
						<?php
						unset($_SESSION['error']);
					}

					if(isset($_SESSION['success'])){
						?>
						<div class="alert alert-success"><?= $_SESSION['success'] ?></div>
						<?php
						unset($_SESSION['success']);
					}
					?>

					<form class="form-horizontal" method="post" action="proses/p_profil.php" onsubmit="return checkPassword()">
						<div class="form-group">
							<label class="control-label col-lg-4">Password Lama</label>
							<div class="col-lg-8">
								<input type="text" name="old_password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Password Baru</label>
							<div class="col-lg-8">
								<input type="text" name="new_password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Konfirmasi Password</label>
							<div class="col-lg-8">
								<input type="text" name="confirm_new_password" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								<input type="hidden" name="ubah_sandi" value="1">
								<button class="btn btn-primary" type="submit">Ubah Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#nama').editable({mode: 'inline'});
	$('#nama_pendek').editable({mode: 'inline'});
	$('#email').editable({mode: 'inline'});

	function checkPassword(){
		var newpass = $('[name=new_password]').val();
		var newpasscon = $('[name=confirm_new_password]').val();

		if(newpass != newpasscon){
			alert('Konfirmasi Password Baru tidak cocok!');
			return false;
		}
		else
			return true;
	}
</script>