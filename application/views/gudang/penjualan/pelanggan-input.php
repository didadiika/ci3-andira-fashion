<script>
function showKota(){
  var id_provinsi = $("#id_provinsi").val();

  $.ajax({
    url:"<?php echo base_url('penjualan/tampil_kota/');?>",
    type:"POST",
    data:{"id_provinsi":id_provinsi},
    success:function(response){
      $("#id_kota").html(response);
    },
    error:function(){ alert("AJAX Error"); }
  });
}
</script>
<section class="content-header">
      <h1>
        Input Pelanggan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-navicon"></i> Kelola Penjualan</a></li>
        <li class="active">Pelanggan</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('penjualan/pelanggan_simpan'); ?>" method="post" autocomplete="off">
            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Pelanggan</label>
                  <input type="text" name="kode" id="kode" class="form-control" maxlength="32" placeholder="No Pelanggan" autofocus="autofocus">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Pelanggan</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Pelanggan"  required  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Provinsi</label>
                  <select name="id_provinsi"  class="form-control" id="id_provinsi" onChange="showKota()">
    <option value='' selected >Pilih*</option>
	<?php
    foreach($provinsi->result() as $s)
	{

echo"<option value='$s->id_provinsi'>$s->provinsi</option>";

		
	}
	?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Kota</label>
                  <select name="id_kota"  class="form-control" id="id_kota" >
    <option value='' selected >Pilih*</option>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required ></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No HP</label>
                  <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="No HP" required  maxlength="15" >
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Simpan
          </button>
         
          <button class="btn btn-app" type="button" onClick="self.history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
          </button>
            
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>