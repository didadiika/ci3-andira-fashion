<?php
$link_home = str_replace("http://","",base_url());
$link_href = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$fullmenu = str_replace($link_home,"", $link_href);
$jumlah = explode("/",$fullmenu);

if(count($jumlah) > 1)
{
  list($menu,$submenu) = explode("/",$fullmenu);
}
else
{
  $menu = $fullmenu;
  $submenu = "";
}


?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url("assets/dist/img/kasir.jpg");?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Owner</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA</li>
        <!--Menu Utama-->

        <li <?php if($menu == "produksi"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-cogs"></i>
            <span>Kelola Produksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "produksi" && $submenu == "laporan_produksi"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/laporan_produksi');?>"><i class="fa fa-circle-o"></i> Laporan Produksi</a></li>
          </ul>
        </li>
        
        <li <?php if($menu == "pembelian"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-arrow-down"></i>
            <span>Kelola Pembelian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "pembelian" && $submenu == "laporan_pembelian"){echo"class='active'";} ?>><a href="<?php echo base_url('pembelian/laporan_pembelian');?>"><i class="fa fa-circle-o"></i> Laporan Pembelian</a></li>
          </ul>
        </li>

        <li <?php if($menu == "barang"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-cube"></i>
            <span>Kelola Data Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "barang" && $submenu == "stok_barang"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/stok_barang');?>"><i class="fa fa-circle-o"></i> Stok Barang</a></li>
            <li <?php if($menu == "barang" && $submenu == "laporan_stok"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/laporan_stok');?>"><i class="fa fa-circle-o"></i> Laporan Stok</a></li>
          </ul>
        </li>

        <li <?php if($menu == "penjualan"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Kelola Penjualan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "penjualan" && $submenu == "daftar_penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/daftar_penjualan');?>"><i class="fa fa-circle-o"></i> Daftar Penjualan</a></li>
            <li <?php if($menu == "penjualan" && $submenu == "laporan_penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/laporan_penjualan');?>"><i class="fa fa-circle-o"></i> Laporan Penjualan</a></li>
          </ul>
        </li>

        

        <!--
          <li <?php if($menu == "laporan"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "laporan" && $submenu == "laporan_persediaan"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/laporan_persediaan');?>" ><i class="fa fa-circle-o"></i> Laporan Persediaan</a></li>
            <li <?php if($menu == "laporan" && $submenu == "laporan_jurnal"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/laporan_jurnal');?>"><i class="fa fa-circle-o"></i> Laporan Jurnal</a></li>
            <li <?php if($menu == "laporan" && $submenu == "buku_besar"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/buku_besar');?>"><i class="fa fa-circle-o"></i> Buku Besar</a></li>
            <li <?php if($menu == "laporan" && $submenu == "laba_rugi"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/laba_rugi');?>"><i class="fa fa-circle-o"></i> Laba Rugi</a></li>
            <li <?php if($menu == "laporan" && $submenu == "neraca"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/neraca');?>"><i class="fa fa-circle-o"></i> Neraca</a></li>
            <li <?php if($menu == "laporan" && $submenu == "penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/penjualan');?>"><i class="fa fa-circle-o"></i> Lap. Penjualan</a></li>
            <li <?php if($menu == "laporan" && $submenu == "shu_pelanggan"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/shu_pelanggan');?>"><i class="fa fa-circle-o"></i> Lap. SHU Pelanggan</a></li>
            <li <?php if($menu == "laporan" && $submenu == "tagihan_angsuran"){echo"class='active'";} ?>><a href="<?php echo base_url('laporan/tagihan_angsuran');?>"><i class="fa fa-circle-o"></i> Lap. Tagihan Angsuran</a></li>
          </ul>
        </li>
      -->
        
        <li <?php if($menu == "akun"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Akun</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == "akun" && $submenu == "data_user"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/data_user');?>"><i class="fa fa-circle-o"></i> Data User</a></li>
            <li <?php if($menu == "akun" && $submenu == "tentang_software"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/tentang_software');?>"><i class="fa fa-circle-o"></i> Tentang Software</a></li>
            <li <?php if($menu == "akun" && $submenu == "logout"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/logout');?>"><i class="fa fa-circle-o"></i> Logout</a></li>
          </ul>
        </li>
        <!--Menu Utama-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">