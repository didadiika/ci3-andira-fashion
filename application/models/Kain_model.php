<?php
class Kain_Model extends CI_Model{
    var $tabel = "kain";
    var $relasi = "status_data = 'Aktif'";
	var $pilih_kolom = array("*");
	var $order_kolom = array(null, "jenis_kain", "nama_toko", "harga", "total_harga", "status_bayar","status_produksi",null,null);
	    
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
			$this->db->like("jenis_kain", $_POST["search"]["value"]);
			$this->db->or_like("nama_toko", $_POST["search"]["value"]);
			$this->db->or_like("harga", $_POST["search"]["value"]);
			$this->db->or_like("total_harga", $_POST["search"]["value"]);
			$this->db->or_like("status_bayar", $_POST["search"]["value"]);
			$this->db->or_like("status_produksi", $_POST["search"]["value"]);
			$this->db->group_end();

		}

		if(isset($_POST["order"]))
		{
			$this->db->order_by($this->order_kolom[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}
		else
		{
			$this->db->order_by("id_kain", "DESC");
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
	
    function tampil_data_unproduct_all(){
        $this->db->select("*");
        $this->db->from("kain");
        $this->db->where("status_data","Aktif");
        $this->db->where("status_produksi","Baru");
        $this->db->order_by("id_kain","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_unproduct($id_kain){
        $this->db->select("*");
        $this->db->from("kain");
        $this->db->where("id_kain",$id_kain);
        $this->db->where("status_data","Aktif");
        $this->db->where("status_produksi","Baru");
        $this->db->order_by("id_kain","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_urut_nama(){
        $batas = 30; # -30 hari
        $batas = $batas * 24 * 60 * 60;
        $batas = time() - $batas;
        $batas = date("Y-m-d H:i:s",$batas);

        $this->db->select("*");
        $this->db->from("toko");
        $this->db->where("status_data","Aktif");
        $this->db->where("status_produksi != 'Sudah Diproduksi'");
        $this->db->where("create_date < '$batas'");
        
        $this->db->order_by("nama_toko","asc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function simpan_data($tabel,$data){
        $this->db->insert($tabel,$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function tampil_data_edit($id_kain){
        $this->db->select("*");
        $this->db->from("kain");
        $this->db->where("id_kain",$id_kain);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function update_data($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel,$data);
    }
}


?>