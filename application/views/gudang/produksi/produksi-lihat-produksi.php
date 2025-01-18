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
                <td rowspan="7" align="right"> <img src="<?php echo base_url("upload/kain/".$foto)."?". rand(1,3000); ?>" height="280" width="230"></td>
                
                </tr>
                <tr>
                <td>Total Harga Kain</td>
                <td><?php echo uang($s->total_harga);?></td>
                
                </tr>
                </tr>
                <tr>
                <td>Jumlah Brg</td>
                <td><?php echo $prod["jumlah"];?></td>
                
                </tr>

                <tr>
                <td>Pemotong</td>
                <td><?php echo $s->nama_pemotong;?></td>
                
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
    <th>Harga</th>
    <th>Ongkos</th>
    <th>Laba Kotor</th>
    <th>Sudah Setor</th>
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
          
          <a class="btn btn-app"  href="<?php echo base_url("produksi/daftar-produksi") ;?>">
          <i class="fa fa-arrow-left"></i> Kembali
          </a>
           
      
      


    </section>
<?php } ?>