<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

$post = $_REQUEST;

if(isset($post['pk'])){
	$data[$post['name']] = $post['value'];

	$db->where('id', $post['pk']);
	$db->update('admin', $data);
}

if(isset($post['ubah_sandi'])){
	if(!empty($post['old_password']) && !empty($post['new_password'])){
		$id_user = $_SESSION['user']['id'];
		$user = $db->where('id', $id_user)->get('admin')[0];

		if($user['password'] != md5($post['old_password'])){
			$_SESSION['error'] = 'Password lama anda sandi. Silahkan coba lagi';
		}else{
			$data['password'] = md5($post['new_password']);
			$db->where('id', $id_user);
			$db->update('admin', $data);

			$_SESSION['success'] = 'Password anda berhasil diubah.';
		}
	}else{
		$_SESSION['error'] = 'Mohon isi kolom yang ada!';
	}
	header('location: ../index.php?page=profil');
}