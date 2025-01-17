<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pembelian extends CI_Controller{

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


    function toko(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("toko_model");
        $data["toko"] = $this->toko_model->tampil_data();
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
        $this->load->view("admin/pembelian/toko.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function toko_input(){
        $this->load->model("kode_auto");
        $data["kode"] = $this->kode_auto->kd_angka_perulangan("toko","kode_toko");


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
        $this->load->view("admin/pembelian/toko-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function toko_simpan(){
        $kode_toko = $this->input->post("kode");
        $nama_toko = $this->input->post("nama");
        $alamat = $this->input->post("alamat"); 
        $no_hp = $this->input->post("no_hp");

        $data = array("kode_toko"=>$kode_toko,"nama_toko"=>$nama_toko,"alamat"=>$alamat,"no_hp"=>$no_hp);
        $this->load->model("toko_model");
        $this->toko_model->simpan_data("toko",$data);
        
        redirect(base_url('pembelian/toko')); 

    }

    function toko_edit($id_toko){
        $id_toko = $this->enkripsi_url->decode($id_toko);
        
        
        $this->load->model("toko_model");
        $data["toko"] = $this->toko_model->tampil_data_edit($id_toko);

        
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
        $this->load->view("admin/pembelian/toko-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function toko_update(){
        $id_toko = $this->enkripsi_url->decode($this->uri->segment(3));
        
        $kode_toko = $this->input->post("kode");
        $nama_toko = $this->input->post("nama");
        $alamat = $this->input->post("alamat"); 
        $no_hp = $this->input->post("no_hp");

        $data = array("kode_toko"=>$kode_toko,"nama_toko"=>$nama_toko,"alamat"=>$alamat,"no_hp"=>$no_hp);
        $where = array("id_toko"=>$id_toko);

        $this->load->model("toko_model");
        $this->toko_model->update_data("toko",$data,$where);

        redirect(base_url('pembelian/toko')); 
        
    }
    
    function toko_hapus(){
        $id_toko = $this->enkripsi_url->decode($this->uri->segment(3));
        
        $data = array("status_data"=>"Hapus");
        $where = array("id_toko"=>$id_toko);

        $this->load->model("toko_model");
        $this->toko_model->update_data("toko",$data,$where);

        redirect(base_url('pembelian/toko')); 
        
    }



    function pembelian(){
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("pembelian_model");
        $data["pembelian"] = $this->pembelian_model->tampil_data();
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
        $this->load->view("admin/pembelian/pembelian.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function pembelian_input(){
        $this->load->model("toko_model");
        $data["toko"] = $this->toko_model->tampil_data_urut_nama();


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
        $this->load->view("admin/pembelian/pembelian-input.php",$data);
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

    function pembelian_simpan(){
        $id_user = $this->input->post("id_user");
        $tanggal = tgl_pecah($this->input->post("tanggal"));
        $id_toko = $this->input->post("id_toko"); 
        $jenis = $this->input->post("jenis_pembelian");
        $total = uangPecah($this->input->post("total"));
        $bensin = uangPecah($this->input->post("bensin"));
        $keterangan = $this->input->post("keterangan");
        $foto = $this->input->post("foto");
        $folder = "upload/bukti-pembelian/";

        $data = array("id_user"=>$id_user,"id_toko"=>$id_toko,"tanggal"=>$tanggal,
        "jenis_pembelian"=>$jenis,"total"=>$total,"bensin"=>$bensin,"keterangan"=>$keterangan);
        $this->load->model("pembelian_model");
        $id_beli = $this->pembelian_model->simpan_data("pembelian",$data);
        /**Proses Upload foto **/
        
        redirect(base_url('pembelian/pembelian')); 

    }

    function aksi_upload(){
		$config['upload_path']          = './upload/bukti-pembelian/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('berkas')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('v_upload', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('v_upload_sukses', $data);
		}
    }

    function pembelian_edit($id_pembelian){
        $id_pembelian = $this->enkripsi_url->decode($id_pembelian);
        
        $this->load->model("toko_model");
        $data["toko"] = $this->toko_model->tampil_data_urut_nama();
        
        $this->load->model("pembelian_model");
        $data["pembelian"] = $this->pembelian_model->tampil_data_edit($id_pembelian);

        
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
        $this->load->view("admin/pembelian/pembelian-edit.php",$data);
        $this->load->view("admin/template/footer.php");
        

    }

    function pembelian_update(){
        $id_pembelian = $this->enkripsi_url->decode($this->uri->segment(3));
        $id_user = $this->input->post("id_user");
        $tanggal = tgl_pecah($this->input->post("tanggal"));
        $id_toko = $this->input->post("id_toko"); 
        $jenis = $this->input->post("jenis_pembelian");
        $total = uangPecah($this->input->post("total"));
        $bensin = uangPecah($this->input->post("bensin"));
        $keterangan = $this->input->post("keterangan");
        $foto = $this->input->post("foto");
        $folder = "upload/bukti-pembelian/";

        $data = array("id_user"=>$id_user,"id_toko"=>$id_toko,"tanggal"=>$tanggal,
        "jenis_pembelian"=>$jenis,"total"=>$total,"bensin"=>$bensin,"keterangan"=>$keterangan);
        $this->load->model("pembelian_model");
        $where = array("id_beli"=>$id_pembelian);
        $id_beli = $this->pembelian_model->update_data("pembelian",$data,$where);
        /**Proses Upload foto **/
        
        #redirect(base_url('pembelian/pembelian')); 

    }
    

    function pembelian_hapus($id_beli){
        $id_beli = $this->enkripsi_url->decode($id_beli);
        $this->load->model("pembelian_model");
        /**Hapus foto* */
        $pembelian = $this->pembelian_model->tampil_data_edit($id_beli);
        foreach($pembelian->result() as $r){
            $link_foto = $r->link_foto;
        }
        if($link_foto)
        {
            unlink($link_foto);
        }
        /** Hapus data**/
        $where = array("id_beli"=>$id_beli);
        $this->pembelian_model->hapus_data($where,"pembelian");
        redirect(base_url('pembelian/pembelian'));
    }



    function laporan_pembelian(){
        
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
        $this->load->view("admin/pembelian/laporan-pembelian.php");
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }


    function laporan_pembelian_tampil(){
		$this->load->model("pembelian_model");

		$tgl1 = $this->input->post("tgl1");
		$bln1 = $this->input->post("bln1");
		$thn1 = $this->input->post("thn1");

		$tgl2 = $this->input->post("tgl2");
		$bln2 = $this->input->post("bln2");
		$thn2 = $this->input->post("thn2");

		$dari = $thn1."-".$bln1."-".$tgl1;
		$sampai = $thn2."-".$bln2."-".$tgl2;

		$data_lap = array("dari"=>$dari,"sampai"=>$sampai);
		
		$laporan = $this->pembelian_model->tampil_data_laporan($data_lap);

		$data["laporan"] = $laporan;
		$data["judul"] = $data_lap;

		#Menampilkan halaman#
		$this->load->view("admin/pembelian/laporan-pembelian-tampil.php",$data);
        #Menampilkan halaman#
	} 
	
}
?>