<header class="main-header">
  <!-- Logo -->
  <a href="index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">UKM</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>SIP</b>UKM</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav"> 
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="assets/dist/img/user.png" class="user-image" alt="User Image">
            <span class="hidden-xs"><?= ucwords($_SESSION['user']['nama_pendek']) ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="assets/dist/img/user.png" class="img-circle" alt="User Image">

              <p>
                <?= $_SESSION['user']['nama'] ?> - Superadmin
                <small>Sistem Informasi Pemetaan UKM</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="index.php?page=profil" class="btn btn-default btn-flat"><i class="fas fa-user"></i>&nbsp;&nbsp;Profil</a>
              </div>
              <div class="pull-right">
                <a href="logout.php" class="btn btn-default btn-flat">Keluar &nbsp;&nbsp;<i class="fas fa-sign-out"></i></a>
              </div>
            </li>
          </ul>
        </li> 
      </ul>
    </div>
  </nav>
</header>