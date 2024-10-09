<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();


$post = $_REQUEST;

if(isset($post['nama_jenis']))
{
	$data['nama_jenis'] = $post['nama_jenis'];
	$data['sektor'] = $post['sektor'];
	$data['ikon'] = $post['ikon'];

	if($post['id_jenis'] == 0){
		$db->insert('jenis_usaha', $data);
	}else{
		$db->where('id_jenis', $post['id_jenis']);
		$db->update('jenis_usaha', $data);
	}

	header('location:../index.php?page=jenis-usaha');
}

if(isset($post['delete'])){
	$db->where('id_jenis', $post['delete']);
	$db->delete('jenis_usaha');

	header('location:../index.php?page=jenis-usaha');
}