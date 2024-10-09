<?php 
!defined('basepath') ? die('no direct access allowed') : true;

$table = 'pemilik_usaha';
$col = [
	null,
	'nama',
	'no_ktp',
	'tempat_lahir',
	'email',
	'telepon',
	'alamat',
	'nama_kecamatan',
	'nama_kelurahan',
	null,
	null
];

$total_data = count($db->get($table));

$query = "SELECT * FROM $table pu LEFT JOIN kecamatan kc ON pu.id_kecamatan=kc.id_kecamatan LEFT JOIN kelurahan kl ON pu.id_kelurahan=kl.id_kelurahan";

if(!empty($request['search']['value'])){
	$search = $request['search']['value'];
	$query .= " WHERE nama LIKE '$search%'";
	$query .= " OR tempat_lahir LIKE '$search%'";
	$query .= " OR email LIKE '$search%'";
	$query .= " OR telepon LIKE '$search%'";
	$query .= " OR alamat LIKE '$search%'";
	$query .= " OR nama_kecamatan LIKE '$search%'";
	$query .= " OR nama_kelurahan LIKE '$search%'";
}

$total_filter = count($db->rawQuery($query));

$query .= " ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']." LIMIT ".$request['start'].",".$request['length']." ";

$results = $db->rawQuery($query);

$data = [];

$no = 1;
foreach($results as $row){
	$subdata                  = [];
	$subdata['no']            = $no;
	$subdata['id_pemilik']    = $row['id_pemilik'];
	$subdata['no_ktp']        = $row['no_ktp'];
	$subdata['nama']          = $row['nama'];
	$subdata['jenis_kelamin'] = $row['jenis_kelamin'];
	$subdata['tempat_lahir']  = $row['tempat_lahir'];
	$subdata['tanggal_lahir'] = $row['tanggal_lahir'];
	$subdata['email']         = $row['email'];
	$subdata['telepon']       = $row['telepon'];
	$subdata['alamat']        = $row['alamat'];
	$subdata['nama_kecamatan'] = $row['nama_kecamatan'];
	$subdata['nama_kelurahan'] = $row['nama_kelurahan'];

	// // hitung jumlah usaha
	$subdata['ukm'] = count($db->rawQuery("SELECT * FROM usaha WHERE id_pemilik=$row[id_pemilik]"));

	$data[]                   = $subdata;
	$no++;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($total_data),
    "recordsFiltered"   =>  intval($total_filter),
    "data"              =>  $data
);

echo json_encode($json_data);