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

	  function showKain(){
		var id_kain = $("#id_kain").val();
		
		$.ajax({
			url:"<?php echo base_url('produksi/show_kain/');?>",
			type:"POST",
			data:{"id_kain":id_kain},
			success:function(response){
                
				var kain = JSON.parse(response);
				$("#total").val(kain.total);
				$("#nama").html(kain.nama_toko);
        $("#keterangan").html(kain.keterangan);
			},
			error:function(){ alert("AJAX Gagal"); }
		});
	}


  function hitung(){
    var total = $("#total").val().toString().replace(/\./g,"");
    var jumlah = $("#jumlah").val().toString().replace(/\./g,"");
    var harga = $("#harga").val().toString().replace(/\./g,"");
    var ongkos = $("#ongkos").val().toString().replace(/\./g,"");

    var jual = parseInt(jumlah) * parseInt(harga);
    var beli = parseInt(total);
    var ongkos = parseInt(jumlah) * parseInt(ongkos);

    var laba = parseInt(jual) - parseInt(beli) - parseInt(ongkos);
    $("#laba").val(uang(laba));

  }
    </script>
    
    <section class="content-header">
      <h1>
        Buat Produksi Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cogs"></i> Kelola Produksi</a></li>
        <li class="active">Buat Produksi Baru</li>
      </ol>
    </section>



    <section class="content">


<div class="box">
<div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('produksi/produksi_simpan') ;?>" method="post" autocomplete="off">
          	<!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal</label>
                  <input type="text" name="tanggal" id="tgl" class="form-control" maxlength="20" required="true" placeholder="Tanggal" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y");?>" onChange="showKode()">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Kain</label>
                  <select name="id_kain"  class="form-control" id="id_kain" onChange="showKain()" required>
    <option value='' selected >Pilih*</option>
	<?php
    foreach($kain->result() as $s)
	{

echo"<option value='$s->id_kain'>$s->jenis_kain</option>";

		
	}
	?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Toko</label>
                  <textarea name="nama" id="nama" class="form-control" placeholder="Nama Toko" required readonly></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required readonly></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total Harga Kain</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Total Harga"  readonly  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Pemotong</label>
                  <select name="id_pemotong"  class="form-control" id="id_pemotong" required>
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

            
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-calculator"></i> Mulai Produksi
          </button>
         
          <button class="btn btn-app" type="reset">
          <i class="fa fa-refresh"></i> Ulangi
          </button>
            
          </form>
        </div>
            <!-- /.box-body -->
          </div>
          </section>