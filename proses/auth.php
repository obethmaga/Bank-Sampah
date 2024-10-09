<?php 
define('basepath', __DIR__);
require '../config.php';

$db->where('email', $_POST['email']);
$db->where('password', md5($_POST['password']));

$result = $db->get('admin');

if(!$result){
	$_SESSION['login_message'] = 'Login Gagal. Email atau Password tidak valid.';
	header('location: ../login.php');
}else{
	$admin = $result[0];

	$data = [
		'logged'      => time(),
		'id'          => $admin['id'],
		'nama'        => $admin['nama'],
		'nama_pendek' => $admin['nama_pendek'],
		'email'       => $admin['email'],
		'level'       => $admin['level']
	];

	$_SESSION['user'] = $data;

	header('location: ../index.php');
}
