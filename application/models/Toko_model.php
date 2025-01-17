<?php
class Toko_Model extends CI_Model{

	    
    function tampil_data(){
        $this->db->select("*");
        $this->db->from("toko");
        $this->db->where("status_data","Aktif");
        
        $hasil = $this->db->get();
        return $hasil;
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
        $this->db->from("toko");
        $this->db->where("id_toko",$id_toko);
        
        $hasil = $this->db->get();
        return $hasil;
    }

    function update_data($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel,$data);
    }
}


?>