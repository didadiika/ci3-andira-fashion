<?php
class Barang_Keluar_Model extends CI_Model{

	    
    function tampil_data_lama(){
        $this->db->select("*");
        $this->db->from("barang");
        $this->db->where("status_data","Aktif");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    var $tabel = "barang, keluar_brg";
    var $relasi = "barang.status_data = 'Aktif'";
    var $relasi1 = "barang.id_brg = keluar_brg.id_brg";
	var $pilih_kolom = array(
        "*");
	var $order_kolom = array(null, "keluar_brg.tanggal", "barang.nama_barang", "keluar_brg.jumlah", null);
	    
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
        $this->db->where($this->relasi1);

		if(isset($_POST["search"]["value"]))
		{
			$this->db->group_start();
			$this->db->like("keluar_brg.tanggal", $_POST["search"]["value"]);
			$this->db->or_like("barang.nama_barang", $_POST["search"]["value"]);
			$this->db->or_like("keluar_brg.jumlah", $_POST["search"]["value"]);
			$this->db->group_end();

		}

		if(isset($_POST["order"]))
		{
			$this->db->order_by($this->order_kolom[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}
		else
		{
			$this->db->order_by("keluar_brg.tanggal", "DESC");
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


		return $this->db->count_all_results();
	}

    function tampil_harga_per_barang($id_brg){
        $this->db->select("*");
        $this->db->from("harga_brg,harga_jenis");
        $this->db->where("harga_brg.id_brg",$id_brg);
        $this->db->where("harga_brg.id_jh = harga_jenis.id_jh");
        $this->db->order_by("harga_brg.id_jh","asc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_barang_stok($id_brg){
        $this->db->select("*");
        $this->db->from("barang,stok_brg");
        $this->db->where("barang.id_brg",$id_brg);
        $this->db->where("barang.id_brg = stok_brg.id_brg");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_harga(){
        $this->db->select("*");
        $this->db->from("harga_jenis");
        $this->db->order_by("id_jh","asc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_harga_barang($id_barang,$id_jh){
        $this->db->select("*");
        $this->db->from("harga_brg");
        $this->db->where("id_brg",$id_barang);
        $this->db->where("id_jh",$id_jh);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function simpan_data($tabel,$data){
        $this->db->insert($tabel,$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function tampil_data_edit($id_barang){
        $this->db->select("*");
        $this->db->from("barang");
        $this->db->where("id_brg",$id_barang);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function update_data($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel,$data);
    }

    function kurangi_stok($id_barang,$jumlah){
		$this->db->query("update stok_brg set sisa=sisa-'$jumlah' where id_brg='$id_barang' ");
		
    }
    
    function tambah_stok_per_barang($id_barang,$jumlah){
		$this->db->query("update stok_brg set sisa=sisa+'$jumlah' where id_brg='$id_barang' ");
	}




    /***Barang Masuk */
    function tampil_data_barang_masuk(){
        $this->db->select("*");
        $this->db->from("keluar_brg,barang");
        $this->db->where("keluar_brg.id_brg = barang.id_brg");
        $this->db->order_by("keluar_brg.tanggal","desc");
        $this->db->order_by("keluar_brg.id_masuk","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_barang_masuk_dengan_id_masuk($id_masuk){
        $this->db->select("*");
        $this->db->from("keluar_brg,barang");
        $this->db->where("keluar_brg.id_brg = barang.id_brg");
        $this->db->where("keluar_brg.id_masuk = $id_masuk");
        $hasil = $this->db->get();
        return $hasil;
    }

    
    function cari_stok_akhir($id_barang){
        $this->db->select("*");
        $this->db->from("stok_brg,barang");
        $this->db->where("stok_brg.id_brg = $id_barang");
        $this->db->where("stok_brg.id_brg = barang.id_brg");
        $hasil = $this->db->get();
        return $hasil;
    }

    function hapus_data($where, $tabel){
        $this->db->where($where);
        $this->db->delete($tabel);
    }



    function tampil_stok_hari_ini(){
        

        $hasil = $this->db->query("select * from stok_brg, barang where stok_brg.id_brg = barang.id_brg
        order by barang.nama_barang");
        return $hasil;
    }
    

    function tampil_masuk_per_barang_per_hari_ini($id_barang){
        $tgl_hari_ini = date("Y-m-d H:i:s");
        $hasil = $this->db->query("select sum(jumlah) as masuk from keluar_brg where id_brg='$id_barang' and 
        tanggal <= '$tgl_hari_ini' ");
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $masuk = $r->masuk;
            }
        }
        else
        {
                $masuk = 0;
        }
        return $masuk;
    }

    function tampil_keluar_per_barang_per_hari_ini($id_barang){
        $tgl_hari_ini = date("Y-m-d");
        $hasil = $this->db->query("select sum(d_penjualan.jumlah) as keluar from d_penjualan, penjualan where 
        d_penjualan.id_brg='$id_barang' and 
        penjualan.tanggal <= '$tgl_hari_ini' and 
        d_penjualan.id_penjualan = penjualan.id_penjualan and 
        penjualan.status='Selesai' ");
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $keluar = $r->keluar;
            }
        }
        else
        {
                $keluar = 0;
        }
        return $keluar;
    }

    function tampil_masuk_per_barang_periode($id_barang,$sampai){
        $sampai = $sampai." 23:23:59";
        $hasil = $this->db->query("select sum(jumlah) as masuk from keluar_brg where id_brg='$id_barang' and 
        tanggal <= '$sampai' ");
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $masuk = $r->masuk;
            }
        }
        else
        {
                $masuk = 0;
        }
        return $masuk;
    }

    function tampil_keluar_per_barang_periode($id_barang,$sampai){
        $tgl_hari_ini = date("Y-m-d");
        $hasil = $this->db->query("select sum(d_penjualan.jumlah) as keluar from d_penjualan, penjualan where 
        d_penjualan.id_brg='$id_barang' and 
        penjualan.tanggal <= '$sampai' and 
        d_penjualan.id_penjualan = penjualan.id_penjualan and 
        penjualan.status='Selesai' ");
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $keluar = $r->keluar;
            }
        }
        else
        {
                $keluar = 0;
        }
        return $keluar;
    }

    function tampil_data_laporan($data){
        
        $sampai = $data["sampai"];


        $hasil = $this->db->query("select * from stok_brg, barang where stok_brg.id_brg = barang.id_brg
        order by barang.nama_barang");
        return $hasil;
    }
}


?>