<script>

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
  alert("Order berhasil di copy !");
}

</script>
<section class="content-header">
      <h1>
        Nota Penjualan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Kelola Penjualan</a></li>
        <li class="active">Daftar Penjualan</li>
      </ol>
    </section>



<section class="content">



<div class="box">
  <!--Tombol Tambah Data-->
<?php
foreach($nota->result() as $n){

$jumlah_data = $keranjang->num_rows();
if($jumlah_data > 0){
  $berat = $this->penjualan_model->cari_berat_total($this->enkripsi_url->decode($this->uri->segment(3)));
?>
<div id="p1" class="hide">
Order Nota : <strong>#<?php echo $n->no_nota;?></strong> </br>
Tanggal : <?php echo tgl_db($n->tanggal);?> </br>
Pelanggan : <?php echo $n->nama;?> </br>
Alamat : <?php echo $n->alamat;?> </br>
Berat Gram : <?php echo uang($berat) ." Gram";?> </br>
Grand Total : <?php echo uang($n->total);?> </br>
Ekspedisi : <?php echo $n->ekspedisi." - ".$n->no_resi." - ".$n->status_kirim; ?> </br>
</div>

            <div class="box-header">
              <h3 class="box-title">Daftar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<table width="50%">
	<tr>
	<td>No Nota :</td><td><strong>#<?php echo $n->no_nota;?></strong></td>
	</tr>
	<tr>
	<td>Tanggal :</td><td><?php echo tgl_db($n->tanggal);?></td>
	</tr>
    <tr>
	<tr>
	<td>Pelanggan :</td><td><?php echo $n->nama." - ".$n->nama_pelanggan;?></td>
	</tr>
  <tr>
	<td>Alamat :</td><td><?php echo $n->alamat;?></td>
	</tr>
  <tr>
	<td>Berat Total (gram):</td><td><?php echo uang($berat) ." gram";?></td>
	</tr>
  <tr>
	<td>Ekspedisi :</td><td><?php echo $n->ekspedisi." - ".$n->no_resi." - ".$n->status_kirim; ?></td>
	</tr>
	</table>
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Barang</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Sub Total</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  foreach ($keranjang->result() as $k) {
                    $no++;
                  ?>
                <tr>
	<td><?php echo $k->nama_barang;?></td>
	<td align="right"><?php echo uang($k->harga);?></td>
	<td align="right"><?php echo uang($k->jumlah);?></td>
	<td align="right"><?php echo uang($k->harga * $k->jumlah);?></td>
	</tr>
	<?php 
	$t[] = $k->harga * $k->jumlah;
	} 
	?>
	<tr>
		<td colspan="3"><strong>Ongkir</strong></td>
		<td align="right"><strong><?php echo uang($n->ongkir);?></strong></td>
	</tr>
  <tr>
		<td colspan="3"><strong>Total</strong></td>
		<td align="right"><strong><?php echo uang(array_sum($t)+ $n->ongkir);?></strong></td>
	</tr>
                </tbody>
              </table>
            </div>
            </div>

            <br>
	<button class="btn btn-app" onclick="self.history.back()"><i class="fa fa-arrow-left"></i> Kembali</button>

  <a class="btn btn-app" href="#" data-toggle="modal" 
                data-target="#modal-danger"><i class="fa fa-trash"></i> Hapus Transaksi</a>

  <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus Transaksi ini, Proses ini tidak bisa dibatalkan ?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url('penjualan/penjualan_hapus_nota/'.$this->enkripsi_url->decode($this->uri->segment(3)));?>">Ya</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <a class="btn btn-app" target="_blank" href="<?php echo base_url("penjualan/penjualan_cetak_nota/".$this->uri->segment(3));?>" ><i class="fa fa-print"></i> Cetak Nota</a>
        <a class="btn btn-app" href="#" onclick="copyToClipboard('#p1')"><i class="fa fa-copy"></i> Share ke Clipboard</a>
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


}
?>
            <!-- /.box-body -->
          </div>
          </section>