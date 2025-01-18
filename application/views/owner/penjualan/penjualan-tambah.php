<script type="text/javascript">
const autoNumericOptions = {
    allowDecimalPadding        : false, 
    currencySymbol             : '',
    currencySymbolPlacement    : 'p',
    decimalCharacter           : ',',
    digitGroupSeparator        : '.',
    emptyInputBehavior         : 'zero',
    minimumValue               : '0',
    leadingZero                : 'deny'
};
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


 /* Pembayaran */
function hitungBayar(){
 var ongkir = $("#ongkir").val() == '' ? '0' : $("#ongkir").val();
 var ongkir = parseInt(ongkir.toString().replace(/\./g,""));

 var bayar = $("#bayar").val() == '' ? '0' : $("#bayar").val();
 var bayar = parseInt(bayar.toString().replace(/\./g,""));
 var total_s = parseInt($("#total_s").val().toString().replace(/\./g,""));
 var total = total_s + ongkir;
 var k_bayar = total - bayar;

 if(bayar > total){
  AutoNumeric.set('[name="bayar"]',total);
    $("#k_bayar").val(0);
 }
 else
 {
    $("#total").val(uang(total));
    $("#k_bayar").val(uang(k_bayar));
 }

 if(parseInt($("#k_bayar").val().toString().replace(/\./g,"")) > 0)
 {
    $("#jenis_bayar").val("Tempo");
    $("[name = 'jatuh_tempo']").prop("disabled",false); 
 }
 else
 {
  $("#jenis_bayar").val("Lunas");
  $("[name = 'jatuh_tempo']").val(''); 
  $("[name = 'jatuh_tempo']").prop("disabled",true); 
 }

}

function cekBayar(){

  var metode_bayar = $("[name='metode_bayar']").val();
  var total = parseInt($("#total").val().toString().replace(/\./g,""));

  if(metode_bayar == "Tempo")
  {
    AutoNumeric.set('[name="bayar"]',0);
    $("#bayar").prop("readonly",true);
  } else
  {
    $("#bayar").prop("readonly",false);
  }
  hitungBayar();
}
 

  $(document).ready(function() {

    new AutoNumeric('[name="bayar"]', autoNumericOptions);
    new AutoNumeric('[name="ongkir"]', autoNumericOptions);

  $('#modal-primary').on('shown.bs.modal', function () {
    var grand_total = parseInt($("#grand_total").html().toString().replace(/\./g,""));
    var tanggal = $("#tanggal-nota").html();
    var id_penjualan = $("#id_penjualan").val();

    $.ajax({
      url:"<?php echo base_url("penjualan/get-data-nota");?>",
      type:"GET",
      data:{"id_penjualan":id_penjualan},
      success:function(response){
      var d = JSON.parse(response);

      $("#total_s").val(uang(grand_total));
      $("#total").val(uang(parseInt(grand_total) + parseInt(d.ongkir)));
      $("#k_bayar").val(uang(parseInt(grand_total) + parseInt(d.ongkir)));
      $("#tanggal").val(tanggal);

      $("[name = 'jenis_penjualan']").val(d.jenis).change();
      AutoNumeric.set('[name="bayar"]',0);
      AutoNumeric.set('[name="ongkir"]',d.ongkir);

      },
      error:function(){ console.log('Error modal bayar');}
    });
    
               
    });
  });

</script>

<?php foreach($nota->result() as $n){ ?>
<section class="content-header">
    <h1>
        Buat Nota [Tambah Barang]
    </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Kelola Penjualan</a></li>
        <li class="active">Buat Penjualan Baru</li>
      </ol>
      
    </section>


    <section class="content">
      <table width="100%">
        <tr>
          <td><h3 id="nama-barang" class="pull-left"></h3></td>
          <td><h3 id="harga-barang" class="pull-right"></h3></td>
        </tr>
      </table>
    	<div class="row">
		<div class="col-md-6">

      <div class="box box-warning">

        <div class="box-header with-border">
          <h3 class="box-title">Form Barang</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('penjualan/penjualan_simpan_tambah_barang') ;?>" method="post" autocomplete="off">
          	
          	
	<input type="hidden" name="id_penjualan" id="id_penjualan" value="<?php echo $n->id_penjualan;?>">
            

            <!-- text input -->
            <div class="form-group">
                <label>Pilih Barang</label>
                <select class="form-control select2" style="width: 100%;" name="id_barang" id="id_barang"  required>
                </select>
              </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Stok</label>
                  <input type="text" name="stok" id="stok" class="form-control" placeholder="Stok" required  maxlength="15" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Harga</label>
                  <select name="id_jh"  class="form-control" id="id_jh" onChange="showHarga(),hitungTotal()">
    <option value='' selected >Pilih*</option>
  <?php
    foreach($jenis->result() as $s)
  {
    echo"<option value='$s->id_jh'>$s->nama_jenis</option>";
  }
  ?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Harga Jual</label>
                  <input type="text" name="jual" id="jual" class="form-control" placeholder="Harga Jual" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jumlah</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Sub Total</label>
                  <input type="text" name="sub_total" id="sub_total" class="form-control" placeholder="Sub Total" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-plus"></i> Tambah Barang
          </button>
         
          <button class="btn btn-app" type="reset">
          <i class="fa fa-refresh"></i> Ulangi
          </button>
            
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
      </div>
<div class="col-md-6">
<div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Nota Penjualan <strong>#<?php echo $n->no_nota;?></strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <table class='tabel'>
	<tr>
	<td>Tanggal</td><td id="tanggal-nota"><?php echo tgl_db($n->tanggal);?></td>
	</tr>
    <tr>
	<tr>
	<td>Pelanggan</td><td><?php echo $n->nama." - ".$n->nama_pelanggan;?></td>
	</tr>
	</table>
        <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>Barang</th>
                <th>Berat (gram)</th>
				<th>Harga</th>
				<th>Jumlah</th>
				<th>Sub Total</th>
                <th>Hapus</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  $jumlah_data = $keranjang->num_rows();
				if($jumlah_data > 0){
                foreach ($keranjang->result() as $k) {
                    $no++;
                  ?>
                <tr>
                <td><?php echo $k->nama_barang;?></td>
                <td align="right"><?php echo uang($k->berat);?></td>
        <td align="right"><?php echo uang($k->harga);?></td>
				<td align="right"><?php echo uang($k->jumlah);?></td>
				<td align="right"><?php echo uang($k->sub_total);?></td>
                <td>
                <a href="<?php echo base_url("penjualan/penjualan_hapus_barang_keranjang/".$k->id_djual."/".$k->id_penjualan);?>" onClick="return confirm('Hapus barang <?php echo $k->nama_barang;?> ?')">Hapus</a>
              </td>
                </tr>    
                  <?php 
        $t[] = $k->sub_total;
        $b[] = $k->berat * $k->jumlah;
        $j[] = $k->jumlah;
				} 
				?>
				<tr>
				<td colspan="1"><strong>Total Berat & Jml</strong></td>
				<td align="right"><strong><?php echo uang(array_sum($b))." gram";?></strong></td>
				<td></td>
        <td align="right"><strong><?php echo uang(array_sum($j));?></strong></td>
        <td></td>
        <td></td>
				</tr>
        <tr>
				<td colspan="1"><strong>Grand Total</strong></td>
				<td colspan="4" align="right"><strong><span id="grand_total"><?php echo uang(array_sum($t));?></span></strong></td>
				<td></td>
				</tr>
	<?php } ?>
                </tbody>
              </table>
            </div>
        </div>
        
        <a class="btn btn-app" href="#" data-toggle="modal" 
                data-target="#modal-primary">
          <i class="fa fa-save"></i> Simpan Nota
        </a>

        <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Pembayaran Nota</h4>
              </div>
              <div class="box-body">

              <form role="form" action="<?php echo base_url('penjualan/simpan-penjualan/'.$this->uri->segment(3)) ;?>" method="post" autocomplete="off">


              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal Nota</label>
                  <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>


              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jenis Penjualan</label>
                  <select name="jenis_penjualan"  class="form-control" required>
                  <option value=''>*Pilih</option>
	                  <?php
                    $nama_jenis = array("Penjualan","Purchase Order");
                      foreach($nama_jenis as $s)
	                    {
                        echo"<option value='$s'>$s</option>";
                      }
	                  ?>
                  </select>
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total Sebelum Ongkir</label>
                  <input type="text" name="total_s" id="total_s" class="form-control" placeholder="Total" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Ongkir &nbsp; &nbsp; <a href="https://www.berdu.id/cek-ongkir" target="_blank">Cek Ongkir disini</a></label>
                  <input type="text" name="ongkir" id="ongkir" class="form-control" placeholder="Ongkir" required value="0" onKeyup="hitungBayar()">
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Grand Total</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Grand Total" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jenis Bayar</label>
                  <input type="text" name="jenis_bayar" id="jenis_bayar" class="form-control" placeholder="Jenis Bayar" readonly value="Tempo">
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>

              <!-- text input -->
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Metode Bayar</label>
                  <select name="metode_bayar"  class="form-control" required onChange="cekBayar()">
                  <option value=''>*Pilih</option>
	                  <?php
                    $nama_jenis = array("Tempo","Cash","BCA","BRI","BNI","Mandiri");
                      foreach($nama_jenis as $s)
	                    {
                        echo"<option value='$s'>$s</option>";
                      }
	                  ?>
                  </select>
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Bayar</label>
                  <input type="text" name="bayar" id="bayar" class="form-control" placeholder="Bayar" required onKeyup="hitungBayar()">
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Kurang Bayar (Tempo)</label>
                  <input type="text" name="k_bayar" id="k_bayar" class="form-control" placeholder="Kurang Bayar" readonly value="">
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal Jatuh Tempo</label>
                  <input type="text" name="jatuh_tempo" id="datepicker" data-date-format="dd/mm/yyyy" class="form-control" placeholder="Tanggal Jatuh Tempo" required>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              

              </div>
              <div class="modal-footer">
                <button class="btn btn-outline pull-left" type="submit"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> Batal</a>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <a class="btn btn-app" href="#" data-toggle="modal" 
                data-target="#modal-danger">
          <i class="fa fa-trash"></i> Hapus Nota
        </a>

        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus Nota ?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url("penjualan/penjualan_hapus_nota/".$n->id_penjualan);?>">Ya</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.box-body -->
      </div>
</div>
</div>
    </section>
<?php } ?>