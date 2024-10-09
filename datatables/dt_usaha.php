<?php 
!defined('basepath') ? die('no direct access allowed') : true;

$table = 'usaha';
$col = [
	null,
	'nama_usaha',
	'no_ijin',
	'nama_pemilik',
	'nama_jenis',
	'legalitas',
	'tgl_operasi',
	'aset',
	'modal',
	'tenaga_kerja',
	'nama_kelurahan',
	'alamat',
	null
];

$total_data = count($db->get($table));

$query = "SELECT id_usaha, nama_usaha, no_ijin, pemilik_usaha.nama as nama_pemilik, nama_jenis, legalitas, tgl_operasi, aset, modal, tenaga_kerja, nama_kelurahan, usaha.alamat FROM usaha LEFT JOIN pemilik_usaha ON usaha.id_pemilik = pemilik_usaha.id_pemilik LEFT JOIN kelurahan on kelurahan.id_kelurahan = usaha.id_kelurahan LEFT JOIN jenis_usaha ON jenis_usaha.id_jenis = usaha.id_jenis";

if(!empty($request['search']['value'])){
	$search = $request['search']['value'];
	$query .= " WHERE nama_usaha LIKE '$search%'";
	$query .= " OR no_ijin LIKE '$search%'";
	$query .= " OR nama LIKE '$search%'";
	$query .= " OR legalitas LIKE '$search%'";
	$query .= " OR aset LIKE '$search%'";
	$query .= " OR modal LIKE '$search%'";
	$query .= " OR nama_kelurahan LIKE '$search%'";
	$query .= " OR alamat LIKE '$search%'";
}

$total_filter = count($db->rawQuery($query));

$query .= " ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']." LIMIT ".$request['start'].",".$request['length']." ";

$results = $db->rawQuery($query);

$data = [];

$no = 1;
foreach($results as $row){
	$subdata = [];
	$subdata['no'] = $no;
	$subdata['id_usaha'] = $row['id_usaha'];
	$subdata['nama_usaha'] = $row['nama_usaha'];
	$subdata['no_ijin'] = $row['no_ijin'];
	$subdata['nama_pemilik'] = $row['nama_pemilik'];
	$subdata['nama_jenis'] = $row['nama_jenis'];
	$subdata['legalitas'] = $row['legalitas'];
	$subdata['tgl_operasi'] = $row['tgl_operasi'];
	$subdata['aset'] = $row['aset'];
	$subdata['modal'] = $row['modal'];
	$subdata['tenaga_kerja'] = $row['tenaga_kerja'];
	$subdata['nama_kelurahan'] = $row['nama_kelurahan'];
	$subdata['alamat'] = $row['alamat'];

	$data[] = $subdata;
	$no++;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($total_data),
    "recordsFiltered"   =>  intval($total_filter),
    "data"              =>  $data
);

echo json_encode($json_data);