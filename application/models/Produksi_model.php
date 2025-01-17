<?php
class Produksi_Model extends CI_Model{

	    
    function tampil_data_lama(){
        $this->db->select("*");
        $this->db->from("produksi,kain,pemotong");
        $this->db->where("produksi.id_kain = kain.id_kain");
        $this->db->where("produksi.id_pemotong = pemotong.id_pemotong");
        $this->db->order_by("produksi.tanggal","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }


    var $tabel = "produksi, kain, pemotong";
    var $relasi = "produksi.status_data = 'Aktif'";
    var $relasi1 = "produksi.id_kain = kain.id_kain";
    var $relasi2 = "produksi.id_pemotong = pemotong.id_pemotong";
	var $pilih_kolom = array("produksi.*",
        "kain.jenis_kain",
		"kain.foto",
        "kain.total_harga",
		"pemotong.nama_pemotong");
	var $order_kolom = array(null, "jenis_kain", "nama_toko", "harga", "total_harga", "status_bayar","status_produksi",null,null);
	    
    function tampil_data(){
        $this->db->select($this->pilih_kolom);
		$this->db->from($this->tabel);
		$this->db->where($this->relasi);
        $this->db->where($this->relasi1);
        $this->db->where($this->relasi2);

		if(isset($_POST["search"]["value"]))
		{
			$this->db->group_start();
			$this->db->like("kain.foto", $_POST["search"]["value"]);
			$this->db->or_like("kain.jenis_kain", $_POST["search"]["value"]);
			$this->db->or_like("kain.total_harga", $_POST["search"]["value"]);
			$this->db->or_like("pemotong.nama_pemotong", $_POST["search"]["value"]);
			$this->db->group_end();

		}

		if(isset($_POST["order"]))
		{
			$this->db->order_by($this->order_kolom[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}
		else
		{
			$this->db->order_by("produksi.tanggal", "DESC");
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
        $this->db->where($this->relasi1);
        $this->db->where($this->relasi2);


		return $this->db->count_all_results();
	}

    function tampil_data_urut_nama(){
        $this->db->select("*");
        $this->db->from("toko");
        $this->db->where("status_data","Aktif");
        $this->db->order_by("nama_toko","asc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function simpan_data($tabel,$data){
        $this->db->insert($tabel,$data);
    }

    function tampil_data_edit($id_toko){
        $this->db->select("*");
        $this->db->from("produksi");
        $this->db->where("id_produksi",$id_toko);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_produksi($id_produksi){
        $this->db->select("*");
        $this->db->from("produksi,kain,pemotong");
        $this->db->where("produksi.id_produksi",$id_produksi);
        $this->db->where("produksi.id_pemotong = pemotong.id_pemotong");
        $this->db->where("produksi.id_kain = kain.id_kain");
        
        $hasil = $this->db->get();
        return $hasil;
    }
    function tampil_data_pemotong_produksi($id_produksi){
        $this->db->select("*");
        $this->db->from("d_potong,pemotong");
        $this->db->where("d_potong.id_produksi",$id_produksi);
        $this->db->where("d_potong.id_pemotong = pemotong.id_pemotong");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_penjahit_produksi($id_produksi){
        $this->db->select("*");
        $this->db->from("d_produksi,penjahit");
        $this->db->where("d_produksi.id_produksi",$id_produksi);
        $this->db->where("d_produksi.id_penjahit = penjahit.id_penjahit");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_penjahit_produksi_satu($id_produksi){
        $this->db->select("*");
        $this->db->from("d_produksi,penjahit");
        $this->db->where("d_produksi.id_produksi",$id_produksi);
        $this->db->where("d_produksi.id_penjahit = penjahit.id_penjahit");
        $this->db->order_by("penjahit.nama_penjahit","asc");
        $this->db->limit(1);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_jumlah_setor($id_d_produksi){
        $this->db->select("sum(jumlah_setor) as jumlah");
        $this->db->from("d_setor");
        $this->db->where("id_d_produksi",$id_d_produksi);
        
        $hasil = $this->db->get();
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $setor = $r->jumlah;
            }
        }
        else
        {
            $setor = 0;
        }
        return $setor;
    }

    function tampil_data_d_produksi($id_d_produksi){
        $this->db->select("*");
        $this->db->from("d_produksi,penjahit,produksi,kain");
        $this->db->where("d_produksi.id_d_produksi",$id_d_produksi);
        $this->db->where("d_produksi.id_penjahit = penjahit.id_penjahit");
        $this->db->where("d_produksi.id_produksi = produksi.id_produksi");
        $this->db->where("kain.id_kain = produksi.id_kain");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    

    function update_data($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel,$data);
    }


    function hapus_data($where, $tabel){
        $this->db->where($where);
        $this->db->delete($tabel);
    }

    function tampil_d_produksi($id_produksi){
        $this->db->select("*");
        $this->db->from("d_produksi");
        $this->db->where("id_produksi",$id_produksi);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_laporan($data){
        $dari = $data["dari"];
        $sampai = $data["sampai"];


        $hasil = $this->db->query("select * from 
        produksi,kain where 
        produksi.id_kain = kain.id_kain and
        produksi.tanggal between '$dari' and '$sampai' 
                order by produksi.tanggal asc");
        return $hasil;
    }

    function tampil_jumlah_setor($id_produksi){
        $this->db->select("sum(d_setor.jumlah_setor) as jumlah");
        $this->db->from("d_setor,d_produksi");
        $this->db->where("d_produksi.id_produksi",$id_produksi);
        $this->db->where("d_produksi.id_d_produksi = d_setor.id_d_produksi");
        
        $hasil = $this->db->get();
        return $hasil;
    }


    function tampil_data_setoran($id_d_produksi){
        $this->db->select("*");
        $this->db->from("d_setor,d_produksi");
        $this->db->where("d_setor.id_d_produksi",$id_d_produksi);
        $this->db->where("d_setor.id_d_produksi = d_produksi.id_d_produksi");
        
        $hasil = $this->db->get();
        return $hasil;
    }


    function tampil_data_laba($id_produksi){
        $this->db->select("*");
        $this->db->from("d_produksi");
        $this->db->where("d_produksi.id_produksi",$id_produksi);
        
        $hasil = $this->db->get();
        $j = array();
        $jl = array();
        $o = array();
        $l = array();
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $jumlah = $r->jumlah_produksi;
                $jual = $r->harga_jual * $jumlah;
                $ongkos = $r->ongkos_jahit * $jumlah;
                $laba = $jual - $ongkos;
                $j[] = $jumlah;
                $jl[] = $jual;
                $o[] = $ongkos;
                $l[] = $laba;
            }
            $data = array("jumlah"=>array_sum($j),"ongkos"=>array_sum($o),"jual"=>array_sum($jl),"laba"=>array_sum($l));
        }
        else
        {
            $data = array("jumlah"=>0,"ongkos"=>0,"jual"=>0,"laba"=>0);
        }
        return $data;
        #jumlah, onkgos, jual, laba kotor
    }
}


?>