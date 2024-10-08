<?php 
!defined('basepath') ? die('no direct access allowed') : true;

session_start();

// session check function
function cekLogin(){
	if(!isset($_SESSION['user'])){
		header('location: login.php');
	}
}

// Database Setting
include_once 'lib/MysqliDb.php';

// $db_config = [
// 	'host' => 'localhost',
// 	'username' => 'root',
// 	'password' => '',
// 	'db' => 'spukm',
// 	'port' => 3306,
// 	'charset' => 'utf8'
// ];

$db_config = [
    'host' => 'mysql-banksampah-obethpamokol-c67c.i.aivencloud.com',
    'username' => 'avnadmin',
    'password' => 'AVNS_59D_waRMYZoCawTaLBQ',
    'db' => 'banksampah',
    'port' => 22169,
    'charset' => 'utf8'
];

$db = new MysqliDb($db_config);

$level = $_SESSION['user']['level'];

// Page Param Setting
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

define('required', 'index.php');

define('MAPBOX_TOKEN', 'pk.eyJ1Ijoia2lsb3NjcmlwdCIsImEiOiJjbTE0ZW4zM3cxbG94MnlxeTF4cmVxZ3puIn0.4arHKDYuKEAQcG_AfnhqXw');

if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            
            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), -1, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];
            
            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';
        
        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }
        
        return $base_url;
    }
}

function randomColor($opacity = "0.3"){
    $rand1 = rand(0, 255);
    $rand2 = rand(0, 255);
    $rand3 = rand(0, 255);
    return "rgba(".$rand1.",".$rand2.",".$rand3.", $opacity)";
}
