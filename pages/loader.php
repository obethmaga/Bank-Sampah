<?php
if(!defined('required'))
	die('No direct script access allowed');

/**
 * $page, $level cek di file config.php;
 * 
 **/

else if($page == 'home')
	include 'home.php';

else if($page == 'pemetaan')
	include 'pemetaan.php';

else if($page == 'kecamatan')
	include 'kecamatan.php';

else if($page == 'kelurahan')
	include 'kelurahan.php';

else if($page == 'jenis-usaha')
	include 'jenis-usaha.php';

else if($page == 'pemilik-usaha')
	include 'pemilik-usaha.php';
else if($page == 'usaha')
	include 'usaha.php';

else if($page == 'profil')
	include 'profil.php';

else if($page == 'user'){
	if($level == 'superadmin') include 'user.php';
	else include '500.php';
}
else include '404.php';