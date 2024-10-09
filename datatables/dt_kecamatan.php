<?php 
!defined('basepath') ? die('no direct access allowed') : true;

$table = 'kecamatan';
$col = [
	'id_kecamatan',
	'nama_kecamatan'
];

$total_data = count($db->get($table));

$query = "SELECT * FROM kecamatan";

if(!empty($request['search']['value'])){
	$search = $request['search']['value'];
	$query .= " WHERE nama_kecamatan LIKE '$search%'";
}

$total_filter = count($db->rawQuery($query));

$query .= " ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']." LIMIT ".$request['start'].",".$request['length']." ";

$results = $db->rawQuery($query);

$data = [];

$no = 1;
foreach($results as $row){
	$subdata = [];
	$subdata['no'] = $no;
	$subdata['id_kecamatan'] = $row['id_kecamatan'];
	$subdata['nama_kecamatan'] = $row['nama_kecamatan'];
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