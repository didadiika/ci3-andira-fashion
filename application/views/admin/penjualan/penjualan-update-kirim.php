<script>
	function showKode(){
		var tanggal = $("#tgl").val();

		$.ajax({
			url:"<?php echo base_url('penjualan/show_kode_penjualan/');?>",
			type:"POST",
			data:{"tanggal":tanggal},
			success:function(response){
				$("#no_nota").val(response);
				
			},
			error:function(){ alert("AJAX Gagal"); }
		});
	}

    function showPelanggan_id(){
		var id_pelanggan = $("#id_pelanggan").val();
		
		$.ajax({
			url:"<?php echo base_url('penjualan/show_pelanggan_id/');?>",
			type:"POST",
			data:{"id_pelanggan":id_pelanggan},
			success:function(response){
                
				var pelanggan = JSON.parse(response);
				$("#alamat").html(pelanggan.alamat);
				$("#kota").val(pelanggan.kota);
				$("#no_hp").val(pelanggan.no_hp);
			},
			error:function(){ alert("AJAX Gagal"); }
		});
	}
    </script>
    
    <section class="content-header">
      <h1>
        Update Info Pengiriman
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Kelola Penjualan</a></li>
        <li class="active">Daftar Penjualan</li>
      </ol>
    </section>



    <section class="content">


<div class="box">
<div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <?php
    foreach($penjualan->result() as $r){
          $berat = $this->penjualan_model->cari_berat_total($this->enkripsi_url->decode($this->uri->segment(3)));
        ?>
          <form role="form" action="<?php echo base_url('penjualan/penjualan_simpan_pengiriman/'.$this->enkripsi_url->decode($this->uri->segment(3))) ;?>" method="post" autocomplete="off">
          	<!-- text input -->
              <input type="hidden" name="id_user" value="<?php echo $this->session->id_user;?>">
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal Order</label>
                  <input type="text" name="tanggal" class="form-control" maxlength="20" required="true" placeholder="Tanggal" value="<?php echo tgl_db($r->tanggal);?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Nota</label>
                  <input type="text" name="no_nota" id="no_nota" class="form-control" placeholder="No Nota" required  maxlength="100" placeholder="No Nota" value="<?php echo $r->no_nota;?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pelanggan</label>
                  <input type="text" name="no_nota" id="no_nota" class="form-control" placeholder="No Nota" required  maxlength="100" placeholder="No Nota" value="<?php echo $r->nama;?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Total" required  maxlength="100" placeholder="Total" value="<?php echo uang($r->total - $r->ongkir);?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Berat (Gram)</label>
                  <input type="text" name="berat" id="berat" class="form-control" placeholder="Berat" required  maxlength="100" value="<?php echo uang($berat);?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat Kirim</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required><?php echo $r->alamat;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Ekspedisi [<a href="https://www.berdu.id/cek-ongkir" target="_blank">Cek Ongkir</a>]</label>
                  <textarea name="ekspedisi" id="ekspedisi" class="form-control" placeholder="Ekspedisi" required><?php echo $r->ekspedisi;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Resi</label>
                  <textarea name="no_resi" id="no_resi" class="form-control" placeholder="No Resi" required><?php echo $r->no_resi;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Status Kirim</label>
                  <textarea name="status_kirim" id="status_kirim" class="form-control" placeholder="Status Kirim" required><?php echo $r->status_kirim;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Update
          </button>
         
          <button class="btn btn-app" type="button" onClick="self.history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
          </button>
            
          </form>
          <?php
            }
          ?>
        </div>
            <!-- /.box-body -->
          </div>
          </section>