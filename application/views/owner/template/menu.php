
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

        <li <?php if($this->uri->segment(1) == "produksi"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-cogs"></i>
            <span>Kelola Produksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "kain"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/kain');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "kain"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Data Kain</a></li>
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "pemotong"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/pemotong');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "pemotong"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Data Pemotong</a></li>
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "penjahit"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/penjahit');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "penjahit"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Data Penjahit</a></li>
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "produksi"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/produksi');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "produksi"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Buat Produksi Baru</a></li>
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "daftar-produksi"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/daftar-produksi');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "daftar-produksi"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Daftar Produksi</a></li>
            <li <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "laporan-produksi"){echo"class='active'";} ?>><a href="<?php echo base_url('produksi/laporan-produksi');?>"><i class="fa <?php if($this->uri->segment(1) == "produksi"  && $this->uri->segment(2) == "laporan-produksi"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Laporan Laba Produksi</a></li>
          </ul>
        </li>
        
        <li <?php if($this->uri->segment(1) == "pembelian"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-arrow-down"></i>
            <span>Kelola Pembelian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1) == "pembelian" && $this->uri->segment(2) == "toko"){echo"class='active'";} ?>><a href="<?php echo base_url('pembelian/toko');?>"><i class="fa <?php if($this->uri->segment(1) == "pembelian"  && $this->uri->segment(2) == "toko"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Toko</a></li>
            <li <?php if($this->uri->segment(1) == "pembelian" && $this->uri->segment(2) == "pembelian"){echo"class='active'";} ?>><a href="<?php echo base_url('pembelian/pembelian');?>"><i class="fa <?php if($this->uri->segment(1) == "pembelian"  && $this->uri->segment(2) == "pembelian"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Transaksi Pembelian</a></li>
            <li <?php if($this->uri->segment(1) == "pembelian" && $this->uri->segment(2) == "laporan-pembelian"){echo"class='active'";} ?>><a href="<?php echo base_url('pembelian/laporan-pembelian');?>"><i class="fa <?php if($this->uri->segment(1) == "pembelian"  && $this->uri->segment(2) == "laporan-pembelian"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Laporan Pembelian</a></li>
          </ul>
        </li>

        <li <?php if($this->uri->segment(1) == "barang"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-cube"></i>
            <span>Kelola Data Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1) == "barang" && $this->uri->segment(2) == "barang"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/barang');?>"><i class="fa <?php if($this->uri->segment(1) == "barang"  && $this->uri->segment(2) == "barang"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Data Barang</a></li>
            <li <?php if($this->uri->segment(1) == "barang" && $this->uri->segment(2) == "barang-masuk"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/barang-masuk');?>"><i class="fa <?php if($this->uri->segment(1) == "barang"  && $this->uri->segment(2) == "barang-masuk"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Daftar Barang Masuk</a></li>
            <li <?php if($this->uri->segment(1) == "barang" && $this->uri->segment(2) == "barang-keluar"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/barang-keluar');?>"><i class="fa <?php if($this->uri->segment(1) == "barang"  && $this->uri->segment(2) == "barang-keluar"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Daftar Barang Keluar</a></li>
            <li <?php if($this->uri->segment(1) == "barang" && $this->uri->segment(2) == "stok-barang"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/stok-barang');?>"><i class="fa <?php if($this->uri->segment(1) == "barang"  && $this->uri->segment(2) == "stok-barang"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Stok Barang</a></li>
            <li <?php if($this->uri->segment(1) == "barang" && $this->uri->segment(2) == "laporan-stok"){echo"class='active'";} ?>><a href="<?php echo base_url('barang/laporan-stok');?>"><i class="fa <?php if($this->uri->segment(1) == "barang"  && $this->uri->segment(2) == "laporan-stok"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Laporan Stok</a></li>
          </ul>
        </li>

        <li <?php if($this->uri->segment(1) == "penjualan"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Kelola Penjualan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1) == "penjualan" && $this->uri->segment(2) == "pelanggan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/pelanggan');?>"><i class="fa <?php if($this->uri->segment(1) == "penjualan"  && $this->uri->segment(2) == "pelanggan"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Pelanggan</a></li>
            <li <?php if($this->uri->segment(1) == "penjualan" && $this->uri->segment(2) == "penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/penjualan');?>"><i class="fa <?php if($this->uri->segment(1) == "penjualan"  && $this->uri->segment(2) == "penjualan"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Buat Penjualan Baru</a></li>
            <li <?php if($this->uri->segment(1) == "penjualan" && $this->uri->segment(2) == "daftar-penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/daftar-penjualan');?>"><i class="fa <?php if($this->uri->segment(1) == "penjualan"  && $this->uri->segment(2) == "daftar-penjualan"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Daftar Penjualan</a></li>
            <li <?php if($this->uri->segment(1) == "penjualan" && $this->uri->segment(2) == "laporan-penjualan"){echo"class='active'";} ?>><a href="<?php echo base_url('penjualan/laporan-penjualan');?>"><i class="fa <?php if($this->uri->segment(1) == "penjualan"  && $this->uri->segment(2) == "laporan-penjualan"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Laporan Penjualan</a></li>
          </ul>
        </li>

        
        
        <li <?php if($this->uri->segment(1) == "akun"){echo "class='active treeview'";} else{echo "class='treeview'";}?>>
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Akun</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1) == "akun" && $this->uri->segment(2) == "ganti-password"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/ganti-password');?>"><i class="fa <?php if($this->uri->segment(1) == "akun"  && $this->uri->segment(2) == "ganti-password"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Ganti Password</a></li>
            <li <?php if($this->uri->segment(1) == "akun" && $this->uri->segment(2) == "tentang-software"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/tentang-software');?>"><i class="fa <?php if($this->uri->segment(1) == "akun"  && $this->uri->segment(2) == "tentang-software"){echo"fa-circle";}else{echo"fa-circle-o";} ?>"></i> Tentang Software</a></li>
            <li <?php if($this->uri->segment(1) == "akun" && $this->uri->segment(2) == "logout"){echo"class='active'";} ?>><a href="<?php echo base_url('akun/logout');?>"><i class="fa fa-circle-o"></i> Logout</a></li>
          </ul>
        </li>
        <!--Menu Utama-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">