<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Produksi extends CI_Controller{

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


    function kain(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("kain_model");
        
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
        $this->load->view("admin/produksi/kain.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }
    
    function kain_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("kain_model");
		$kain = $this->kain_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
		foreach($kain as $r){
		    $foto = $r->foto;
                    if($r->foto == ""){$foto = "default.jpg";}
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="id[]" value="'.$r->id_kain.'">';
			$sub_array[] = $no++;
            $sub_array[] = $r->jenis_kain;
			$sub_array[] = $r->nama_toko;
			$sub_array[] = uang($r->harga);
			$sub_array[] = uang($r->total_harga);
			$sub_array[] = "".$r->status_bayar."";
			$sub_array[] = "".$r->status_produksi."";
			$sub_array[] = '<a class="btn btn-default" href="'. base_url('produksi/kain/edit/'.$this->enkripsi_url->encode($r->id_kain)).'" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="javascript:;" class="btn btn-danger item_hapus" nama-kain="'.$r->jenis_kain.'" data="'.$r->id_kain.'"><i class="fa fa-trash-o"></i></a>';
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->kain_model->get_all_data(),
				"recordsFiltered" 	=> $this->kain_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function kain_input(){
        

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
        $this->load->view("admin/produksi/kain-input.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function kain_simpan(){
        $jenis = $this->input->post("jenis");
        $nama = $this->input->post("nama");
        $harga = uangPecah($this->input->post("harga")); 
        $total = uangPecah($this->input->post("total"));
        $keterangan = $this->input->post("keterangan");
        $status_bayar = $this->input->post("status_bayar");
        

        $data = array("jenis_kain"=>$jenis,"nama_toko"=>$nama,"harga"=>$harga,"total_harga"=>$total,
    "keterangan"=>$keterangan,"status_bayar"=>$status_bayar);
        $this->load->model("kain_model");
        $this->id_kain = $this->kain_model->simpan_data("kain",$data);
        
        
        $nama_file = $this->_uploadImage($this->id_kain);
        
        
        
        
        $data = array("foto"=>$nama_file);
        $where = array("id_kain"=>$this->id_kain);
        $this->kain_model->update_data("kain",$data,$where);

        redirect(base_url('produksi/kain')); 

    }

    function kain_edit($id_kain){
        $id_kain = $this->enkripsi_url->decode($id_kain);
        
        
        $this->load->model("kain_model");
        $data["kain"] = $this->kain_model->tampil_data_edit($id_kain);

        
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
        $this->load->view("admin/produksi/kain-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function kain_update($id_kain){
        $this->load->model("kain_model");
        $id_kain = $this->enkripsi_url->decode($id_kain);
        
        $jenis = $this->input->post("jenis");
        $nama = $this->input->post("nama");
        $harga = uangPecah($this->input->post("harga")); 
        $total = uangPecah($this->input->post("total"));
        $keterangan = $this->input->post("keterangan");
        $status_bayar = $this->input->post("status_bayar");
        
        /*
        if (!empty($_FILES["foto"]["name"])) {
            echo $nama_file = $this->_uploadImage($id_kain);
            $data = array("foto"=>$nama_file);
            $where = array("id_kain"=>$id_kain);
            $this->kain_model->update_data("kain",$data,$where);
            
        }*/

        $data = array("jenis_kain"=>$jenis,"nama_toko"=>$nama,"harga"=>$harga,"total_harga"=>$total,
    "keterangan"=>$keterangan,"status_bayar"=>$status_bayar);
        $where = array("id_kain"=>$id_kain);

        
        $this->kain_model->update_data("kain",$data,$where);

        redirect(base_url('produksi/kain')); 
        
    }
    
    function kain_hapus(){
        $id_kain = $this->uri->segment(3);
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_kain"=>$id_kain);

        $this->load->model("kain_model");
        $this->kain_model->update_data("kain",$data,$where);

        redirect(base_url('produksi/kain')); 
        
    }

    function kain_hapus_ajax(){

        $kain_array = json_decode(stripslashes($_POST['kain']));
        
        foreach($kain_array as $k){
            $data = array("status_data"=>"Hapus");
            $where = array("id_kain"=>$k);
            $this->load->model("kain_model");
            $this->kain_model->update_data("kain",$data,$where);
        }
        #redirect(base_url('produksi/kain')); 
        
    }

    private function _uploadImage($nama){
    $config['upload_path']          = './upload/kain/';
    $config['allowed_types']        = 'jpg|png|jpeg';
    $config['file_name']            = $nama;
    $config['overwrite']			= true;
    $config['max_size']             = 3048; // 1MB
    // $config['max_width']            = 1024;
    // $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('foto')) {
        return $nama.$this->upload->data("file_ext");
    }
    else
    {
        $error = array('error' => $this->upload->display_errors());
		return "default.jpg";
    }
    
    
    }

    function pemotong(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("pemotong_model");
        $data["pemotong"] = $this->pemotong_model->tampil_data();
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
        $this->load->view("admin/produksi/pemotong.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function pemotong_input(){
        

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
        $this->load->view("admin/produksi/pemotong-input.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function pemotong_simpan(){
        
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat");

        $data = array("nama_pemotong"=>$nama,"alamat"=>$alamat);
        $this->load->model("pemotong_model");
        $this->pemotong_model->simpan_data("pemotong",$data);
        
        redirect(base_url('produksi/pemotong')); 

    }

    function pemotong_edit($id_pemotong){
        $id_pemotong = $this->enkripsi_url->decode($id_pemotong);
        
        
        $this->load->model("pemotong_model");
        $data["pemotong"] = $this->pemotong_model->tampil_data_edit($id_pemotong);

        
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
        $this->load->view("admin/produksi/pemotong-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function pemotong_update($id_pemotong){
        $id_pemotong = $this->enkripsi_url->decode($id_pemotong);
        
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat");

        $data = array("nama_pemotong"=>$nama,"alamat"=>$alamat);
        $where = array("id_pemotong"=>$id_pemotong);

        $this->load->model("pemotong_model");
        $this->pemotong_model->update_data("pemotong",$data,$where);

        redirect(base_url('produksi/pemotong')); 
        
    }
    
    function pemotong_hapus(){
        $id_pemotong = $this->enkripsi_url->decode($this->uri->segment(3));
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_pemotong"=>$id_pemotong);

        $this->load->model("pemotong_model");
        $this->pemotong_model->update_data("pemotong",$data,$where);

        redirect(base_url('produksi/pemotong')); 
        
    }


    function penjahit(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("penjahit_model");
        $data["penjahit"] = $this->penjahit_model->tampil_data();
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
        $this->load->view("admin/produksi/penjahit.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function penjahit_input(){
        

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
        $this->load->view("admin/produksi/penjahit-input.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function penjahit_simpan(){
        
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat");

        $data = array("nama_penjahit"=>$nama,"alamat"=>$alamat);
        $this->load->model("penjahit_model");
        $this->penjahit_model->simpan_data("penjahit",$data);
        
        redirect(base_url('produksi/penjahit')); 

    }

    function penjahit_edit($id_penjahit){
        $id_penjahit = $this->enkripsi_url->decode($id_penjahit);
        
        
        $this->load->model("penjahit_model");
        $data["penjahit"] = $this->penjahit_model->tampil_data_edit($id_penjahit);

        
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
        $this->load->view("admin/produksi/penjahit-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function penjahit_update($id_penjahit){
        $id_penjahit = $this->enkripsi_url->decode($id_penjahit);
        
        $nama = $this->input->post("nama");
        $alamat = $this->input->post("alamat");

        $data = array("nama_penjahit"=>$nama,"alamat"=>$alamat);
        $where = array("id_penjahit"=>$id_penjahit);

        $this->load->model("penjahit_model");
        $this->penjahit_model->update_data("penjahit",$data,$where);

        redirect(base_url('produksi/penjahit')); 
        
    }
    
    function penjahit_hapus(){
        $id_penjahit = $this->enkripsi_url->decode($this->uri->segment(3));
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_penjahit"=>$id_penjahit);

        $this->load->model("penjahit_model");
        $this->penjahit_model->update_data("penjahit",$data,$where);

        redirect(base_url('produksi/penjahit')); 
        
    }

    function produksi(){
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("kain_model");
        $data["kain"] = $this->kain_model->tampil_data_unproduct_all();
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

        $this->load->model("pemotong_model");
        $data["pemotong"] = $this->pemotong_model->tampil_data();
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
        $this->load->view("admin/produksi/produksi.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    

    function show_kain(){
        $id_kain = $this->input->post("id_kain");
        $this->load->model("kain_model");
        $kain = $this->kain_model->tampil_data_unproduct($id_kain);
        if($kain->num_rows() > 0)
        {
        foreach($kain->result() as $r){
            $nama_toko = $r->nama_toko;
            $total = uang($r->total_harga);
            $data = array("nama_toko"=>$nama_toko,"total"=>$total,"keterangan"=>$r->keterangan);
            echo json_encode($data);
        }
        }
        else
        {
            $data = array("nama_toko"=>"","total"=>"","keterangan"=>"");
            echo json_encode($data);
        }
    }

    function produksi_simpan(){
        $this->load->model("produksi_model");
		
        $tanggal = tgl_pecah($this->input->post("tanggal"));
        $id_kain = $this->input->post("id_kain");
        $id_pemotong = $this->input->post("id_pemotong");

        $data_produksi = array("id_kain"=>$id_kain,"id_pemotong"=>$id_pemotong,"tanggal"=>$tanggal);
        $this->produksi_model->simpan_data("produksi",$data_produksi);
        
        $this->load->model("kain_model");
        $data_kain = array("status_produksi"=>"Sedang Diproduksi");
        $where = array("id_kain"=>$id_kain);
        $this->kain_model->update_data("kain",$data_kain,$where);

		redirect(base_url("produksi/daftar_produksi"));
		
    }

    function produksi_tambah_pemotong(){
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(3));
        $this->load->model("produksi_model");
        $this->load->model("pemotong_model");
		
        $produksi = $this->produksi_model->tampil_data_produksi($id_produksi);
        $data["nota"] = $produksi;

        $data["pemotong"]= $this->pemotong_model->tampil_data();
        $data["produksi_pem"]= $this->produksi_model->tampil_data_pemotong_produksi($id_produksi);
       

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
        $this->load->view("admin/produksi/produksi-tambah-pemotong.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function produksi_simpan_tambah_pemotong(){
        $this->load->model("produksi_model");
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(3));
        $id_pemotong = $this->input->post("id_pemotong");
        $nama = $this->input->post("nama");
        $jumlah = uangPecah($this->input->post("jumlah"));

        $data = array("id_produksi"=>$id_produksi,"id_pemotong"=>$id_pemotong,"jumlah"=>$jumlah,"nama_barang"=>$nama);
        $this->produksi_model->simpan_data("d_potong",$data);
        
       redirect(base_url("produksi/produksi_tambah_pemotong/".$this->uri->segment(3)));

    }

    function produksi_hapus_pemotong(){
        $this->load->model("produksi_model");
        $id_d_potong = $this->enkripsi_url->decode($this->uri->segment(3));

        $where = array("id_d_potong"=>$id_d_potong);
        $this->produksi_model->hapus_data($where, "d_potong");
        
       redirect(base_url("produksi/produksi_tambah_pemotong/".$this->enkripsi_url->encode($this->uri->segment(4))));
    }

    function produksi_tambah_penjahit($id_produksi){
        $id_produksi = $this->enkripsi_url->decode($id_produksi);
        $this->load->model("produksi_model");
        $this->load->model("penjahit_model");
		
        $produksi = $this->produksi_model->tampil_data_produksi($id_produksi);
        $data["nota"] = $produksi;

        $prod = $this->produksi_model->tampil_d_produksi($id_produksi);
        
        if($prod->num_rows() > 0)
        {
            foreach($prod->result() as $g){
                $jumlah = $g->jumlah_produksi;
                $jual = ($g->harga_jual * $jumlah);
                $ongkos = $g->ongkos_jahit * $jumlah;
                $laba = $jual - $ongkos;
                $j[] = $jumlah;
                $jl[] = $jual;
                $o[]= $ongkos;
                $l[] = $laba;

            }
            $prod = array("jumlah"=>array_sum($j),"jual"=>array_sum($jl),"ongkos"=>array_sum($o),
            "laba"=>array_sum($l));
        }
        else
        {
            $prod = array("jumlah"=>0,"jual"=>0,"ongkos"=>0,"laba"=>0);
        }
        $data["prod"] = $prod;

        $data["penjahit"]= $this->penjahit_model->tampil_data();
        $data["produksi_pem"]= $this->produksi_model->tampil_data_penjahit_produksi($id_produksi);
       

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
        $this->load->view("admin/produksi/produksi-tambah-penjahit.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function produksi_simpan_tambah_penjahit(){
        $this->load->model("produksi_model");
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(3));
        $id_penjahit = $this->input->post("id_penjahit");
        $nama = $this->input->post("nama");
        $jumlah = uangPecah($this->input->post("jumlah"));
        $harga = uangPecah($this->input->post("harga"));
        $ongkos = uangPecah($this->input->post("ongkos"));

        $data = array("id_produksi"=>$id_produksi,"id_penjahit"=>$id_penjahit,"jumlah_produksi"=>$jumlah,"nama_barang"=>$nama,"harga_jual"=>$harga,"ongkos_jahit"=>$ongkos);
        $this->produksi_model->simpan_data("d_produksi",$data);
        
       redirect(base_url("produksi/produksi/tambah-penjahit/".$this->uri->segment(3)));

    }

    function produksi_hapus_produksi_penjahit(){
        $this->load->model("produksi_model");
        $id_d_produksi = $this->enkripsi_url->decode($this->uri->segment(3));
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(4));
        

        $where = array("id_d_produksi"=>$id_d_produksi);
        $this->produksi_model->hapus_data($where,"d_setor");

        $where = array("id_d_produksi"=>$id_d_produksi);
        $this->produksi_model->hapus_data($where,"d_produksi");
        
       redirect(base_url("produksi/produksi/tambah-penjahit/".$this->uri->segment(4)));

    }

    function produksi_setor_barang(){
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(5));
        $id_d_produksi = $this->enkripsi_url->decode($this->uri->segment(4));
        $this->load->model("produksi_model");
        $this->load->model("penjahit_model");
		
        $produksi = $this->produksi_model->tampil_data_d_produksi($id_d_produksi);
        $data["nota"] = $produksi;

        $data["produksi_pem"]= $this->produksi_model->tampil_data_setoran($id_d_produksi);
       

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
        $this->load->view("admin/produksi/produksi-setor-barang.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function produksi_simpan_tambah_setoran(){
        $this->load->model("produksi_model");
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(4));
        $id_d_produksi = $this->enkripsi_url->decode($this->uri->segment(3));

        $tanggal = tgl_pecah($this->input->post("tanggal"));
        
        $jumlah = uangPecah($this->input->post("jumlah"));
        $catatan = $this->input->post("catatan");

        $data = array("id_d_produksi"=>$id_d_produksi,"tanggal"=>$tanggal,"jumlah_setor"=>$jumlah,"catatan"=>$catatan);
        $this->produksi_model->simpan_data("d_setor",$data);
        
       redirect(base_url("produksi/produksi/setor-barang/".$this->uri->segment(3))."/".$this->uri->segment(4));

    }

    function produksi_hapus_setoran(){
        $this->load->model("produksi_model");
        $id_setor = $this->enkripsi_url->decode($this->uri->segment(3));
        $id_d_produksi = $this->enkripsi_url->decode($this->uri->segment(4));
        $id_produksi = $this->enkripsi_url->decode($this->uri->segment(5));
        

        $where = array("id_setor"=>$id_setor);
        $this->produksi_model->hapus_data($where,"d_setor");

       redirect(base_url("produksi/produksi/setor-barang/".$this->uri->segment(4)."/".$this->uri->segment(5)));

    }

    


    function produksi_selesai_produksi(){
        $this->load->model("produksi_model");
        $id_produksi = $this->uri->segment(3);

        $data = array("status_prod"=>"Selesai");
        $where = array("id_produksi"=>$id_produksi);
        $this->produksi_model->update_data("produksi",$data,$where);
        redirect(base_url("produksi/daftar_produksi"));
    }

    function produksi_hapus_produksi(){
        $this->load->model("produksi_model");
        $this->load->model("kain_model");
        $id_produksi = $this->uri->segment(3);
        
        #Update status kain menjadi baru
        /*
        $h = $this->produksi_model->tampil_data_edit($id_produksi);
        foreach($h->result() as $s){
            $id_kain = $s->id_kain;
        }
        $data = array("status_produksi"=>"Baru");
        $where = array("id_kain"=>$id_kain);
        $this->kain_model->update_data("kain",$data,$where);
        */

        #update status produksi hapus
        $data = array("status_data"=>"Hapus");
        $where = array("id_produksi"=>$id_produksi);
        $this->produksi_model->update_data("produksi",$data,$where);

        
        
        
       redirect(base_url("produksi/daftar_produksi"));
    }

    function produksi_hapus_produksi_ajax(){
        $this->load->model("produksi_model");
        $this->load->model("kain_model");
        $produksi_array = json_decode(stripslashes($_POST['produksi']));
        
        foreach($produksi_array as $k){
            #Update status kain menjadi baru
            /*
            $h = $this->produksi_model->tampil_data_edit($k);
            foreach($h->result() as $s){
                $id_kain = $s->id_kain;
            }
        $data = array("status_produksi"=>"Baru");
        $where = array("id_kain"=>$id_kain);
        $this->kain_model->update_data("kain",$data,$where);
        */
            $data = array("status_data"=>"Hapus");
            $where = array("id_produksi"=>$k);
            $this->produksi_model->update_data("produksi",$data,$where);
        }
        
        #Update status kain menjadi baru
        $h = $this->produksi_model->tampil_data_edit($id_produksi);
        foreach($h->result() as $s){
            $id_kain = $s->id_kain;
        }
        $data = array("status_produksi"=>"Baru");
        $where = array("id_kain"=>$id_kain);
        $this->kain_model->update_data("kain",$data,$where);
                
        #update status produksi hapus
        $data = array("status_data"=>"Hapus");
        $where = array("id_produksi"=>$id_produksi);
        $this->produksi_model->update_data("produksi",$data,$where);

        
        
        
       redirect(base_url("produksi/daftar_produksi"));
    }

    function daftar_produksi(){
		
        
        

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
        $this->load->view("admin/produksi/daftar-produksi.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function produksi_tampil(){
		#Mengambil data kain secara serverside#
		$this->load->model("produksi_model");
		$produksi = $this->produksi_model->make_datatables();
		$data = array();
		$start = isset($_POST["start"]) ? $_POST["start"] : 0;
		$no = $start + 1;
        #$d = array();
		foreach($produksi as $r){
		    #Foto
            $foto = $r->foto;
            if($r->foto == ""){$foto = "default.jpg";}
            #Jumlah Produksi
            $d = $this->produksi_model->tampil_data_laba($r->id_produksi);
            #Penjahit
            $penjahit = $this->produksi_model->tampil_data_penjahit_produksi_satu($r->id_produksi);
            if($penjahit->num_rows() > 0){
                foreach($penjahit->result() as $b){ 
                $panjahit_name = $b->nama_penjahit; } 
            }
            else
            {
                $panjahit_name = "";
            }
            
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="id[]" value="'.$r->id_kain.'">';
			$sub_array[] = $no++;
            $sub_array[] = '<img src="'. base_url('upload/kain/'.$foto). '?'.rand(1,3000).'" width="40" height="40">';
			$sub_array[] = $r->jenis_kain;
			$sub_array[] = uang($r->total_harga);
			$sub_array[] = uang($d["jumlah"]);
            $sub_array[] = $r->nama_pemotong;
			$sub_array[] = $panjahit_name;
			$sub_array[] = uang($d["ongkos"]);
            $sub_array[] = uang($d["jual"]);
            $sub_array[] = uang($d["laba"]  - $r->total_harga);
			if($r->status_prod == "Berjalan"){
                $sub_array[] = "
                <a href='".base_url('produksi/produksi/tambah-penjahit/'.$this->enkripsi_url->encode($r->id_produksi))."'>Penjahit</a>
                </span>
                ||
                <span>
                <a href='javascript:;' class='item_selesai' nama-kain='".$r->jenis_kain."' data='".$r->id_produksi."' >Selesai</a>
                </span>
                ||
                <span>
                <a href='".base_url('produksi/produksi/lihat-produksi/'.$this->enkripsi_url->encode($r->id_produksi))."'>Lihat</a>
                </span>
                ||
                <span><a href='javascript:;' class='item_hapus' nama-kain='".$r->jenis_kain."' data='".$r->id_produksi."'>Hapus</a></span>";
            }
            else
            {
                $sub_array[] = "<span>
                <a href='".base_url('produksi/produksi_lihat_produksi/'.$this->enkripsi_url->encode($r->id_produksi))."'>Lihat</a>
                </span>
                ||
                <span><a href='javascript:;' class='item_hapus' nama-kain='".$r->jenis_kain."' data='".$r->id_produksi."'>Hapus</a></span>";
            }
			$data[] = $sub_array;
		}
		#Mengambil data kategori di tabel kategori dan memasukkan ke variabel data#
		$draw = "";
		if(isset($_POST["draw"])){$draw = $_POST["draw"];}

			$output = array(
				"draw" 				=> intval($draw),
				"recordsTotal" 		=> $this->produksi_model->get_all_data(),
				"recordsFiltered" 	=> $this->produksi_model->get_filtered_data(),
				"data"				=> $data
		
		);

		echo json_encode($output);
	}

    function produksi_lihat_produksi($id_produksi){
        $id_produksi = $this->enkripsi_url->decode($id_produksi);
        $this->load->model("produksi_model");
        $this->load->model("penjahit_model");
		
        $produksi = $this->produksi_model->tampil_data_produksi($id_produksi);
        $data["nota"] = $produksi;

        $prod = $this->produksi_model->tampil_d_produksi($id_produksi);
        
        if($prod->num_rows() > 0)
        {
            foreach($prod->result() as $g){
                $jumlah = $g->jumlah_produksi;
                $jual = ($g->harga_jual * $jumlah);
                $ongkos = $g->ongkos_jahit * $jumlah;
                $laba = $jual - $ongkos;
                $j[] = $jumlah;
                $jl[] = $jual;
                $o[]= $ongkos;
                $l[] = $laba;

            }
            $prod = array("jumlah"=>array_sum($j),"jual"=>array_sum($jl),"ongkos"=>array_sum($o),
            "laba"=>array_sum($l));
        }
        else
        {
            $prod = array("jumlah"=>0,"jual"=>0,"ongkos"=>0,"laba"=>0);
        }
        $data["prod"] = $prod;

        $data["penjahit"]= $this->penjahit_model->tampil_data();
        $data["produksi_pem"]= $this->produksi_model->tampil_data_penjahit_produksi($id_produksi);
       

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
        $this->load->view("admin/produksi/produksi-lihat-produksi.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman#
    }

    function laporan_produksi(){
        
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
        $this->load->view("admin/produksi/laporan-produksi.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function laporan_produksi_tampil(){
		$this->load->model("produksi_model");

		$tgl1 = $this->input->post("tgl1");
		$bln1 = $this->input->post("bln1");
		$thn1 = $this->input->post("thn1");

		$tgl2 = $this->input->post("tgl2");
		$bln2 = $this->input->post("bln2");
		$thn2 = $this->input->post("thn2");

		$dari = $thn1."-".$bln1."-".$tgl1;
		$sampai = $thn2."-".$bln2."-".$tgl2;

		$data_lap = array("dari"=>$dari,"sampai"=>$sampai);
		
		$laporan = $this->produksi_model->tampil_data_laporan($data_lap);

		$data["laporan"] = $laporan;
		$data["judul"] = $data_lap;

		#Menampilkan halaman#
		$this->load->view("admin/produksi/laporan-produksi-tampil.php",$data);
        #Menampilkan halaman#
	} 
	
}
?>