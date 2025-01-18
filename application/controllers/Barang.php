<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Barang extends CI_Controller{

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
            } else if($level == "Gudang"){
				$this->load->view("gudang/template/header.php");
                $this->load->view("gudang/template/menu.php");
            }

            $this->load->view("admin/beranda.php");
        	$this->load->view("admin/template/footer.php");
        	/*
			*	Menampilkan view master template dan halaman beranda
			*
			*/
    }


    function barang(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
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
            $this->load->view("owner/barang/barang.php");
        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
            $this->load->view("admin/template/menu.php");
            $this->load->view("admin/barang/barang.php");
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
            $this->load->view("gudang/barang/barang.php");
        }
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function barang_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("barang_model");
		$barang = $this->barang_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($barang as $r){
            $i[$no] = 0;
		    $foto = $r->foto;
                    if($r->foto == ""){$foto = "default.jpg";}
            $hg = $this->barang_model->tampil_harga_per_barang($r->id_brg);
            foreach($hg->result() as $h){
                $i[$no]++;
                if($i[$no] == 1)
                {
                  $harga = uang($h->harga);
                }
                else
                {
                  $harga .= " || ". uang($h->harga);
                }
                
                
            }
            $st = $this->barang_model->cari_stok_akhir($r->id_brg);
              if($st->num_rows() > 0){
                foreach($st->result() as $d){
                    $stok = $d->sisa;
                }
                            
              }
              else
              {
                $stok = 0;
              }
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="id[]" value="'.$r->id_brg.'">';
			$sub_array[] = $no++;
            $sub_array[] = $r->kode_barang;
            $sub_array[] = $r->nama_barang;
			$sub_array[] = $r->berat;
			$sub_array[] = $harga;
			$sub_array[] = $r->keterangan;
			$sub_array[] = $stok;
			$sub_array[] = '<img src="'. base_url('upload/barang/'.$foto). '?'.rand(1,3000).'" width="40" height="40">';
			$sub_array[] = '<a class="btn btn-default" href="'.base_url('barang/barang_masuk_input/'.$this->enkripsi_url->encode($r->id_brg)).'" title="Masuk">
            <i class="fa fa-arrow-down"></i>
            </a>
            <a class="btn btn-default" href="'.base_url('barang/barang_keluar_input/'.$this->enkripsi_url->encode($r->id_brg)).'" title="Keluar">
            <i class="fa fa-arrow-up"></i>
            </a>';
			$sub_array[] = '<a class="btn btn-default" href="'.base_url('barang/barang/lihat/'.$this->enkripsi_url->encode($r->id_brg)).'" title="Lihat">
            <i class="fa fa-eye"></i>
            </a>
            <a class="btn btn-default" href="'.base_url('barang/barang/edit/'.$this->enkripsi_url->encode($r->id_brg)).'" title="Edit">
            <i class="fa fa-edit"></i>
            </a>
            <a href="javascript:;" class="btn btn-danger item_hapus" nama-barang="'.$r->nama_barang.'" data="'.$r->id_brg.'"><i class="fa fa-trash-o"></i></a>'
            ;
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->barang_model->get_all_data(),
				"recordsFiltered" 	=> $this->barang_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}


    function barang_input(){
        $this->load->model("barang_model");
        $data["harga"] = $this->barang_model->tampil_harga();

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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function barang_simpan(){
        $kode_brg = $this->input->post("kode");
        $nama_brg = $this->input->post("nama");
        $berat = uangPecah($this->input->post("berat")); 
        $keterangan = $this->input->post("keterangan"); 

        $data = array("kode_barang"=>$kode_brg,"nama_barang"=>$nama_brg,"berat"=>$berat,"keterangan"=>$keterangan);
        $this->load->model("barang_model");
        $this->id_barang = $this->barang_model->simpan_data("barang",$data);
        
        

        /**Simpan harga barang */
        $jh = $this->input->post("jh");
        $harga = uangPecah($this->input->post("harga"));
        for($i = 0; $i < count($harga); $i++){
            $data = array("id_brg"=>$this->id_barang,"id_jh"=>$jh[$i],"harga"=>$harga[$i]);
            $this->barang_model->simpan_data("harga_brg",$data);
        }

        $tipe = $this->_uploadImage($this->id_barang);
        
        $nama_file = $this->id_barang.$tipe;
        $data = array("foto"=>$nama_file);
        $where = array("id_brg"=>$this->id_barang);
        $this->barang_model->update_data("barang",$data,$where);
        redirect(base_url('barang/barang')); 

    }

    private function _uploadImage($id_barang){
        $config['upload_path']          = './upload/barang/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $id_barang;
        $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
    
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload('foto')) {
            return $this->upload->data("file_ext");
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            return "default.jpg";
            
        }
        
        
        }

        function barang_lihat($id_barang){
            $id_barang = $this->enkripsi_url->decode($id_barang);
            
            
            $this->load->model("barang_model");
            $data["barang"] = $this->barang_model->tampil_data_edit($id_barang);
            $data["harga"] = $this->barang_model->tampil_harga_per_barang($id_barang);
            
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
            } else if($level == "Gudang"){
				$this->load->view("gudang/template/header.php");
                $this->load->view("gudang/template/menu.php");
            }
            $this->load->view("admin/barang/barang-lihat.php",$data);
            $this->load->view("admin/template/footer.php");
            
    
        }
    

    function barang_edit($id_barang){
        $id_barang = $this->enkripsi_url->decode($id_barang);
        
        
        $this->load->model("barang_model");
        $data["barang"] = $this->barang_model->tampil_data_edit($id_barang);
        $data["harga"] = $this->barang_model->tampil_harga_per_barang($id_barang);
        
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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function barang_update(){
        $id_barang = $this->enkripsi_url->decode($this->uri->segment(3));
        
        $kode_brg = $this->input->post("kode");
        $nama_brg = $this->input->post("nama");
        $berat = uangPecah($this->input->post("berat"));
        $keterangan = $this->input->post("keterangan"); 

        $data = array("kode_barang"=>$kode_brg,"nama_barang"=>$nama_brg,"berat"=>$berat,"keterangan"=>$keterangan);
        $where = array("id_brg"=>$id_barang);

        $this->load->model("barang_model");
        $this->barang_model->update_data("barang",$data,$where);
        /**Simpan harga barang */
        $jh = $this->input->post("jh");
        $harga = uangPecah($this->input->post("harga"));
        for($i = 0; $i < count($harga); $i++){
            $data = array("harga"=>$harga[$i]);
            $where = array("id_brg"=>$id_barang,"id_jh"=>$jh[$i]);
            $this->barang_model->update_data("harga_brg",$data,$where);
        }
        redirect(base_url('barang/barang')); 
        
    }
    
    function barang_hapus(){
        $id_barang = $this->uri->segment(3);
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_brg"=>$id_barang);

        $this->load->model("barang_model");
        $this->barang_model->update_data("barang",$data,$where);

        redirect(base_url('barang/barang')); 
        
    }

    function barang_hapus_ajax(){
        $barang_array = json_decode(stripslashes($_POST['barang']));
        
        foreach($barang_array as $k){
            $data = array("status_data"=>"Hapus");
            $where = array("id_brg"=>$k);
            $this->load->model("barang_model");
            $this->barang_model->update_data("barang",$data,$where);
        }
        
    }

    function barang_masuk(){
        
       
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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-masuk.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function barang_masuk_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("barang_masuk_model");
		$barang = $this->barang_masuk_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($barang as $r){
            
			$sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = tgl_indo_time_baru($r->tanggal);
			$sub_array[] = $r->kode_barang." - ".$r->nama_barang;
			$sub_array[] = $r->jumlah;
            $sub_array[] = '<a href="javascript:;" class="btn btn-danger item_hapus" nama-barang="'.$r->nama_barang.'" data="'.$r->id_masuk.'"><i class="fa fa-trash-o"></i></a>'
            ;
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->barang_masuk_model->get_all_data(),
				"recordsFiltered" 	=> $this->barang_masuk_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function barang_masuk_input($id_barang){
        $id_barang = $this->enkripsi_url->decode($id_barang);

        $this->load->model("barang_model");
        $data["barang"] = $this->barang_model->tampil_data_edit($id_barang);
        $stok = $this->barang_model->cari_stok_akhir($id_barang);
        if($stok->num_rows() > 0){
        foreach($stok->result() as $d){
            $stok = $d->sisa;
        }
            $data["stok"] = $stok;
        }
        else
        {
            $data["stok"] = 0;
        }

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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-masuk-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function barang_masuk_simpan(){
        $this->load->model("barang_model");

        $id_brg = $this->input->post("id_brg");
        $tanggal = tgl_pecah($this->input->post("tanggal"))." " .date("H:i:s");
        $jumlah = uangPecah($this->input->post("jumlah"));
        $stok = $this->barang_model->cari_stok_akhir($id_brg);
        if($stok->num_rows() > 0){
        foreach($stok->result() as $d){
            $stok = $d->sisa;
        }
            
        }
        else
        {
            $stok = 0;
        }
        $stok_awal = $stok;
        $stok_akhir = $stok_awal + $jumlah;

        $data = array("id_brg"=>$id_brg,"jumlah"=>$jumlah,"tanggal"=>$tanggal);
        $this->barang_model->simpan_data("masuk_brg",$data);
        
        /**Update stok barang */
        #Cari data barang di tabel stok
        $hasil = $this->barang_model->cari_stok_akhir($id_brg);
        if($hasil->num_rows() > 0)
        {
        #update jika ada
        $data = array("sisa"=>$stok_akhir,"tanggal_update"=>tgl_pecah($this->input->post("tanggal")));
        $where = array("id_brg"=>$id_brg);
        $this->barang_model->update_data("stok_brg",$data,$where);
        }
        else
        {
        #tambah baru jika belum ada
        $data = array("id_brg"=>$id_brg,"sisa"=>$stok_akhir,"tanggal_update"=>tgl_pecah($this->input->post("tanggal")));
        $this->barang_model->simpan_data("stok_brg",$data);
        }

        redirect(base_url('barang/barang')); 

    }



    function barang_masuk_hapus(){
        $id_masuk = $this->uri->segment(3);
        $this->load->model("barang_model");
        #Update data stok akhir
        $masuk = $this->barang_model->tampil_data_barang_masuk_dengan_id_masuk($id_masuk);
        foreach($masuk->result() as $d){
            $id_barang = $d->id_brg;
            $jumlah_masuk = $d->jumlah;
        }
        
        $sa = $this->barang_model->cari_stok_akhir($id_barang);
        foreach($sa->result() as $r){
            
            $stok_awal = $r->sisa;
        }

        $stok_akhir = $stok_awal - $jumlah_masuk;
        $data = array("sisa"=>$stok_akhir,"tanggal_update"=>date("Y-m-d"));
        $where = array("id_brg"=>$id_barang);
        $this->barang_model->update_data("stok_brg",$data,$where);

        #Hapus data barang masuk
        $where = array("id_masuk"=>$id_masuk);
        $this->barang_model->hapus_data($where, "masuk_brg");

        #redirect(base_url('barang/barang_masuk')); 
    }

    function barang_keluar(){
        
       
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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-keluar.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function barang_keluar_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("barang_keluar_model");
		$barang = $this->barang_keluar_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($barang as $r){
            
			$sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = tgl_indo_time_baru($r->tanggal);
			$sub_array[] = $r->kode_barang." - ".$r->nama_barang;
			$sub_array[] = $r->jumlah;
            $sub_array[] = '<a href="javascript:;" class="btn btn-danger item_hapus" nama-barang="'.$r->nama_barang.'" data="'.$r->id_keluar.'"><i class="fa fa-trash-o"></i></a>'
            ;
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->barang_keluar_model->get_all_data(),
				"recordsFiltered" 	=> $this->barang_keluar_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function barang_keluar_input($id_barang){
        $id_barang = $this->enkripsi_url->decode($id_barang);

        $this->load->model("barang_model");
        $data["barang"] = $this->barang_model->tampil_data_edit($id_barang);
        $stok = $this->barang_model->cari_stok_akhir($id_barang);
        if($stok->num_rows() > 0){
        foreach($stok->result() as $d){
            $stok = $d->sisa;
        }
            $data["stok"] = $stok;
        }
        else
        {
            $data["stok"] = 0;
        }

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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/barang-keluar-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function barang_keluar_simpan(){
        $this->load->model("barang_model");

        $id_brg = $this->input->post("id_brg");
        $tanggal = tgl_pecah($this->input->post("tanggal"))." " .date("H:i:s");
        $jumlah = uangPecah($this->input->post("jumlah"));
        $stok = $this->barang_model->cari_stok_akhir($id_brg);
        if($stok->num_rows() > 0){
        foreach($stok->result() as $d){
            $stok = $d->sisa;
        }
            
        }
        else
        {
            $stok = 0;
        }
        $stok_awal = $stok;
        $stok_akhir = $stok_awal - $jumlah;

        $data = array("id_brg"=>$id_brg,"jumlah"=>$jumlah,"tanggal"=>$tanggal);
        $this->barang_model->simpan_data("keluar_brg",$data);
        
        /**Update stok barang */
        #Cari data barang di tabel stok
        $hasil = $this->barang_model->cari_stok_akhir($id_brg);
        if($hasil->num_rows() > 0)
        {
        #update jika ada
        $data = array("sisa"=>$stok_akhir,"tanggal_update"=>tgl_pecah($this->input->post("tanggal")));
        $where = array("id_brg"=>$id_brg);
        $this->barang_model->update_data("stok_brg",$data,$where);
        }
        else
        {
        #tambah baru jika belum ada
        $data = array("id_brg"=>$id_brg,"sisa"=>$stok_akhir,"tanggal_update"=>tgl_pecah($this->input->post("tanggal")));
        $this->barang_model->simpan_data("stok_brg",$data);
        }

        redirect(base_url('barang/barang')); 

    }



    function barang_keluar_hapus(){
        $id_keluar = $this->uri->segment(3);
        $this->load->model("barang_model");
        #Update data stok akhir
        $masuk = $this->barang_model->tampil_data_barang_keluar_dengan_id_keluar($id_keluar);
        foreach($masuk->result() as $d){
            $id_barang = $d->id_brg;
            $jumlah_keluar = $d->jumlah;
        }
        
        $sa = $this->barang_model->cari_stok_akhir($id_barang);
        foreach($sa->result() as $r){
            
            $stok_awal = $r->sisa;
        }

        $stok_akhir = $stok_awal + $jumlah_keluar;
        $data = array("sisa"=>$stok_akhir,"tanggal_update"=>date("Y-m-d"));
        $where = array("id_brg"=>$id_barang);
        $this->barang_model->update_data("stok_brg",$data,$where);

        #Hapus data barang masuk
        $where = array("id_keluar"=>$id_keluar);
        $this->barang_model->hapus_data($where, "keluar_brg");

        #redirect(base_url('barang/barang_masuk')); 
    }


    function stok_barang(){
       
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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/stok-barang.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function stok_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("stok_model");
        $this->load->model("barang_model");
		$barang = $this->stok_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($barang as $r){
            $masuk = $this->barang_model->tampil_masuk_per_barang_per_hari_ini($r->id_brg);
            $keluar = $this->barang_model->tampil_keluar_per_barang_per_hari_ini($r->id_brg);
            
			$sub_array = array();
			$sub_array[] = $no++;
            $sub_array[] = tgl_indo($r->tanggal_update);
			$sub_array[] = $r->kode_barang." - ".$r->nama_barang;
            $sub_array[] = $r->keterangan;
            $sub_array[] = $masuk;
            $sub_array[] = $keluar;
			$sub_array[] = $r->sisa;
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->stok_model->get_all_data(),
				"recordsFiltered" 	=> $this->stok_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function laporan_stok(){
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
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
            $this->load->view("gudang/template/menu.php");
        }
        $this->load->view("admin/barang/laporan-stok.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function laporan_stok_tampil(){
        $this->load->model("barang_model");

		$tgl2 = $this->input->post("tgl2");
		$bln2 = $this->input->post("bln2");
		$thn2 = $this->input->post("thn2");

		$sampai = $thn2."-".$bln2."-".$tgl2;

		$data_lap = array("sampai"=>$sampai);
		
		$laporan = $this->barang_model->tampil_data_laporan($data_lap);

		$data["laporan"] = $laporan;
		$data["judul"] = $data_lap;

		#Menampilkan halaman#
		$this->load->view("admin/barang/laporan-stok-tampil.php",$data);
        #Menampilkan halaman#
    }
	
}
?>