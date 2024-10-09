<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

if($level != 'superadmin')
	die('No access for admin level.');

$post = $_REQUEST;

if(isset($post['nama']))
{
	$data['nama']        = $post['nama'];
	$data['nama_pendek'] = $post['nama_pendek'];
	$data['email']       = $post['email'];
	if(!empty($post['password']))
		$data['password']    = md5($post['password']);
	$data['level']       = 'admin';


	if($post['id'] == 0){
		$db->insert('admin', $data);
	}else{
		$db->where('id', $post['id']);
		$db->update('admin', $data);
	}

	header('location:../index.php?page=user');
}

if(isset($post['delete'])){
	$db->where('id', $post['delete']);
	$db->delete('admin');

	header('location:../index.php?page=user');
}