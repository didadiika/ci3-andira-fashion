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



<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INVOICE</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/print.css" type="text/css" />

</head>
<style>
@media print {
input.noPrint { display: none; }
}
</style>
<body class="body">
<div id="wrapper">
<table width="100%">
  <tr>
    <td width="80%"><h2 class="head">INVOICE</h2></td>
    <td width="20%"><img src="<?php echo base_url('assets/foto/logo-kecil-asli.png');?>"></td>
  </tr>
  </table>

  <!--Tombol Tambah Data-->
<?php
foreach($nota->result() as $n){

$jumlah_data = $keranjang->num_rows();
if($jumlah_data > 0){
  $berat = $this->penjualan_model->cari_berat_total($this->enkripsi_url->decode($this->uri->segment(3)));
  $qty = $this->penjualan_model->cari_qty_total($this->enkripsi_url->decode($this->uri->segment(3)));
?>


 
    <table class='tabel'>
	<tr>
	<td>No Nota</td><td>:</td><td><strong>#<?php echo $n->no_nota;?></strong></td>
	<td rowspan="4" width="27%"><strong>
	<?php if(!empty($n->jatuh_tempo)){ ?>
	Tempo <?php echo round((strtotime($n->jatuh_tempo) - strtotime($n->tanggal)) / (24*60*60))." Hari";?>
	</br>Jatuh Tempo (<?php echo tgl_db($n->jatuh_tempo);?>) <?php } else{ echo "<span style='font-size:24px;'>LUNAS</span>";} ?></strong></td>
	</tr>
	<tr>
	<td>Nota</td><td>:</td><td><strong><?php echo $n->jenis;?></strong></td>
	</tr>
	<tr>
	<td>Tanggal</td><td>:</td><td><?php echo tgl_db($n->tanggal);?></td>
	</tr>
	<tr>
	<td>Pengirim</td><td>:</td><td>Andira Fashion / Arfa Casual</td>
	</tr>
	</table>

    <table class='tabel'>
	<tr><td><strong><?php echo ucwords(strtolower($n->nama." - ".$n->nama_pelanggan));?></strong></td><td colspan="2"><strong><?php echo ucwords(strtolower($n->alamat));?>
	</br>
	<?php echo $n->no_hp;?>
	</strong></td>
	</tr>
	<tr>
	<td>Ekspedisi</td><td width="3%">:</td><td><?php echo $n->ekspedisi." - ".$n->no_resi." - ".$n->status_kirim; ?></td>
	</tr>
  <tr>
	<td>Berat Total (gram)</td><td>:</td><td><?php echo uang($berat) ." gram";?></td>
	</tr>
	<tr>
	<td>Total Item</td><td>:</td><td><?php echo $keranjang->num_rows();?></td>
	</tr>
	<tr>
	<td>Total Qty</td><td>:</td><td><?php echo $qty;?></td>
	</tr>
	<tr>
	<td>Catatan</td><td>:</td><td></td>
	</tr>
  
	</table>
              
              <table class="tabel">
                <thead>
                <tr>
            <td><strong>Barang</strong></td>
			<td><strong>Harga</strong></td>
			<td><strong>Jumlah</strong></td>
			<td><strong>Sub Total</strong></td>
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
  $j[] = $k->jumlah;
	} 
	?>
	<tr>
		<td colspan="3"><strong>Ongkir</strong></td>
		<td align="right"><strong><?php echo uang($n->ongkir);?></strong></td>
	</tr>
    <tr>
		<td colspan="3"><strong>Total</strong></td>
		<td align="right"><strong><?php echo uang(array_sum($t) + $n->ongkir);?></strong></td>
	</tr>
                </tbody>
              </table>
            

            <br>
			<?php 
			$id_penjualan = $this->enkripsi_url->decode($this->uri->segment(3));
			$bayar = $this->db->query("select * from pembayaran where id_penjualan='$id_penjualan' order by tanggal asc");
			if($bayar->num_rows() > 0) { ?>
			<h4>Riwayat Pembayaran</h4>
			<table class="tabel">
            <thead>
            <tr>
            <td>Tanggal</td>
			<td>Metode Bayar</td>
			<td>Nominal</td>
			<td>Kurang Bayar</td>
            </tr>
            </thead>
            
			<tbody>
				<?php 
				$sisa = array_sum($t) + $n->ongkir;
				foreach($bayar->result() as $r){ ?>
				<tr>
					<td><?php echo tgl_db($r->tanggal);?></td>
					<td><?php echo $r->metode_bayar;?></td>
					<td><?php echo uang($r->nominal);?></td>
					<td><?php echo uang($sisa = $sisa - $r->nominal);?></td>
				</tr>
				<?php } ?>
			</tbody>
			</table>
			<?php } ?>


			<?php 
			$rek = $this->db->query("select * from rekening");
			if($rek->num_rows() > 0){
			?>
			<table class="tabel">
			<?php
				foreach($rek->result() as $r){
			?>
			<tr>
			<td align="center"><img src="<?php echo base_url($r->link_logo);?>" height="40" width="120"></td>
			<td><strong><?php echo $r->no_rekening;?></strong></td>
			<td><strong><?php echo $r->nama_rekening;?></strong></td>
			</tr>
			<?php
			}
			?>
			</table>
			<?php
			}
			?>
<br>
<br>
    <button class="btn btn-app" onclick="print()"><i class="fa fa-arrow-left"></i> Cetak</button>
    <button class="btn btn-app" onclick="self.history.back()"><i class="fa fa-arrow-left"></i> Kembali</button>

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
           
          



          </body>
</html>