<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Penjualan extends CI_Controller{

	function __construct(){
		parent::__construct();

		$cek_login = $this->session->userdata('authenticated');
        if ($cek_login != true) {
			redirect( base_url('login') );
        }

	}

	
	function index(){
		
        	/*
			*	Menampilkan view master template dan halaman beranda
			*
			*/
            $level = $this->session->level;
            if($level == "Programmer")
            {
				$this->load->view("programmer/template/header.php");
                $this->load->view("programmer/template/menu.php");

            } else if($level == "Owner"){
				$this->load->view("owner/template/header.php");
                $this->load->view("owner/template/menu.php");
            } else if($level == "Admin"){
				$this->load->view("admin/template/header.php");
                $this->load->view("admin/template/menu.php");
            }
        	$this->load->view("admin/beranda.php");
        	$this->load->view("admin/template/footer.php");
        	/*
			*	Menampilkan view master template dan halaman beranda
			*
			*/
    }


    function pelanggan(){
        
       
		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/pelanggan.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function pelanggan_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("pelanggan_model");
		$pelanggan = $this->pelanggan_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($pelanggan as $r){
		    $sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = $r->no;
			$sub_array[] = $r->nama;
			$sub_array[] = $r->alamat;
			$sub_array[] = $r->kota;
            $sub_array[] = $r->no_hp;
            $sub_array[] = '<a class="btn btn-default" href="'. base_url('penjualan/pelanggan/edit/'.$this->enkripsi_url->encode($r->id_plg)).'" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="javascript:;" class="btn btn-danger item_hapus" nama-pelanggan="'.$r->nama.'" data="'.$r->id_plg.'"><i class="fa fa-trash-o"></i></a>';
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->pelanggan_model->get_all_data(),
				"recordsFiltered" 	=> $this->pelanggan_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}


    function pelanggan_input(){
        $this->load->model("penjualan_model");
        $data["provinsi"] = $this->penjualan_model->tampil_data_provinsi();

        #Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/pelanggan-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function tampil_kota(){
        $id_provinsi = $this->input->post("id_provinsi");
        $this->load->model("pelanggan_model");
        $kota = $this->pelanggan_model->tampil_kota($id_provinsi);
        if($kota->num_rows() > 0)
        {
            echo "<option value=''>Pilih*</option>";
            foreach($kota->result() as $r){
                echo "<option value='$r->id_kota'>$r->kota</option>";
            }
        }
        else
        {
            echo "<option value=''>Pilih*</option>";
        }
    }


    function pelanggan_simpan(){
        $this->load->model("pelanggan_model");
        $kode = $this->input->post("kode");
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat"); 
        $id_kota = $this->input->post("id_kota");
        $kota = $this->pelanggan_model->cari_nama_kota($id_kota);
        $no_hp = $this->input->post("no_hp");

        $data = array("no"=>$kode,"nama"=>$nama,"alamat"=>$alamat,"id_kota"=>$id_kota,"kota"=>$kota,"no_hp"=>$no_hp);
        
        $this->pelanggan_model->simpan_data("pelanggan",$data);
        
        redirect(base_url('penjualan/pelanggan')); 

    }

    function pelanggan_edit($id_plg){
        $id_plg = $this->enkripsi_url->decode($id_plg);
        
        $this->load->model("penjualan_model");
        $data["provinsi"] = $this->penjualan_model->tampil_data_provinsi();
        

        $this->load->model("pelanggan_model");
        $data["pelanggan"] = $this->pelanggan_model->tampil_data_edit($id_plg);
        foreach ($data["pelanggan"]->result() as $p) {
            $id_provinsi = $p->id_provinsi;
        }
        $data["kota"] = $this->penjualan_model->tampil_data_kota_per_provinsi($id_provinsi);
        
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/pelanggan-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function pelanggan_update($id_plg){
        $id_plg = $this->enkripsi_url->decode($id_plg);
        
        $kode = $this->input->post("kode");
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat"); 
        $kota = $this->input->post("kota"); 
        $no_hp = $this->input->post("no_hp");

        $data = array("no"=>$kode,"nama"=>$nama,"alamat"=>$alamat,"kota"=>$kota,"no_hp"=>$no_hp);
        $where = array("id_plg"=>$id_plg);

        $this->load->model("pelanggan_model");
        $this->pelanggan_model->update_data("pelanggan",$data,$where);

        redirect(base_url('penjualan/pelanggan')); 
        
    }
    
    function pelanggan_hapus(){
        $id_plg = $this->uri->segment(3);
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_plg"=>$id_plg);

        $this->load->model("pelanggan_model");
        $this->pelanggan_model->update_data("pelanggan",$data,$where);

        #redirect(base_url('penjualan/pelanggan'));  
        
    }

    function penjualan(){
        #Jika ada penjualan abru belum selesai maka harus dipaksa buka
        $penjualan = $this->db->query("select * from penjualan where status='Baru' order by id_penjualan desc limit 1");
        if($penjualan->num_rows() > 0)
        {
            foreach($penjualan->result() as $r)
            {
            redirect(base_url("penjualan/penjualan_tambah_barang/".$this->enkripsi_url->encode($r->id_penjualan)));
            }
        }
        else
        {
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("kode_auto");
        $data["no_nota"] = $this->kode_auto->kd_angka_inisial("penjualan","no_nota", date("ymd"));
        $this->load->model("pelanggan_model");
        $data["pelanggan"] = $this->pelanggan_model->tampil_data_lama();
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/penjualan.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
        }
    }

    function show_kode_penjualan(){
		$this->load->model("kode_auto");
		$tanggal = $this->input->post("tanggal");
		list($tgl,$bln,$thn) =explode("-",$tanggal);
		$tanggal = substr($thn, 2,2) . $bln . $tgl;
		if($tanggal)
		{
			$kode = $this->kode_auto->kd_angka_inisial("penjualan","no_nota",$tanggal);
			
			echo $kode;
		}
    }
    
    function show_pelanggan_id(){
		$this->load->model("pelanggan_model");

		$id_pelanggan = $this->input->post("id_pelanggan");
		

		if(!empty($id_pelanggan))
		{
		$pelanggan = $this->pelanggan_model->tampil_data_edit($id_pelanggan);
		foreach ($pelanggan->result() as $p) {
            $nama = $p->nama;
            $alamat = $p->alamat;
			$kota = $p->kota;
			$no_hp = $p->no_hp;
		}
		$pelanggan = array("nama"=>$nama,"alamat"=>$alamat,"kota"=>$kota,"no_hp"=>$no_hp);
		echo json_encode($pelanggan);
		}
		else
		{
			$pelanggan = array("nama"=>"","alamat"=>"","kota"=>"","no_hp"=>"");
			echo json_encode($pelanggan);
		}
    }
    

    function penjualan_buat_nota(){
        $this->load->model("penjualan_model");
        $this->load->model("pelanggan_model");
		
		$id_user = $this->input->post("id_user");
		$tanggal = tgl_pecah($this->input->post("tanggal"));
		$no_nota = $this->input->post("no_nota");
        $id_pelanggan = $this->input->post("id_pelanggan");
        $nama_pelanggan = $this->input->post("nama");
        $alamat = $this->input->post("alamat");
        $ekspedisi = $this->input->post("ekspedisi");
        $data_pelanggan = $this->pelanggan_model->tampil_data_pelanggan_alamat($id_pelanggan);
        foreach($data_pelanggan->result() as $r){
            $nama = $r->nama;
            $provinsi = $r->provinsi;
            $kota = $r->kota;
            $no_hp = $r->no_hp;
        }
        if($nama == "UMUM")
        {
            $no_hp = $this->input->post("no_hp");
            $alamat_lgkp = $alamat." - ".$this->input->post("kota");
        }
        else
        {
            $alamat_lgkp = $alamat. " - " .$kota. " - " .$provinsi;
        }
        
        $status = "Baru";
        $status_kirim = "Belum Kirim";


		$data = array(
			"id_user"=>$id_user,
            "id_pelanggan"=>$id_pelanggan,
            "nama_pelanggan"=>$nama_pelanggan,
			"no_nota"=>$no_nota,
            "tanggal"=>$tanggal,
            "alamat"=>$alamat_lgkp,
            "no_hp"=>$no_hp,
            "ekspedisi"=>$ekspedisi,
            "status"=>$status,
            "status_kirim"=>$status_kirim);

		$id_penjualan = $this->penjualan_model->simpan_data("penjualan",$data);

		
		redirect(base_url("penjualan/penjualan_tambah_barang/".$this->enkripsi_url->encode($id_penjualan)));
		
    }
    
    function penjualan_tambah_barang(){
        $id_penjualan = $this->enkripsi_url->decode($this->uri->segment(3));
		$this->load->model("penjualan_model");
		$this->load->model("barang_model");

        $penjualan = $this->penjualan_model->tampil_data_status_keranjang($id_penjualan);
        $data_penjualan["nota"] = $penjualan;
        
		$keranjang = $this->penjualan_model->tampil_data_keranjang($id_penjualan);
		$data_penjualan["keranjang"] = $keranjang;

		$barang = $this->barang_model->tampil_data_lama();
        $data_penjualan["barang"] = $barang;
        
        $jenis = $this->barang_model->tampil_harga();
		$data_penjualan["jenis"] = $jenis;

		#Menampilkan halaman#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/penjualan-tambah.php",$data_penjualan);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }
    
    function penjualan_show_barang_id(){
        $id_brg = $this->input->post("id_barang");
        $this->load->model("barang_model");
        $barang = $this->barang_model->tampil_barang_stok($id_brg);
        if($barang->num_rows() > 0)
        {
            foreach($barang->result() as $r){
                $kode_brg = $r->kode_barang;
                $nama_brg = $r->nama_barang;
                $stok = $r->sisa;
            }
            $barang = array("kode_barang"=>$kode_brg,"nama_barang"=>$nama_brg,"stok"=>$stok);
        }
        else
        {
            $barang = array("kode_barang"=>"","nama_barang"=>"","stok"=>"");
        }
        echo json_encode($barang);
    }


    function penjualan_show_harga_barang(){
        $id_brg = $this->input->post("id_barang");
        $id_jh = $this->input->post("id_jh");

        $this->load->model("barang_model");
        $barang = $this->barang_model->tampil_harga_barang($id_brg,$id_jh);
        if($barang->num_rows() > 0)
        {
            foreach($barang->result() as $r){
                $harga = $r->harga;
            }
            
        }
        else
        {
            $harga = 0;
        }
        echo $harga;
    }

    function penjualan_simpan_tambah_barang(){
		$this->load->model("penjualan_model");
		$this->load->model("barang_model");

		$id_penjualan = $this->input->post("id_penjualan");
		$id_barang = $this->input->post("id_barang");
		$jumlah = uangPecah($this->input->post("jumlah"));
        $jual = uangPecah($this->input->post("jual"));
		$total = $jumlah * $jual;
		
		$data = array(
				"id_penjualan"=>$id_penjualan,
				"id_brg"=>$id_barang,
				"jumlah"=>$jumlah,
				"harga"=>$jual,
				"sub_total"=>$total);

		$this->penjualan_model->tambah_data_keranjang($data);
		$this->barang_model->kurangi_stok($id_barang,$jumlah);

		redirect(base_url("penjualan/penjualan_tambah_barang/".$this->enkripsi_url->encode($id_penjualan)));

    }

    function penjualan_update_alamat(){
		$this->load->model("penjualan_model");

		$id_penjualan = $this->input->post("id_alamat");
        $id_penjualan = $this->enkripsi_url->decode($id_penjualan);
		$alamat = $this->input->post("alamat_baru");
		
		$data = array(
				"alamat"=>$alamat);
        $where = array("id_penjualan"=>$id_penjualan);

		$this->penjualan_model->update_data("penjualan",$data,$where);

		//redirect(base_url("penjualan/penjualan_tambah_barang/".$this->enkripsi_url->encode($id_penjualan)));

    }
    
    function penjualan_hapus_barang_keranjang(){
		$this->load->model("penjualan_model");
		$this->load->model("barang_model");

		$id_djual =  $this->uri->segment(3);
  		$id_penjualan =  $this->uri->segment(4);
  		$query = $this->penjualan_model->tampil_data_keranjang_per_barang($id_djual);
  		$jumlah_data = $query->num_rows();
  		if($jumlah_data > 0)
  		{
  			foreach($query->result() as $r){
  				$id_barang = $r->id_brg;
  				$jumlah = $r->jumlah;
  			}
  		}

		$this->penjualan_model->hapus_barang_keranjang($id_djual,$id_penjualan);
		$this->barang_model->tambah_stok_per_barang($id_barang,$jumlah);

		redirect(base_url("penjualan/penjualan_tambah_barang/".$this->enkripsi_url->encode($id_penjualan)));
    }
    
    function penjualan_hapus_nota(){
		$this->load->model("penjualan_model");
		$this->load->model("barang_model");

		$id_penjualan =  $this->uri->segment(3);

		$query = $this->penjualan_model->tampil_data_keranjang($id_penjualan);
  		$jumlah_data = $query->num_rows();
  		if($jumlah_data > 0)
  		{
  			foreach($query->result() as $r){
  				$id_djual = $r->id_djual;
  				$id_barang = $r->id_brg;
  				$jumlah = $r->jumlah;
  				$this->barang_model->tambah_stok_per_barang($id_barang,$jumlah);
  			}
        }
          $this->penjualan_model->hapus_nota($id_penjualan);
          $this->db->query("delete from pembayaran where id_penjualan='$id_penjualan' ");

		redirect(base_url("penjualan/daftar_penjualan"));
    }

    function penjualan_simpan_nota(){
		$this->load->model("penjualan_model");
		$this->load->model("barang_model");

		$id_penjualan =  $this->uri->segment(3);
		

		#Simpan Penjualan
		$this->penjualan_model->simpan_nota($id_penjualan);

		#redirect(base_url("penjualan/daftar_penjualan"));
	}



    function daftar_penjualan(){
		#Menampilkan halaman#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/daftar-penjualan.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function penjualan_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("penjualan_model");
		$penjualan = $this->penjualan_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
        #$d = array();
		foreach($penjualan as $r){
		    $pembayaran = $this->db->query("select * from pembayaran where id_penjualan='$r->id_penjualan' ");
            $pembayaran = $pembayaran->num_rows();

            $berat = $this->penjualan_model->cari_berat_total($r->id_penjualan);
			$sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = tgl_indo($r->tanggal);
			$sub_array[] = $r->no_nota;
			$sub_array[] = $r->nama." - ".$r->nama_pelanggan;
			$sub_array[] = uang($r->total + $r->ongkir);
			$sub_array[] = $berat;
            $sub_array[] = "<strong>".$r->status."</strong>";
            $sub_array[] = "<strong>".$r->ekspedisi." - ".$r->status_kirim."</strong>";
            if($pembayaran == 0)
            {
            if($r->status == "Belum Selesai")
            {
            $sub_array[] = '<div class="btn-group">
            <button type="button" class="btn btn-default">Pilih Aksi</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
                <ul class="dropdown-menu" role="menu">
                <li><a href="'.base_url('penjualan/penjualan_tambah_barang/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Edit Nota</a></li>
                <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                <li><a href="javascript:;" class="item_bayar" data="'.$r->id_penjualan.'">Input Pembayaran</a></li>
                <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                </ul>
            </div>';
            }
            else
            {
                $sub_array[] = '<div class="btn-group">
            <button type="button" class="btn btn-default">Pilih Aksi</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
                <ul class="dropdown-menu" role="menu">
                <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                </ul>
            </div>';
            }
            }
            else if($pembayaran > 0)
            {
                if($r->status == "Belum Selesai")
                {
                    $sub_array[] = '<div class="btn-group">
                    <button type="button" class="btn btn-default">Pilih Aksi</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                        <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                        <li><a href="javascript:;" class="item_bayar" data="'.$r->id_penjualan.'">Input Pembayaran</a></li>
                        <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                        </ul>
                    </div>';
                }
                else
                {
                    $sub_array[] = '<div class="btn-group">
                    <button type="button" class="btn btn-default">Pilih Aksi</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                        <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                        <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                        </ul>
                    </div>';
                }
            }
        $data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->penjualan_model->get_all_data(),
				"recordsFiltered" 	=> $this->penjualan_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}


    function purchase_order_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("purchase_order_model");
		$penjualan = $this->purchase_order_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
        #$d = array();
		foreach($penjualan as $r){
		    $pembayaran = $this->db->query("select * from pembayaran where id_penjualan='$r->id_penjualan' ");
            $pembayaran = $pembayaran->num_rows();

            $berat = $this->purchase_order_model->cari_berat_total($r->id_penjualan);
			$sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = tgl_indo($r->tanggal);
			$sub_array[] = $r->no_nota;
			$sub_array[] = $r->nama." - ".$r->nama_pelanggan;
			$sub_array[] = uang($r->total + $r->ongkir);
			$sub_array[] = $berat;
            $sub_array[] = "<strong>".$r->status."</strong>";
            $sub_array[] = "<strong>".$r->ekspedisi." - ".$r->status_kirim."</strong>";
            if($pembayaran == 0)
            {
            if($r->status == "Belum Selesai")
            {
            $sub_array[] = '<div class="btn-group">
            <button type="button" class="btn btn-default">Pilih Aksi</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
                <ul class="dropdown-menu" role="menu">
                <li><a href="'.base_url('penjualan/penjualan_tambah_barang/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Edit</a></li>
                <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                <li><a href="javascript:;" class="item_bayar" data="'.$r->id_penjualan.'">Input Pembayaran</a></li>
                <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                </ul>
            </div>';
            }
            else
            {
                $sub_array[] = '<div class="btn-group">
            <button type="button" class="btn btn-default">Pilih Aksi</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
                <ul class="dropdown-menu" role="menu">
                <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                </ul>
            </div>';
            }
            }
            else if($pembayaran > 0)
            {
                if($r->status == "Belum Selesai")
                {
                    $sub_array[] = '<div class="btn-group">
                    <button type="button" class="btn btn-default">Pilih Aksi</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                        <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                        <li><a href="javascript:;" class="item_bayar" data="'.$r->id_penjualan.'">Input Pembayaran</a></li>
                        <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                        </ul>
                    </div>';
                }
                else
                {
                    $sub_array[] = '<div class="btn-group">
                    <button type="button" class="btn btn-default">Pilih Aksi</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="'.base_url('penjualan/penjualan_update_kirim/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Update Resi</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_lihat_nota/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Lihat</a></li>
                        <li><a href="javascript:;" class="item_alamat" alamat="'.$r->alamat.'" data="'.$this->enkripsi_url->encode($r->id_penjualan).'">Edit Alamat</a></li>
                        <li><a href="'.base_url('penjualan/penjualan_invoice/'.$this->enkripsi_url->encode($r->id_penjualan)).'">Invoice</a></li>
                        <li><a href="javascript:;" class="item_hapus" no-nota="'.$r->no_nota.'" data="'.$r->id_penjualan.'">Hapus</a></li>
                        </ul>
                    </div>';
                }
            }
        $data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->purchase_order_model->get_all_data(),
				"recordsFiltered" 	=> $this->purchase_order_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function penjualan_update_kirim(){
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $id_penjualan =  $this->enkripsi_url->decode($this->uri->segment(3));
        $this->load->model("penjualan_model");
        $data["penjualan"] = $this->penjualan_model->tampil_data_status_keranjang($id_penjualan);
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/penjualan-update-kirim.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function simpan_penjualan($id_penjualan){
        $this->load->model("penjualan_model");
        $id_penjualan =  $this->enkripsi_url->decode($id_penjualan);

        $jenis_penjualan = $this->input->post("jenis_penjualan");
        $metode_bayar = $this->input->post("metode_bayar");
        $status_bayar = ($this->input->post("jenis_bayar") == "Lunas") ? 'Selesai' : 'Belum Selesai' ;
        $total_s = uangPecah($this->input->post("total_s"));
        $ongkir = uangPecah($this->input->post("ongkir"));
        $tanggal = tgl_pecah($this->input->post("tanggal"));
        $total_akhir = $total_s + $ongkir;
        $bayar = uangPecah($this->input->post("bayar"));
        $kurang_bayar = $total_akhir - $bayar;
        $jatuh_tempo = ($metode_bayar == "Tempo") ? tgl_pecah_miring($this->input->post("jatuh_tempo")) : null ;
        

        $data = array("jenis"=>$jenis_penjualan,"total"=>$total_s,"ongkir"=>$ongkir,"jatuh_tempo"=>$jatuh_tempo,"status"=>$status_bayar);
        $where = array("id_penjualan"=>$id_penjualan);
		#Update pnegiriman
		$this->penjualan_model->update_data("penjualan",$data,$where);

        #Pembayaran
        if($metode_bayar != "Tempo")
        {
            $data = array("id_penjualan"=>$id_penjualan,"tanggal"=>$tanggal,"nominal"=>$bayar,"metode_bayar"=>$metode_bayar);
            $this->penjualan_model->simpan_data("pembayaran",$data);
        }

        redirect(base_url("penjualan/daftar_penjualan"));
    }

    function penjualan_simpan_pengiriman(){
		$this->load->model("penjualan_model");

		$id_penjualan =  $this->uri->segment(3);
        $alamat = $this->input->post("alamat");
        $ekspedisi = $this->input->post("ekspedisi");
        $no_resi = $this->input->post("no_resi");
        $total = uangPecah($this->input->post("total"));
        $status_kirim = $this->input->post("status_kirim");
        $total_akhir = $total + $ongkir;

        $data = array("total"=>$total_akhir,"alamat"=>$alamat,"ekspedisi"=>$ekspedisi,"no_resi"=>$no_resi,"status_kirim"=>$status_kirim);
        $where = array("id_penjualan"=>$id_penjualan);
		#Update pnegiriman
		$this->penjualan_model->update_data("penjualan",$data,$where);

		redirect(base_url("penjualan/daftar_penjualan"));
	}
    
    function penjualan_invoice($id_penjualan){
		$this->load->model("penjualan_model");
        $id_penjualan = $this->enkripsi_url->decode($id_penjualan);
		$penjualan = $this->penjualan_model->tampil_data_status_keranjang($id_penjualan);
		$data_penjualan["nota"] = $penjualan;

		$keranjang = $this->penjualan_model->tampil_data_keranjang($id_penjualan);
		$data_penjualan["keranjang"] = $keranjang;

		

		#Menampilkan halaman#
        $level = $this->session->level;
        
        $this->load->view("admin/penjualan/penjualan-invoice.php",$data_penjualan);
        #Menampilkan halaman#
    }

    function penjualan_lihat_nota($id_penjualan){
		$this->load->model("penjualan_model");
        $id_penjualan = $this->enkripsi_url->decode($id_penjualan);
		$penjualan = $this->penjualan_model->tampil_data_status_keranjang($id_penjualan);
		$data_penjualan["nota"] = $penjualan;

		$keranjang = $this->penjualan_model->tampil_data_keranjang($id_penjualan);
		$data_penjualan["keranjang"] = $keranjang;

		

		#Menampilkan halaman#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/penjualan-nota.php",$data_penjualan);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }


    function penjualan_cetak_nota($id_penjualan){
		$this->load->model("penjualan_model");
        $id_penjualan = $this->enkripsi_url->decode($id_penjualan);
		$penjualan = $this->penjualan_model->tampil_data_status_keranjang($id_penjualan);
		$data_penjualan["nota"] = $penjualan;

		$keranjang = $this->penjualan_model->tampil_data_keranjang($id_penjualan);
		$data_penjualan["keranjang"] = $keranjang;

		

		#Menampilkan halaman#
		$this->load->view("admin/penjualan/penjualan-cetak.php",$data_penjualan);
        #Menampilkan halaman#
	}

    function get_data_nota(){
        $id = $this->input->get("id_penjualan");
        #Pembayaran
        $b = $this->db->query("select sum(nominal) as total from pembayaran where id_penjualan='$id' ");
        if($b->num_rows() > 0)
        {
            foreach($b->result() as $r){
                $sudah_bayar = ($r->total == null) ? 0 : (int)$r->total;
            }
        }
        else
        {
            $sudah_bayar = 0;
        }

        #Nota
        $data = $this->db->query("select penjualan.*, pelanggan.nama from penjualan, pelanggan where 
        penjualan.id_penjualan='$id' and 
        penjualan.id_pelanggan = pelanggan.id_plg");
        if($data->num_rows() > 0)
        {
            foreach($data->result() as $r){
                $d = array("nota"=>$r->no_nota,"pelanggan"=>$r->nama,"tanggal"=>tgl_db($r->tanggal),"ongkir"=>$r->ongkir,"jenis"=>$r->jenis,"total"=>$r->total + $r->ongkir,"sudah_bayar"=>$sudah_bayar,"kurang_bayar"=>($r->total + $r->ongkir - $sudah_bayar));
            }
           
            
        }
        else
        {
            $d = array("nota"=>"","pelanggan"=>"","tanggal"=>"","ongkir"=>"","jenis"=>"","total"=>"","sudah_bayar"=>"","kurang_bayar"=>"");
        }
        echo json_encode($d);
    }
    

    function laporan_penjualan(){
        
		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Programmer")
        {
            $this->load->view("programmer/template/header.php");
            $this->load->view("programmer/template/menu.php");

        } else if($level == "Owner"){
            $this->load->view("owner/template/header.php");
            $this->load->view("owner/template/menu.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
        }
        $this->load->view("admin/penjualan/laporan-penjualan.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function laporan_penjualan_tampil(){
		$this->load->model("penjualan_model");

		$tgl1 = $this->input->post("tgl1");
		$bln1 = $this->input->post("bln1");
		$thn1 = $this->input->post("thn1");

		$tgl2 = $this->input->post("tgl2");
		$bln2 = $this->input->post("bln2");
		$thn2 = $this->input->post("thn2");

		$dari = $thn1."-".$bln1."-".$tgl1;
		$sampai = $thn2."-".$bln2."-".$tgl2;

		$data_lap = array("dari"=>$dari,"sampai"=>$sampai);
		
		$laporan = $this->penjualan_model->tampil_data_laporan($data_lap);

		$data["laporan"] = $laporan;
		$data["judul"] = $data_lap;

		#Menampilkan halaman#
		$this->load->view("admin/penjualan/laporan-penjualan-tampil.php",$data);
        #Menampilkan halaman#
	} 


    function pelanggan_cari(){
        $cari = trim($this->input->get("cari"));
        $page = $this->input->get("page");#Untuk Pagination
        $batas = $this->input->get("batas");
        $offset = ($page - 1) * $batas;
        if(!empty($cari))
        {   
            $query = $this->db->query("select * from pelanggan where 
            status_data='Aktif' and
            nama like '%$cari%' order by nama asc
            limit $offset,$batas
            ");

            $count_filtered = $query->num_rows();
            $count_all = $this->db->query("select * from pelanggan where 
            status_data='Aktif' and
            nama like '%$cari%' order by nama asc
            ")->num_rows();
            
            if($query->num_rows() > 0){
            $list = array();
            foreach($query->result() as $row) {
                    $list[] = array("id"=>$row->id_plg, "text"=>$row->nama);
                
            }
            $hasil = array("pelanggan" => $list,
            "count_filtered" => $count_all
            );
            echo json_encode($hasil);
            }
            else
            {
                echo "Tidak Ketemu";
            }
            
        }
        else
        {
            echo "Tidak Valid";
        }
    }

    function simpan_pembayaran(){
        $this->load->model("penjualan_model");


        $id_penjualan = $this->input->post("id_bayar");
        $metode_bayar = $this->input->post("metode_bayar");
        $tanggal_bayar = tgl_pecah($this->input->post("tanggal_bayar"));
        $nominal = uangPecah($this->input->post("bayar"));
        $sisa = uangPecah($this->input->post("sisa"));

        $data = array("id_penjualan"=>$id_penjualan,"metode_bayar"=>$metode_bayar,"tanggal"=>$tanggal_bayar,"nominal"=>$nominal);
        $this->penjualan_model->simpan_data("pembayaran",$data);

        if($sisa <= 0){
            $this->penjualan_model->simpan_nota($id_penjualan);
        }

        redirect(base_url("penjualan/daftar_penjualan"));

    }

    function barang_cari(){
        $cari = trim($this->input->get("cari"));
        $page = $this->input->get("page");#Untuk Pagination
        $batas = $this->input->get("batas");
        $offset = ($page - 1) * $batas;
        if(!empty($cari))
        {   
            $query = $this->db->query("select * from barang where 
            status_data='Aktif' and
            (nama_barang like '%$cari%' or kode_barang = '$cari') order by nama_barang asc
            limit $offset,$batas
            ");

            $count_filtered = $query->num_rows();
            $count_all = $this->db->query("select * from barang where 
            status_data='Aktif' and
            (nama_barang like '%$cari%' or kode_barang = '$cari') order by nama_barang asc
            ")->num_rows();
            
            if($query->num_rows() > 0){
            $list = array();
            foreach($query->result() as $row) {
                    $list[] = array("id"=>$row->id_brg, "text"=>$row->kode_barang." - ".$row->nama_barang);
                
            }
            $hasil = array("barang" => $list,
            "count_filtered" => $count_all
            );
            echo json_encode($hasil);
            }
            else
            {
                echo "Tidak Ketemu";
            }
            
        }
        else
        {
            echo "Tidak Valid";
        }
    }
	
}
?>