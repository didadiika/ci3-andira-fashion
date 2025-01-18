<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAPORAN PENJUALAN</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/print.css" type="text/css" />

</head>
<style>
@media print {
input.noPrint { display: none; }
}
</style>
<body class="body">
<div id="wrapper">

  <h2 class="head">LAPORAN PENJUALAN</h2>
  <table class="tabel" id="myTable">
  <thead>
  <tr>
  <td width="50%">Periode :</td>
  <td align="right"><?php echo tgl_indo($judul["dari"])." - ".tgl_indo($judul["sampai"]);?></td>
  </tr>
  </thead>
  </table>
  <?php
  if($laporan->num_rows() > 0){
  ?>
  <table class="tabel" id="myTable">
  <thead>
  <tr>
  <td>Tanggal</td>
  <td>Pelanggan</td>
  <td>Kota</td>
  <td>Alamat</td>
  <td>Ekspedisi</td>
  <td>Status Kirim</td>
  <td align="right">Total</td>
  
  </tr>
  </thead>
  <tbody>
  <?php
 
  foreach($laporan->result() as $l){

  ?>
  <tr>
    <td><?php echo tgl_db($l->tanggal);?></td>
    <td><?php echo $l->nama;?></td>
    <td><?php echo $l->kota;?></td>
    <td><?php echo $l->alamat;?></td>
    <td><strong><?php echo $l->ekspedisi." - ".$l->no_resi;?></strong></td>
    <td><strong><?php echo $l->status_kirim;?></strong></td>
    <td align="right"><?php echo uang($l->total);?></td>
    
  </tr>
  <?php 
    $t[] = $l->total;
  } 

  ?>
  <tr>
  <td colspan="6"><strong>Total (<?php echo tgl_indo($judul["dari"])." - ".tgl_indo($judul["sampai"]);?>)</strong></td>
  <td align="right"><strong><?php echo uang(array_sum($t));?></strong></td>
  </tr>
  </tbody>
</table>
<?php
}
else
{
  echo"
<div align='center'><strong><h3>Transaksi Tidak ditemukan !</h3></strong></div>
  ";
}
?>

<br>
<div align="center">
<button type="button" onclick="window.print()">Cetak Halaman</button>
</div>

</div>
</body>
</html>