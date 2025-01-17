<?php
class Pelanggan_Model extends CI_Model{

	    
    function tampil_data_lama(){
        $this->db->select("*");
        $this->db->from("pelanggan");
        $this->db->where("status_data","Aktif");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    var $tabel = "pelanggan";
    var $relasi = "status_data = 'Aktif'";
	var $pilih_kolom = array(
        "*");
	var $order_kolom = array(null, "no", "nama", "alamat", "kota","no_hp",null);
	    
    function tampil_data(){
        /*$this->db->select("*");
        $this->db->from("kain");
        $this->db->where("status_data","Aktif");
        $this->db->order_by("id_kain","desc");
        
        $hasil = $this->db->get();
        return $hasil;*/
        
        $this->db->select($this->pilih_kolom);
		$this->db->from($this->tabel);
		$this->db->where($this->relasi);

		if(isset($_POST["search"]["value"]))
		{
			$this->db->group_start();
			$this->db->like("no", $_POST["search"]["value"]);
			$this->db->or_like("nama", $_POST["search"]["value"]);
			$this->db->or_like("alamat", $_POST["search"]["value"]);
			$this->db->or_like("kota", $_POST["search"]["value"]);
			$this->db->or_like("no_hp", $_POST["search"]["value"]);
			$this->db->group_end();

		}

		if(isset($_POST["order"]))
		{
			$this->db->order_by($this->order_kolom[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}
		else
		{
			$this->db->order_by("id_plg", "ASC");
		}
    }
    
    function make_datatables(){
		$this->tampil_data();
		if(isset($_POST["length"]) && isset($_POST["start"]))
		{
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		}
		$query = $this->db->get();

		return $query->result();
	}

	function get_filtered_data(){
		$this->tampil_data();
		$query = $this->db->get();

		return $query->num_rows();
	}

	function get_all_data(){
		$this->db->select("*");
		$this->db->from($this->tabel);
        $this->db->where($this->relasi);


		return $this->db->count_all_results();
	}

    function tampil_kota($id_provinsi){
        $this->db->select("*");
        $this->db->from("kota");
        $this->db->where("id_provinsi",$id_provinsi);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function cari_nama_kota($id_kota){
        $this->db->select("*");
        $this->db->from("kota");
        $this->db->where("id_kota",$id_kota);
        
        $hasil = $this->db->get();
        foreach($hasil->result() as $r)
        {
            $kota = $r->kota;
        }
        return $kota;
    }

    function simpan_data($tabel,$data){
        $this->db->insert($tabel,$data);
    }

    function tampil_data_edit($id_plg){
        $this->db->select("*");
        $this->db->from("pelanggan,kota");
        $this->db->where("pelanggan.id_plg",$id_plg);
        $this->db->where("pelanggan.id_kota = kota.id_kota");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_pelanggan_alamat($id_pelanggan){
        $this->db->select("*");
        $this->db->from("pelanggan,kota,provinsi");
        $this->db->where("pelanggan.id_plg",$id_pelanggan);
        $this->db->where("pelanggan.id_kota = kota.id_kota");
        $this->db->where("kota.id_provinsi = provinsi.id_provinsi");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function update_data($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel,$data);
    }
}


?>