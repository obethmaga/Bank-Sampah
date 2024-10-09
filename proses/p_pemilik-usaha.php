<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

$post = $_REQUEST;

if(isset($post['id_pemilik'])){
	$data['id_kecamatan'] = $post['id_kecamatan'];
	$data['id_kelurahan'] = $post['id_kelurahan'];
	$data['no_ktp']        = $post['no_ktp'];
	$data['nama']          = $post['nama'];
	$data['jenis_kelamin'] = $post['jenis_kelamin'];
	$data['tempat_lahir']  = $post['tempat_lahir'];
	$data['tanggal_lahir'] = $post['tanggal_lahir'];
	$data['agama']         = $post['agama'];
	$data['email']         = $post['email'];
	$data['telepon']       = $post['telepon'];
	$data['alamat']        = $post['alamat'];

	if($post['id_pemilik'] == '0'){
		$db->insert('pemilik_usaha', $data);
	}else{
		$db->where('id_pemilik', $post['id_pemilik']);
		$db->update('pemilik_usaha', $data);
	}

	header('location:../index.php?page=pemilik-usaha');
}

if(isset($post['delete'])){
	$db->where('id_pemilik', $post['delete']);
	$db->delete('pemilik_usaha');

	header('location:../index.php?page=pemilik-usaha');
}
