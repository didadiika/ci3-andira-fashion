<?php
class Purchase_Order_Model extends CI_Model{

	    
    function tampil_data_lama(){
        $this->db->select("*");
        $this->db->from("penjualan,pelanggan");
        $this->db->where("penjualan.id_pelanggan = pelanggan.id_plg");
        $this->db->order_by("penjualan.tanggal","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    var $tabel = "penjualan, pelanggan";
    var $relasi = "penjualan.status_data = 'Aktif'";
    var $relasi1 = "penjualan.id_pelanggan = pelanggan.id_plg";
    var $relasi2 = "penjualan.jenis = 'Purchase Order'";
	var $pilih_kolom = array("penjualan.*",
    "pelanggan.nama");
	var $order_kolom = array(null, "penjualan.tanggal", "penjualan.no_nota", "pelanggan.nama", "penjualan.total", null,"penjualan.status", "penjualan.status_kirim", null);
	    
    function tampil_data(){
        $this->db->select($this->pilih_kolom);
		$this->db->from($this->tabel);
		$this->db->where($this->relasi);
        $this->db->where($this->relasi1);
        $this->db->where($this->relasi2);

		if(isset($_POST["search"]["value"]))
		{
			$this->db->group_start();
			$this->db->like("penjualan.tanggal", $_POST["search"]["value"]);
			$this->db->or_like("penjualan.no_nota", $_POST["search"]["value"]);
			$this->db->or_like("pelanggan.nama", $_POST["search"]["value"]);
			$this->db->or_like("penjualan.total", $_POST["search"]["value"]);
            $this->db->or_like("penjualan.status", $_POST["search"]["value"]);
            $this->db->or_like("penjualan.status_kirim", $_POST["search"]["value"]);
			$this->db->group_end();

		}

		if(isset($_POST["order"]))
		{
			$this->db->order_by($this->order_kolom[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}
		else
		{
			$this->db->order_by("penjualan.tanggal", "DESC");
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

    function tampil_data_provinsi(){
        $this->db->select("*");
        $this->db->from("provinsi");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_kota_per_provinsi($id_provinsi){
        $this->db->select("*");
        $this->db->from("kota");
        $this->db->where("id_provinsi",$id_provinsi);
        $hasil = $this->db->get();
        return $hasil;
    }

    function simpan_data($tabel,$data){
        $this->db->insert($tabel,$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function tampil_data_edit($id_beli){
        $this->db->select("*");
        $this->db->from("pembelian");
        $this->db->where("id_beli",$id_beli);
        
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

    function tampil_data_status_keranjang($id_penjualan){
        $this->db->select("*");
        $this->db->from("pelanggan,penjualan");
        $this->db->where("penjualan.id_penjualan = $id_penjualan");
        $this->db->where("penjualan.id_pelanggan = pelanggan.id_plg");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_data_keranjang($id_penjualan){
        $this->db->select("*");
        $this->db->from("d_penjualan,barang");
        $this->db->where("d_penjualan.id_brg = barang.id_brg");
        $this->db->where("d_penjualan.id_penjualan = $id_penjualan");
        $this->db->order_by("d_penjualan.id_djual","desc");
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function cari_berat_total($id_penjualan){
        $this->db->select("*");
        $this->db->from("d_penjualan,barang");
        $this->db->where("d_penjualan.id_brg = barang.id_brg");
        $this->db->where("d_penjualan.id_penjualan = $id_penjualan");
        
        $hasil = $this->db->get();
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $berat[] = $r->berat * $r->jumlah;
            }
            $b = array_sum($berat);
            return $b;
        }

    }

    function cari_qty_total($id_penjualan){
        $this->db->select("sum(jumlah) as jumlah");
        $this->db->from("d_penjualan");
        $this->db->where("d_penjualan.id_penjualan = $id_penjualan");
        
        $hasil = $this->db->get();
        if($hasil->num_rows() > 0)
        {
            foreach($hasil->result() as $r){
                $qty = $r->jumlah;
            }
            return $qty;
        }

    }

    function tambah_data_keranjang($data){
		$id_penjualan = $data["id_penjualan"];
		$id_barang = $data["id_brg"];
		$harga = $data["harga"];
		$jumlah = $data["jumlah"];
		$sub_total = $data["sub_total"];

		$query_cari = $this->db->query("select * from d_penjualan where 
			id_penjualan='$id_penjualan' and 
			id_brg='$id_barang' and 
			harga='$harga' ");
		$jumlah_data = $query_cari->num_rows();
		if($jumlah_data == 0)
		{
			$this->db->insert("d_penjualan",$data);
		}
		else
		{
			$this->db->query("update d_penjualan set 
				jumlah=jumlah+'$jumlah',
				sub_total=sub_total+'$sub_total' 	
				where 
			id_penjualan='$id_penjualan' and 
			id_brg='$id_barang' and 
			harga='$harga' ");
		}
		$query_total = $this->db->query("select 
		sum(sub_total) as total
		 from d_penjualan
			where id_penjualan='$id_penjualan' ");
		foreach ($query_total->result() as $t) {
			$total_akhir = $t->total;
		}
		$this->db->query("update penjualan set 
				
				total='$total_akhir'
				where 
			id_penjualan='$id_penjualan' ");


    }
    
    function tampil_data_keranjang_per_barang($id_djual){
		$this->db->select("*");
    	$this->db->from("d_penjualan,barang");
    	$this->db->where("d_penjualan.id_djual = '$id_djual' ");
    	$this->db->where("d_penjualan.id_brg = barang.id_brg");
    	$hasil = $this->db->get();
		

		return $hasil;
    }
    
    function hapus_barang_keranjang($id_djual,$id_penjualan){
		$this->db->query("delete from d_penjualan where id_djual='$id_djual' ");

		$query_total = $this->db->query("select 
		sum(sub_total) as total
		 from d_penjualan
			where id_penjualan='$id_penjualan' ");
		foreach ($query_total->result() as $t) {
			$total_akhir = $t->total;
		}
		$this->db->query("update penjualan set 
				total='$total_akhir' 	
				where 
			id_penjualan='$id_penjualan' ");
    }
    
    function hapus_nota($id_penjualan){
		$this->db->query("delete from d_penjualan where id_penjualan='$id_penjualan' ");
		$this->db->query("delete from penjualan where id_penjualan='$id_penjualan' ");
    }
    
    function simpan_nota($id_penjualan){
		$this->db->query("update penjualan set status='Selesai' where id_penjualan='$id_penjualan' ");
	}

    function tampil_data_laporan($data){
        $dari = $data["dari"];
        $sampai = $data["sampai"];


        $hasil = $this->db->query("select * from 
        pelanggan,penjualan,user where 
        penjualan.id_pelanggan = pelanggan.id_plg and 
        penjualan.id_user = user.id_user and 
        penjualan.tanggal between '$dari' and '$sampai' and 
        penjualan.status='Selesai'
                order by penjualan.tanggal asc");
        return $hasil;
    }
}


?>