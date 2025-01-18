<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller{

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
            } else if($level == "Owner"){
				$this->load->view("owner/template/header.php");
                $this->load->view("owner/template/menu.php");
				$this->load->view("owner/beranda.php");
        		$this->load->view("owner/template/footer.php");
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

	
}
?>