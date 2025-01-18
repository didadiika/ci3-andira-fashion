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

function showBarang_id(){
    var id_barang = $("#id_barang").val();
    

    $.ajax({
      url:"<?php echo base_url('penjualan/penjualan_show_barang_id/');?>",
      type:"POST",
      data:{"id_barang":id_barang},
      success:function(response){
          
        var barang = JSON.parse(response);
        $("#stok").val(barang.stok);
      },
      error:function(){ alert("AJAX Gagal"); }
    });
  }

function showHarga(){
    var id_barang = $("#id_barang").val();
    var id_jh = $("#id_jh").val();

    $.ajax({
      url:"<?php echo base_url('penjualan/penjualan_show_harga_barang/');?>",
      type:"POST",
      data:{"id_barang":id_barang,"id_jh":id_jh},
      success:function(response){
        
        $("#jual").val(uang(response));
      },
      error:function(){ alert("AJAX Gagal"); }
    });
}
  

function hitungTotal(){
        stok = $("#stok").val().toString().replace(/\./g,"");
		jumlah = $("#jumlah").val().toString().replace(/\./g,"");
		jual = $("#jual").val().toString().replace(/\./g,"");
		
        
        if(parseInt(jumlah) > parseInt(stok)){

            $("#jumlah").val(parseInt(stok));
            total = parseInt($("#jumlah").val().toString().replace(/\./g,""))*parseInt(jual);
            $("#sub_total").val(uang(parseInt(total)));
        }
        else
        {
            total = parseInt(jumlah)*parseInt(jual);
            $("#sub_total").val(uang(parseInt(total)));	
        }
		
		
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
                  ?>
                <tr>
                <td>Jenis Kain</td>
                <td><?php echo $s->jenis_kain;?></td>
                
                </tr>
                <tr>
                <td>Nama Toko</td>
                <td><?php echo $s->nama_toko;?></td>
                
                
                </tr>
                <tr>
                <td>Total Harga</td>
                <td><?php echo uang($s->total_harga);?></td>
                
                </tr>
                </tr>
                <tr>
                <td>Jumlah Brg</td>
                <td><?php echo uang($s->jumlah_brg);?></td>
                
                </tr>
                <tr>
                <td>Ongkos Produksi</td>
                <td><?php echo uang($s->ongkos_produksi);?></td>
                
                </tr>
                <tr>
                <td>Harga Jual</td>
                <td><?php echo uang($s->harga_jual);?></td>
                
                </tr>
                <tr>
                <td>Laba</td>
                <td><?php echo uang(  $s->jumlah_brg * ($s->harga_jual - $s->ongkos_produksi)  -  $s->total_harga  );?></td>
                
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
              <h3 class="box-title">Data Pemotong Produksi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
    <th>Pemotong</th>
    <th>Alamat</th>
    <th>Barang</th>
    <th>Jumlah</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  foreach($produksi_pem->result() as $p){
                    $no++;
                  ?>
                <tr>
                <td><?php echo $no; ?></td>
    <td><?php echo $p->nama_pemotong;?></td>
    <td><?php echo $p->alamat;?></td>
    <td><?php echo $p->nama_barang; ?></td>
    <td><?php echo uang($p->jumlah); ?></td>
    <td><span>
  <a href="<?php echo base_url('produksi/produksi_hapus_pemotong/'.$this->enkripsi_url->encode($p->id_d_potong)."/".$p->id_produksi);?>" onClick="return confirm('Hapus Pemotong ini ?')">Hapus</a>
  </span></td>
                
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
          <h3 class="box-title">Form Tambah Pemotong</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('produksi/produksi_simpan_tambah_pemotong/'.$this->uri->segment(3)) ;?>" method="post" autocomplete="off">
          	
          	
	
            

            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Pemotong</label>
                  <select name="id_pemotong"  class="form-control" id="id_pemotong" >
    <option value='' selected >Pilih*</option>
  <?php
    foreach($pemotong->result() as $s)
  {
    echo"<option value='$s->id_pemotong'>$s->nama_pemotong</option>";
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
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jumlah</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" required>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-plus"></i> Tambah Data Potong
          </button>
         
          <a class="btn btn-app"  href="<?php echo base_url("produksi/daftar_produksi") ;?>">
          <i class="fa fa-arrow-left"></i> Kembali
          </a>
            
          </form>
        </div>
        <!-- /.box-body -->
      
      

</div>
    </section>
<?php } ?>