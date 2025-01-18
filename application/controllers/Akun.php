<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller{
	
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
            if($level == "Superadmin")
            {
				$this->load->view("superadmin/template/header.php");
                $this->load->view("superadmin/template/menu.php");
                $this->load->view("superadmin/beranda.php");
        	    $this->load->view("superadmin/template/footer.php");

            } else if($level == "Admin"){
				$this->load->view("admin/template/header.php");
                $this->load->view("admin/template/menu.php");
                $this->load->view("admin/beranda.php");
        	    $this->load->view("admin/template/footer.php");
            } else if($level == "Gudang"){
				$this->load->view("gudang/template/header.php");
                $this->load->view("gudang/template/menu.php");
                $this->load->view("gudang/beranda.php");
        	    $this->load->view("gudang/template/footer.php");
            } 
        	
        	/*
			*	Menampilkan view master template dan halaman beranda
			*
			*/
        
		
	}

	function ganti_password(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("akun_model");
        $data["user"] = $this->akun_model->tampil_data_edit($this->session->id_user);
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Superadmin")
        {
            $this->load->view("superadmin/template/header.php");
			$this->load->view("superadmin/template/menu.php");
			$this->load->view("superadmin/akun/ganti-password.php",$data);

        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
			$this->load->view("admin/template/menu.php");
			$this->load->view("admin/akun/ganti-password.php",$data);
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
			$this->load->view("gudang/template/menu.php");
			$this->load->view("gudang/akun/ganti-password.php",$data);
        }
        
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
	}
    
    function ganti_password_update(){
        $this->load->model("akun_model");
        $id_user = $this->session->id_user;
        $pass1 = $this->input->post("pass1");
        $pass2 = $this->input->post("pass2");
        $pass3 = $this->input->post("pass3");

        
        $dt = $this->akun_model->tampil_data_edit($id_user);
        if($dt->num_rows() > 0)
        {
            foreach($dt->result() as $d){
                $password_sistem = $d->password;
            }
            if(!password_verify($pass1,$password_sistem))
            {
                redirect(base_url('akun/ganti_password_pass_old_error')); 
            }
            else if($pass2 != $pass3)
            {
                redirect(base_url('akun/ganti_password_pass_not_same')); 
            }
            else
            {
                $pass3 = password_hash($pass3,PASSWORD_DEFAULT);
                $data = array("password"=>$pass3);
                $where = array("id_user"=>$id_user);
                $this->akun_model->update_data("user",$data,$where);
                redirect(base_url('akun/ganti_password_success')); 
            }
            
        }

       
        redirect(base_url('akun/ganti_password_success'));
        
        
    }

    function ganti_password_pass_old_error(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("akun_model");
        $data["user"] = $this->akun_model->tampil_data_edit($this->session->id_user);
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Superadmin")
        {
            $this->load->view("superadmin/template/header.php");
			$this->load->view("superadmin/template/menu.php");
			$this->load->view("superadmin/akun/ganti-password-pass-old-error.php",$data);

        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
			$this->load->view("admin/template/menu.php");
			$this->load->view("admin/akun/ganti-password-pass-old-error.php",$data);
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
			$this->load->view("gudang/template/menu.php");
			$this->load->view("gudang/akun/ganti-password-pass-old-error.php",$data);
        } 
        
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }
    
    function ganti_password_pass_not_same(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("akun_model");
        $data["user"] = $this->akun_model->tampil_data_edit($this->session->id_user);
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Superadmin")
        {
            $this->load->view("superadmin/template/header.php");
			$this->load->view("superadmin/template/menu.php");
			$this->load->view("superadmin/akun/ganti-password-pass-not-same.php",$data);

        }  else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
			$this->load->view("admin/template/menu.php");
			$this->load->view("admin/akun/ganti-password-pass-not-same.php",$data);
        } else if($level == "Admin"){
            $this->load->view("gudang/template/header.php");
			$this->load->view("gudang/template/menu.php");
			$this->load->view("gudang/akun/ganti-password-pass-not-same.php",$data);
        }
        
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }
    
    function ganti_password_success(){
        
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#
        $this->load->model("akun_model");
        $data["user"] = $this->akun_model->tampil_data_edit($this->session->id_user);
        #Mengambil data toko di tabel suplier dan memasukkan ke variabel data#

		#Menampilkan halaman suplier dan mem passing variabel data#
        $level = $this->session->level;
        if($level == "Superadmin")
        {
            $this->load->view("superadmin/template/header.php");
			$this->load->view("superadmin/template/menu.php");
			$this->load->view("superadmin/akun/ganti-password-success.php",$data);

        } else if($level == "Admin"){
            $this->load->view("admin/template/header.php");
			$this->load->view("admin/template/menu.php");
			$this->load->view("admin/akun/ganti-password-success.php",$data);
        } else if($level == "Gudang"){
            $this->load->view("gudang/template/header.php");
			$this->load->view("gudang/template/menu.php");
			$this->load->view("gudang/akun/ganti-password-success.php",$data);
        }
        
        $this->load->view("admin/template/footer.php");
        #Menampilkan halaman suplier dan mem passing variabel data#
    }

	function tentang_software(){
		
        $level = $this->session->level;
		if($level == "Superadmin")
		{
			$this->load->view("superadmin/template/header.php");
			$this->load->view("superadmin/template/menu.php");
            $this->load->view("superadmin/akun/tentang-software.php");
            $this->load->view("superadmin/template/footer.php");

		}  else if($level == "Owner"){
			$this->load->view("owner/template/header.php");
			$this->load->view("owner/template/menu.php");
            $this->load->view("owner/akun/tentang-software.php");
            $this->load->view("owner/template/footer.php");
		} else if($level == "Admin"){
			$this->load->view("admin/template/header.php");
			$this->load->view("admin/template/menu.php");
            $this->load->view("admin/akun/tentang-software.php");
            $this->load->view("admin/template/footer.php");
		} else if($level == "Gudang"){
			$this->load->view("gudang/template/header.php");
			$this->load->view("gudang/template/menu.php");
            $this->load->view("gudang/akun/tentang-software.php");
            $this->load->view("gudang/template/footer.php");
		}
        
	}

	function logout(){
        $this->load->model("login_model");

        $this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
?>