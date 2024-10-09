<?php 
!defined('basepath') ? die('no direct access allowed') : true;

$table = 'jenis_usaha';
$col = [
	null,
	'nama_jenis',
	'sector',
	'ikon',
	null
];

$total_data = count($db->get($table));

$query = "SELECT * FROM $table";

if(!empty($request['search']['value'])){
	$search = $request['search']['value'];
	$query .= " WHERE nama_jenis LIKE '$search%'";
	$query .= " OR sektor LIKE '$search%'";
}

$total_filter = count($db->rawQuery($query));

$query .= " ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']." LIMIT ".$request['start'].",".$request['length']." ";

$results = $db->rawQuery($query);

$data = [];

$no = 1;
foreach($results as $row){
	$subdata = [];
	$subdata['no'] = $no;
	$subdata['id_jenis'] = $row['id_jenis'];
	$subdata['nama_jenis'] = $row['nama_jenis'];
	$subdata['sektor'] = $row['sektor'];
	$subdata['ikon'] = $row['ikon'];
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