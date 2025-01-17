<script>
	function uang(b)
  { 
  var _minus = false;
  if (b<0) _minus = true;
  b = b.toString();
  b=b.replace(".","");
  b=b.replace("-","");
  c = "";
  panjang = b.length;
  j = 0;
  for (i = panjang; i > 0; i--){
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)){
       c = b.substr(i-1,1) + "." + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
  }
  if (_minus) c = "-" + c ;
    
  hasil = c;
  return hasil;
  }
</script>

<section class="content-header">
      <h1>
        Edit Pembelian
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-arrow-down"></i> Kelola Pembelian</a></li>
        <li class="active">Transaksi Pembelian</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <?php
        foreach($pembelian->result() as $s){
        ?>
          <form role="form" action="<?php echo base_url('pembelian/pembelian_update/'.$this->enkripsi_url->encode($s->id_beli)); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <!-- text input -->
            <input type="hidden" name="id_user" value="<?php echo $this->session->id_user;?>">

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal</label>
                  <input type="text" name="tanggal" id="tgl" class="form-control" maxlength="20" required="true" autofocus="true" placeholder="Tanggal" data-date-format="dd-mm-yyyy" value="<?php echo tgl_db($s->tanggal);?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Toko</label>
                  <select name="id_toko"  class="form-control" id="id_toko" >
    <option value='' selected >Pilih*</option>
  <?php
    foreach($toko->result() as $r)
  {
    if($s->id_toko == $r->id_toko)
    {
        echo"<option value='$r->id_toko' selected='$s->id_toko' >$r->nama_toko</option>";
    }
    else
    {
        echo"<option value='$r->id_toko'>$r->nama_toko</option>";
    }
    
  }
  ?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jenis Pembelian</label>
                  <input type="text" name="jenis_pembelian" id="jenis_pembelian" class="form-control" placeholder="Jenis Pembelian" required  maxlength="100" value="<?php echo $s->jenis_pembelian;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total Belanja</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Total Belanja" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="<?php echo uang($s->total);?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Bensin</label>
                  <input type="text" name="bensin" id="bensin" class="form-control" placeholder="Bensin" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="<?php echo uang($s->bensin);?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required ><?php echo $s->keterangan;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Foto Nota</label>
                  <input type="file" name="foto" id="foto" class="form-control" placeholder="Pilih" accept="image/*">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tempatfoto" class="form-group">

            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Simpan
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
      <!-- /.row -->
    </section>