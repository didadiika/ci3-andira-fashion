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
                        if(pelanggan.nama != "UMUM")
                        {
                              $("#nama").attr("readonly",true);
                              $("#alamat").attr("readonly",true);
                              $("#kota").attr("readonly",true);
                              $("#no_hp").attr("readonly",true);

                              $("#nama").val(pelanggan.nama);
                              $("#alamat").html(pelanggan.alamat);
				      $("#kota").val(pelanggan.kota);
				      $("#no_hp").val(pelanggan.no_hp);
                        }
                        else
                        {
                              $("#nama").attr("readonly",false);
                              $("#alamat").attr("readonly",false);
                              $("#kota").attr("readonly",false);
                              $("#no_hp").attr("readonly",false);

                              $("#nama").val("");
                              $("#alamat").html("");
				      $("#kota").val("");
				      $("#no_hp").val("");
                        }
                        
			},
			error:function(){ alert("AJAX Gagal"); }
		});
	}
    </script>
    
    <section class="content-header">
      <h1>
        Buat Penjualan Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Kelola Penjualan</a></li>
        <li class="active">Buat Penjualan Baru</li>
      </ol>
    </section>



    <section class="content">


<div class="box">
<div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('penjualan/penjualan_buat_nota') ;?>" method="post" autocomplete="off">
          	<!-- text input -->
              <input type="hidden" name="id_user" value="<?php echo $this->session->id_user;?>">
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal</label>
                  <input type="text" name="tanggal" id="tgl" class="form-control" maxlength="20" required="true" placeholder="Tanggal" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y");?>" onChange="showKode()">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Nota</label>
                  <input type="text" name="no_nota" id="no_nota" class="form-control" placeholder="No Nota" required  maxlength="100" placeholder="No Nota" value="<?php echo $no_nota;?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Pelanggan</label>
                  <select name="id_pelanggan"  class="form-control select2" style="width: 100%;" id="id_pelanggan" onChange="showPelanggan_id()" required>
                  </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Pelanggan</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat Pelanggan</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Kota Pelanggan</label>
                  <input type="text" name="kota" id="kota" class="form-control" placeholder="Kota"   maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No HP Pelanggan</label>
                  <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="No HP" maxlength="15" >
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Ekspedisi [<a href="https://www.berdu.id/cek-ongkir" target="_blank">Cek Ongkir</a>]</label>
                  <textarea name="ekspedisi" id="ekspedisi" class="form-control" placeholder="Ekspedisi" required></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-arrow-right"></i> Lanjutkan
          </button>
         
          <button class="btn btn-app" type="reset">
          <i class="fa fa-refresh"></i> Ulangi
          </button>
            
          </form>
        </div>
            <!-- /.box-body -->
          </div>
          </section>