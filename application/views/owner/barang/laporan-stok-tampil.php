<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAPORAN STOK</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/print.css" type="text/css" />

</head>
<style>
@media print {
input.noPrint { display: none; }
}
</style>
<body class="body">
<div id="wrapper">

  <h2 class="head">LAPORAN STOK</h2>
  <table class="tabel" id="myTable">
  <thead>
  <tr>
  <td width="50%">Per Tanggal :</td>
  <td align="right"><?php echo tgl_indo($judul["sampai"]);?></td>
  </tr>
  </thead>
  </table>
  <?php
  if($laporan->num_rows() > 0){
  ?>
  <table class="tabel" id="myTable">
  <thead>
  <tr>
  <td>Barang</td>
  <td>Keterangan</td>
  <td align="right">Jumlah Masuk</td>
  <td align="right">Jumlah Keluar</td>
  
  <td align="right">Sisa</td>
  
  </tr>
  </thead>
  <tbody>
  <?php
 
  foreach($laporan->result() as $l){
      $masuk = $this->barang_model->tampil_masuk_per_barang_periode($l->id_brg,$judul["sampai"]);
      $keluar = $this->barang_model->tampil_keluar_per_barang_periode($l->id_brg,$judul["sampai"]);
      $sisa = $masuk - $keluar;
  ?>
  <tr>
    <td><?php echo $l->nama_barang;?></td>
    <td><?php echo $l->keterangan;?></td>
    <td align="right"><?php echo $masuk;?></td>
    <td align="right"><?php echo $keluar?></td>
    <td align="right"><?php echo $sisa;?></td>
  </tr>
  <?php
    $m[] = $masuk;
    $k[] = $keluar;
    $s[] = $sisa;
  } 

  ?>
  <tr>
  <td colspan="2"><strong>Total (Sampai <?php echo tgl_indo($judul["sampai"]);?>)</strong></td>
  <td align="right"><strong><?php echo uang(array_sum($m));?></strong></td>
  <td align="right"><strong><?php echo uang(array_sum($k));?></strong></td>
  <td align="right"><strong><?php echo uang(array_sum($s));?></strong></td>
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