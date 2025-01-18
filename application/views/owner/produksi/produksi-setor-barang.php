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
              <h3 class="box-title">Detail Barang Jahitan</h3>
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
                <td>Nama Barang</td>
                <td><?php echo $s->nama_barang;?></td>
                <td rowspan="3" align="right"> <img src="<?php echo base_url("upload/kain/".$foto);?>" height="140" width="115"></td>
                
                </tr>
                <tr>
                <td>Nama Penjahit</td>
                <td><?php echo $s->nama_penjahit;?></td>
                
                
                </tr>
                <tr>
                <td>Jumlah</td>
                <td><?php echo uang($s->jumlah_produksi);?></td>
                
                
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
              <h3 class="box-title">Data Histori Setoran</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
    <th>Tanggal</th>
    <th>Tanggungan Setor</th>
    <th>Jumlah Setor</th>
    <th>Sisa</th>
    <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  
                  $no = "";
                  foreach($produksi_pem->result() as $p){
                    $no++;
                    if($no == 1){
                        $belum = $p->jumlah_produksi;
                    }
                    else{ $belum = $sisa;}
                  ?>
                <tr>
                <td><?php echo $no; ?></td>
    <td><?php echo tgl_db($p->tanggal);?></td>
    <td><?php echo $belum; ?></td>
    <td><?php echo uang($p->jumlah_setor); ?></td>
    <td><?php echo uang($sisa = $belum - $p->jumlah_setor); ?></td>
    <td><?php echo $p->catatan;?></td>
    <td>
  
 
  <span>
  <a href="#" data-toggle="modal" 
                data-target="#modal-danger<?php echo $p->id_setor;?>">Hapus</a>
  </span>
  <div class="modal modal-danger fade" id="modal-danger<?php echo $p->id_setor;?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus setoran <?php echo $p->nama_barang;?> jumlah <?php echo $p->jumlah_setor?>?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url('produksi/produksi_hapus_setoran/'.$this->enkripsi_url->encode($p->id_setor)."/".$this->enkripsi_url->encode($p->id_d_produksi)."/".$this->enkripsi_url->encode($p->id_produksi));?>">Ya</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  </td>
                
                </tr>    
                  <?php
                 
                }
                  ?>

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
          <h3 class="box-title">Form Tambah Setoran</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('produksi/produksi_simpan_tambah_setoran/'.$this->uri->segment(4)."/".$this->uri->segment(5)) ;?>" method="post" autocomplete="off">
          	
          

          <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal</label>
                  <input type="text" name="tanggal" id="tgl" class="form-control" maxlength="20" required="true" placeholder="Tanggal" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y");?>" onChange="showKode()">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jumlah Setor</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" required onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this)">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Catatan</label>
                  <textarea name="catatan" id="catatan" class="form-control" placeholder="Catatan" required>-</textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-plus"></i> Tambah Data Setoran
          </button>
         
          <a class="btn btn-app"  href="<?php echo base_url("produksi/produksi/tambah-penjahit/".$this->uri->segment(5)) ;?>">
          <i class="fa fa-arrow-left"></i> Kembali
          </a>
            
          </form>
        </div>
        <!-- /.box-body -->
      
      

</div>
    </section>
<?php } ?>