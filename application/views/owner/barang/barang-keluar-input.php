<script>
function hitungStok(){
    var stok = $("#stok").val();
    var jumlah = $("#jumlah").val().toString().replace(/\./g,"");;

    var stok_akhir = parseInt(stok) - parseInt(jumlah);

    $("#stok_akhir").val(uang(stok_akhir));
}

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
        Barang Keluar Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cube"></i> Barang</a></li>
        <li class="active">Barang Keluar</li>
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
        foreach($barang->result() as $r){
        ?>
          <form role="form" action="<?php echo base_url('barang/barang_keluar_simpan'); ?>" method="post" autocomplete="off">
            <!-- text input -->
            <input type="hidden" name="id_brg" value="<?php echo $r->id_brg;?>">
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal</label>
                  <input type="text" name="tanggal" id="tgl" class="form-control" maxlength="20" required="true" autofocus="true" placeholder="Tanggal" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y");?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Barang</label>
                  <input type="text" name="kode" id="kode" class="form-control" maxlength="32" placeholder="No / Kode Barang" readonly value="<?php echo $r->kode_barang;?>" >
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Barang</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang"  required  maxlength="100" readonly value="<?php echo $r->nama_barang;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Stok Awal</label>
                  <input type="text" name="stok" id="stok" class="form-control" placeholder="Stok Awal"  required  maxlength="100" readonly value="<?php echo $stok;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jumlah Keluar</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungStok();" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Stok Akhir</label>
                  <input type="text" name="stok_akhir" id="stok_akhir" class="form-control" placeholder="Stok Akhir"  required  maxlength="100" readonly value="<?php echo $stok;?>">
                  <span class="help-block" id="pesanNama"></span>
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