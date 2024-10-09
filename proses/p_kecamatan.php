<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

$post = $_REQUEST;

if(isset($post['nama_kecamatan']))
{
	$data['nama_kecamatan'] = $post['nama_kecamatan'];

	if($post['id_kecamatan'] == 0){
		$db->insert('kecamatan', $data);
	}else{
		$db->where('id_kecamatan', $post['id_kecamatan']);
		$db->update('kecamatan', $data);
	}

	header('location:../index.php?page=kecamatan');
}

if(isset($post['delete'])){
	$db->where('id_kecamatan', $post['delete']);
	$db->delete('kecamatan');

	header('location:../index.php?page=kecamatan');
}