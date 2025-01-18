<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAPORAN PRODUKSI</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/print.css" type="text/css" />

</head>
<style>
@media print {
input.noPrint { display: none; }
}
</style>
<body class="body">
<div id="wrapper">

  <h2 class="head">LAPORAN PRODUKSI</h2>
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
  <td>Jenis Kain</td>
  <td align="right">Harga Kain</td>
  <td align="right">Ongkos Produksi</td>
  <td align="right">Harga Jual</td>
  <td align="right">Laba</td>
  <td align="right">Jumlah Produksi</td>
  <td align="right">Jumlah Setor</td>
  <td align="right">Kurang Setor</td>
  
  </tr>
  </thead>
  <tbody>
  <?php
  $no = "";
  foreach($laporan->result() as $l){
    $no++;
    $d[$no] = $this->produksi_model->tampil_data_laba($l->id_produksi);
    $s = $this->produksi_model->tampil_jumlah_setor($l->id_produksi);
    foreach($s->result() as $f){ $setor[$no] = $f->jumlah;}
  ?>
  <tr>
    <td><?php echo tgl_db($l->tanggal);?></td>
    <td><?php echo $l->jenis_kain;?></td>
    <td align="right"><?php echo uang($l->total_harga);?></td>
    <td align="right"><?php echo uang($d[$no]["ongkos"]);?></td>
    <td align="right"><?php echo uang($d[$no]["jual"]);?></td>
    <td align="right"><?php echo uang($d[$no]["laba"] - $l->total_harga);?></td>
    <td align="right"><?php echo uang($d[$no]["jumlah"]);?></td>
    <td align="right"><?php echo (int)$setor[$no];?></td>
    <td align="right"><?php echo uang($d[$no]["jumlah"] - $setor[$no]);?></td>
    
  </tr>
  <?php 
    $t[] = $d[$no]["laba"] - $l->total_harga;
  } 

  ?>
  <tr>
  <td colspan="5">Jumlah Laba</td>
  <td align="right"><strong><?php echo uang(array_sum($t));?></strong></td>
  <td colspan="3"></td>
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