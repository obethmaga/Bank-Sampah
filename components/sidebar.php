<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="sidebar-header" style="color: white; padding: 10px 20px">
        <h4 style="margin: 0;">DISKOPNAKERTRANS</h4>
        <p style="margin: 0">PROVINSI NTT</p>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGASI UTAMA</li>
        <li>
          <a href="index.php">
            <i class="fas fa-fw fa-home mr-1"></i>
            <span>Beranda</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=pemetaan">
            <i class="fas fa-map-signs fa-fw mr-1"></i>
            <span>Pemetaan</span>
          </a>
        </li>
        <?php if($_SESSION['user']['level'] == 'superadmin'): ?>
          <li class="treeview">
            <a href="">
              <i class="fas fa-fw fa-database mr-1"></i>
              <span>Master Data</span>
              <span class="pull-right-container">
                <i class="fas fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="index.php?page=kecamatan"><i class="far fa-circle mr-1"></i> Data Kecamatan</a></li>
              <li><a href="index.php?page=kelurahan"><i class="far fa-circle mr-1"></i> Data Kelurahan</a></li>
              <li><a href="index.php?page=jenis-usaha"><i class="far fa-circle mr-1"></i> Data Jenis Usaha</a></li>
            </ul>
          </li>
        <?php endif; ?>
        <li>
          <a href="index.php?page=pemilik-usaha">
            <i class="fas fa-fw fa-users mr-1"></i>
            <span>Pemilik Usaha</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=usaha">
            <i class="fas fa-fw fa-store mr-1"></i>
            <span>Usaha</span>
          </a>
        </li>
        <?php if($_SESSION['user']['level'] == 'superadmin'): ?>
          <li>
            <a href="index.php?page=user">
            <i class="fas fa-fw fa-user mr-1"></i>
            <span>Pengguna</span>
          </a>
          </li>
        <?php endif; ?>
        <li>
          <a href="logout.php" onclick="return confirm('Anda yakin ingin keluar?')">
            <i class="fas fa-fw fa-sign-out mr-1"></i>
            <span>Keluar</span>
          </a>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>