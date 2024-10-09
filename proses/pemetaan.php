<?php
define('basepath', __DIR__);

require '../config.php';
cekLogin();

$req = $_REQUEST;

$query = "SELECT id_usaha, no_ijin, nama_usaha, nama, nama_jenis, tgl_operasi, aset, modal, tenaga_kerja, u.alamat, lat, lng, foto, ikon, legalitas FROM usaha u LEFT JOIN pemilik_usaha pu ON pu.id_pemilik = u.id_pemilik LEFT JOIN jenis_usaha ju ON ju.id_jenis = u.id_jenis";

if(isset($req['j'])){
	if(!str_contains($query, "WHERE"))
		$query .= " WHERE u.id_jenis = $req[j] ";
	else
		$query .= " AND u.id_jenis = $req[j] ";
}

if(isset($req['l'])){
	if(!str_contains($query, "WHERE"))
		$query .= " WHERE u.legalitas = '$req[l]' ";
	else
		$query .= " AND u.legalitas = '$req[l]' ";
}

if(!empty($req['q'])){
	$q = $req['q'];
	$query_condition = "no_ijin LIKE '$q%' "
		."OR nama LIKE '$q%'"
		."OR nama_usaha LIKE '$q%' "
		."OR nama LIKE '$q%' "
		."OR nama_jenis LIKE '$q%' "
		."OR u.alamat LIKE '$q%'";

	if(isset($req['j']) || isset($req['l']) )
		$query .= " AND (".$query_condition.")";
	else 
		$query .= " WHERE ".$query_condition;
}

// echo $query;
	
// // die();
$usaha = $db->rawQuery($query);

$data = [];
foreach($usaha as $row){
	$item = [];
	$item['type'] = 'Feature';
	$item['geometry'] = ['type' => 'Point', 'coordinates' => [$row['lng'], $row['lat']]];
	$item['properties'] = [
		'id'           => $row['id_usaha'],
		'pemilik'      => $row['nama'],
		'no_ijin'      => $row['no_ijin'],
		'nama_usaha'   => $row['nama_usaha'],
		'nama_jenis'   => $row['nama_jenis'],
		'tgl_operasi'  => $row['tgl_operasi'],
		'legalitas'    => $row['legalitas'] == '0' ? 'tidak' : 'Ya',
		'aset'         => $row['aset'],
		'modal'        => $row['modal'],
		'tenaga_kerja' => $row['tenaga_kerja'],
		'alamat'       => $row['alamat'],
		'foto'         => 'uploads/' . $row['foto'],
		'ikon'         => 'assets/icon/marker/'.$row['ikon']
	];
	$data[] = $item;
}

$response = [
	'type' => 'FeatureCollection',
	'features' => $data
];

echo json_encode($response);