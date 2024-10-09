<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

$post = $_REQUEST;

if(isset($post['nama_kelurahan']))
{
	$data['nama_kelurahan'] = $post['nama_kelurahan'];
	$data['id_kecamatan'] = $post['id_kecamatan'];

	if($post['id_kelurahan'] == 0){
		$db->insert('kelurahan', $data);
	}else{
		$db->where('id_kelurahan', $post['id_kelurahan']);
		$db->update('kelurahan', $data);
	}

	header('location:../index.php?page=kelurahan');
}

if(isset($post['delete'])){
	$db->where('id_kelurahan', $post['delete']);
	$db->delete('kelurahan');

	header('location:../index.php?page=kelurahan');
}