<?php 

define('basepath', __DIR__);

require 'config.php';
cekLogin();

$request = $_REQUEST;
$fetch = $request['fetch'];

if($fetch == 'kecamatan')
	include 'datatables/dt_kecamatan.php';

if($fetch == 'kelurahan')
	include 'datatables/dt_kelurahan.php';

if($fetch == 'jenis-usaha')
	include 'datatables/dt_jenis-usaha.php';

if($fetch == 'pemilik-usaha')
	include 'datatables/dt_pemilik-usaha.php';

if($fetch == 'usaha')
	include 'datatables/dt_usaha.php';