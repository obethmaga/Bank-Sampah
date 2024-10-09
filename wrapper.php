<?php
if(!defined('required'))
	die('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIP UKM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/libs/Ionicons/css/ionicons.min.css">
  <!-- DataTable -->
  <link rel="stylesheet" href="assets/libs/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="assets/libs/datatables/responsive.bootstrap.css">
  <!-- Editable -->
  <link rel="stylesheet" href="assets/libs/editable/css/bootstrap-editable.css">
  <!-- Dropify -->
  <link rel="stylesheet" href="assets/libs/dropify/css/dropify.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="assets/libs/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="assets/dist/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 3 -->
  <script src="assets/libs/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="assets/libs/bootstrap/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="assets/libs/jquery.slimscroll.js"></script>
  <!-- DataTables -->
  <script src="assets/libs/datatables/dataTables.js"></script>
  <script src="assets/libs/datatables/dataTables.bootstrap.js"></script>
  <script src="assets/libs/datatables/dataTables.responsive.js"></script>
  <script src="assets/libs/datatables/responsive.bootstrap.js"></script>
  <!-- Editable -->
  <script src="assets/libs/editable/js/bootstrap-editable.js"></script>
  <!-- FastClick -->
  <script src="assets/libs/fastclick.js"></script>
  <!-- Dropify -->
  <script src="assets/libs/dropify/js/dropify.js"></script>
  <!-- Bootstrap Validator -->
  <script src="assets/libs/validator.js"></script>
  <!-- Select2 -->
  <script src="assets/libs/select2/select2.min.js"></script>
  <!-- ChartJs -->
  <script src="assets/libs/chartjs/chart.umd.js"></script>
  <!-- <script src="assets/libs/chartjs/helpers.js"></script> -->

  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
  <script src="assets/libs/axios.min.js"></script>

  <?php 
  $mapboxpage = array('usaha', 'pemetaan');

  if(in_array($page, $mapboxpage)): 
  ?>
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>
  <?php endif; ?>

  <style type="text/css"> 
    .dt-paging nav .pagination {
      margin: 0;
    }
    .dt-info {
      margin: 10px 0;
    }

    .mapboxgl-popup {
      padding-bottom: 50px;
    }

    .mapboxgl-popup-close-button {
      display: none;
    }

    .mapboxgl-popup-content {
      font:
        400 15px/22px 'Source Sans Pro',
        'Helvetica Neue',
        sans-serif;
      padding: 0;
      width: 180px;
      box-shadow: 0 1px 1px rgba(0,0,0,.10);
    }

    .mapboxgl-popup-content h4 {
      background: #1A56B0;
      color: #fff;
      margin: 0;
      padding: 10px;
      border-radius: 3px 3px 0 0;
      font-weight: 700;
      margin-top: -15px;
    }

    .mapboxgl-popup-content p {
      margin: 0;
      padding: 10px;
      font-weight: 400;
    }

    .mapboxgl-popup-content div {
      padding: 10px;
    }

    .mapboxgl-popup-anchor-top > .mapboxgl-popup-content {
      margin-top: 15px;
    }

    .mapboxgl-popup-anchor-top > .mapboxgl-popup-tip {
/*      border-bottom-color: #91c949;*/
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">

  <?php include 'components/topbar.php'; ?>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php include 'components/sidebar.php'; ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'pages/loader.php' ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
