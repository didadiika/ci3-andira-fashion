<script type="text/javascript">

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


function hitungTotal(){
    harga = $("#harga").val().toString().replace(/\./g,"");
		jumlah = $("#jumlah").val().toString().replace(/\./g,"");
		ongkos = $("#ongkos").val().toString().replace(/\./g,"");
		
        
    var laba = parseInt(jumlah) * (parseInt(harga) - parseInt(ongkos));
		$("#laba").val(uang(laba));
		
	}
</script>




<?php foreach($nota->result() as $n){ ?>
<section class="content-header">
    <h1>
        Produksi
    </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cogs"></i> Kelola Produksi</a></li>
        <li class="active">Produksi</li>
      </ol>
      
    </section>




    <section class="content">
     
    <div class="box">
  <!--Tombol Tambah Data-->
<?php
if($nota->num_rows() > 0){
?>
            <div class="box-header">
              <h3 class="box-title">Detail Produksi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  foreach($nota->result() as $s){
                    $no++;
                    $foto = "default.jpg";
                    if($s->foto != ""){ $foto = $s->foto;}
                  ?>
                <tr>
                <td>Jenis Kain</td>
                <td><?php echo $s->jenis_kain;?></td>
                <td align="right">Gambar Kain</td>
                </tr>
                <tr>
                <td>Nama Toko</td>
                <td><?php echo $s->jenis_kain;?></td>
                <td rowspan="7" align="right"> <img src="<?php echo base_url("upload/kain/".$foto);?>" height="280" width="230"></td>
                
                </tr>
                <tr>
                <td>Total Harga Kain</td>
                <td><div class='merah'><?php echo uang($s->total_harga);?></td>
                
                </tr>
                </tr>
                <tr>
                <td>Jumlah Brg</td>
                <td><?php echo $prod["jumlah"];?></td>
                
                </tr>
                <tr>
                <td>Ongkos Produksi</td>
                <td><?php echo uang($prod["ongkos"]);?></td>
                
                </tr>
                <tr>
                <td>Harga Jual</td>
                <td><?php echo uang($prod["jual"]);?></td>
                
                </tr>
                <tr>
                <td>Laba (Rugi) Bersih</td>
                <td><strong><?php echo uang($prod["laba"] - $s->total_harga);?></strong></td>
                
                </tr>  
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            </div>
<?php
}
else
{
  echo"
  <div class='callout callout-danger'>
        Data tidak ditemukan.
      </div>
  ";
}
?>
            <!-- /.box-body -->
          </div>

         
  <!--Tombol Tambah Data-->
<?php
if($produksi_pem->num_rows() > 0){
?>
 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Penjahit Produksi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
    <th>Penjahit</th>
    <th>Barang</th>
    <th>Jml</th>
    <th>Harga Jual</th>
    <th>Ongkos</th>
    <th>Laba Kotor</th>
    <th>Sudah Setor</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  
                  $no = "";
                  foreach($produksi_pem->result() as $p){
                    $no++;
                    $setor = $this->produksi_model->tampil_data_jumlah_setor($p->id_d_produksi);
                  ?>
                <tr>
                <td><?php echo $no; ?></td>
    <td><?php echo $p->nama_penjahit. "  [" .$p->alamat."]";?></td>
    <td><?php echo $p->nama_barang; ?></td>
    <td><?php echo uang($p->jumlah_produksi); ?></td>
    <td><?php echo uang($p->harga_jual); ?></td>
    <td><?php echo uang($p->ongkos_jahit); ?></td>
    <td><?php echo uang($p->jumlah_produksi * ($p->harga_jual - $p->ongkos_jahit)); ?></td>
    <td><?php echo $setor; ?></td>
    <td>
  
  <span>
  <a href="<?php echo base_url('produksi/produksi/setor-barang/'.$this->enkripsi_url->encode($p->id_d_produksi)."/".$this->enkripsi_url->encode($p->id_produksi));?>" >Setoran Barang</a>
  </span>
  ||
  <span>
  <a href="#" data-toggle="modal" 
                data-target="#modal-danger<?php echo $p->id_d_produksi;?>">Hapus</a>
  </span>
  <div class="modal modal-danger fade" id="modal-danger<?php echo $p->id_d_produksi;?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus Barang produksi <?php echo $p->nama_barang;?> ?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url('produksi/produksi_hapus_produksi_penjahit/'.$this->enkripsi_url->encode($p->id_d_produksi)."/".$this->enkripsi_url->encode($p->id_produksi));?>">Ya</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  </td>
                
                </tr>    
                  <?php
                  $j[] = $p->jumlah_produksi;
                  $h[] = $p->harga_jual * $p->jumlah_produksi;
                  $o[] = $p->ongkos_jahit * $p->jumlah_produksi;
                  $l[] = $p->jumlah_produksi * ($p->harga_jual - $p->ongkos_jahit);
                  $st[] = $setor;
                  }
                  ?>
    <tr>
    <td colspan="3"><strong>Total</strong></td>
    <td><strong><?php echo array_sum($j);?></strong></td>
    <td><strong><?php echo uang(array_sum($h));?></strong></td>
    <td><strong><?php echo uang(array_sum($o));?></strong></td>
    <td><strong><?php echo uang(array_sum($l));?></strong></td>
    <td><strong><?php echo uang(array_sum($st));?></strong></td>
    <td></td>
    </tr>
                </tbody>
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
<?php
}
?>
              	

      <div class="box box-warning">

        <div class="box-header with-border">
          <h3 class="box-title">Form Tambah Penjahit</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('produksi/produksi_simpan_tambah_penjahit/'.$this->uri->segment(4)) ;?>" method="post" autocomplete="off">
          	
          	
	
            

            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Penjahit</label>
                  <select name="id_penjahit"  class="form-control" id="id_penjahit" >
    <option value='' selected >Pilih*</option>
  <?php
    foreach($penjahit->result() as $s)
  {
    echo"<option value='$s->id_penjahit'>$s->nama_penjahit</option>";
  }
  ?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Barang</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang" required>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jumlah Barang</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" required onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Ongkos Jahit (per Barang)</label>
                  <input type="text" name="ongkos" id="ongkos" class="form-control" placeholder="Ongkos" required value="0" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Harga Jual (per Barang)</label>
                  <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga Jual" required value="0" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Laba Barang</label>
                  <input type="text" name="laba" id="laba" class="form-control" placeholder="Laba" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-plus"></i> Tambah Data Produksi
          </button>
         
          <a class="btn btn-app"  href="<?php echo base_url("produksi/daftar-produksi") ;?>">
          <i class="fa fa-arrow-left"></i> Kembali
          </a>
            
          </form>
        </div>
        <!-- /.box-body -->
      
      

</div>
    </section>
<?php } ?>