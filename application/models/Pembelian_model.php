<?php
class Pembelian_Model extends CI_Model{

	    
    function tampil_data(){
        $this->db->select("*");
        $this->db->from("pembelian,toko");
        $this->db->where("pembelian.id_toko = toko.id_toko");
        $this->db->order_by("pembelian.tanggal","desc");
        
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

    function upload_foto(){
        $config['upload_path']          = './upload/bukti-pembelian/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->product_id;
        $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
        return $this->upload->data("file_name");
        }
    
        return "default.jpg";
    }

    function tampil_data_laporan($data){
        $dari = $data["dari"];
        $sampai = $data["sampai"];


        $hasil = $this->db->query("select * from 
        pembelian,toko,user where 
                pembelian.id_toko = toko.id_toko and 
                pembelian.id_user = user.id_user and 
                pembelian.tanggal between '$dari' and '$sampai' 
                order by pembelian.tanggal asc");
        return $hasil;
    }
}


?>