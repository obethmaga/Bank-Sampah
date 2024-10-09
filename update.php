<?php 

include_once 'config.php';

$query = "ALTER TABLE pemilik_usaha 
	ADD COLUMN id_kecamatan int(11) NOT NULL id_pemilik, 
	ADD COLUMN id_kelurahan int(11) NOT NULL id_kecamatan";
	
$db->rawQuery($query);
echo "Database update successfully. Redirect to homepage after 3 seconds.";
echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>";