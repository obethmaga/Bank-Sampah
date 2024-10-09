<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();


$post = $_REQUEST;

if(isset($post['usaha'])){ 
	$data['id_jenis'] = $post['id_jenis'];
	$data['id_pemilik'] = $post['id_pemilik'];
	$data['id_kelurahan'] = $post['id_kelurahan'];
	$data['nama_usaha'] = $post['nama_usaha'];
	$data['no_ijin'] = $post['no_ijin'];
	$data['aset'] = $post['aset'];
	$data['modal'] = $post['modal'];
	$data['tenaga_kerja'] = $post['tenaga_kerja'];
	$data['lat'] = $post['lat'];
	$data['lng'] = $post['lng'];
	$data['alamat'] = $post['alamat'];
	$data['tgl_operasi'] = $post['tgl_operasi'];
	$data['legalitas'] = $post['legalitas'];

	if(!empty($_FILES['foto'])){
		$path = "../uploads/";
		$tempname = $_FILES['foto']['tmp_name'];
		$extension = pathinfo($_FILES['foto']['name'])['extension'];
		$filename = time()."_".uniqid().".".$extension;
		if(move_uploaded_file($tempname, $path.$filename)){
			$data['foto'] = $filename;
		}
	}

	if($post['id_usaha'] == 0){
		$db->insert('usaha', $data);
	}else{
		$db->where('id_usaha', $post['id_usaha']);
		$db->update('usaha', $data);
	}

	header('location: ../index.php?page=usaha');
}

if(isset($post['delete'])){
	$db->where('id_usaha', $post['delete']);
	$db->delete('usaha');

	header('location: ../index.php?page=usaha');
}