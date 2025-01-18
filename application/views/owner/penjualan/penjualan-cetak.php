<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Nota Penjualan</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->

  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
  <style>
    @page { size: 58mm 100mm } /* output size */
    body.receipt .sheet { width: 58mm; padding-left:2mm; padding-right: 2mm; padding-top: 1mm; padding-bottom: 1mm; } /* sheet size */
    @media print { body.receipt { width: 58mm } } /* fix for Chrome */
  </style>
</head>

<body class="receipt" onload="window.print();">
	<?php
	foreach ($nota->result() as $n) {
		
	?>
  <section class="sheet padding-5mm">

    
  
      <div align="center">
       <strong><i class="fa fa-shopping-cart"></i> Andira Fashion</strong><br>
        <small>
        
        </small>
        </div>
  <small>---------------------------------------------------</small>


           
           <small>




      <div align="center"> <strong><i class="fa fa-credit-card"></i> TRANSAKSI TUNAI</strong><br></div>

            <table>

             <tr>
               <td width="40%">Nota</td>
               <td><strong>#<?php echo $n->no_nota;?></strong></td>
             </tr>


             <tr>
               <td width="40%">Tgl</td>
               <td><?php echo tgl_indo($n->tanggal);?></td>
             </tr>

             <tr>
               <td width="40%">Plg</td>
               <td><?php echo $n->nama_pelanggan;?></td>
             </tr>

            
             <tr>
               <td width="40%">Kasir</td>
               <td>Admin</td>
             </tr>
           </table>
           </small>


  <small>---------------------------------------------------</small>


      <div class="clearfix ">

           <small>
      <table align="" width="100%">


       
      <?php foreach($keranjang->result() as $d){?>

        <tr><td colspan="5"><?php echo $d->nama_barang;?></td></tr>
        <tr align="right">
          <td align="right" width="20%"><?php echo $d->jumlah;?></td>
          <td align="right" width="10%">x</td>
          <td align="right"  width="30%"><?php echo $d->harga;?></td>
          <td align="right" width="10%">=</td>
          <td align="right" width="30%"><div align="right"><?php echo uang($d->sub_total);?></div></td>
        </tr>

      <?php 
  		$t[] = $d->sub_total;
  		} 
  		?>
      </table>
      </small>

      </div>
  <small>---------------------------------------------------</small>


<small>

      <div align="right">
       <table>
       <tr>
                <th style="width:50%">Ongkir</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <td><div class="currency"><?php echo uang($n->ongkir);?></div></td>
              </tr>
              <tr>
                <th style="width:50%">Total Belanja</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <td><div class="currency"><?php echo uang(array_sum($t) + $n->ongkir);?></div></td>
              </tr>
             
            </table>
          </div>


    </small>



    <br/>

    <small><strong><div align="center">Terima Kasih Atas Kunjungan Anda</div></strong></small>

  



    

  </section>
<?php

}
?>

<style>

.currency {
   text-align: right;
   width: 100%;
}

.currency:before {
   content: "Rp.";
   float: left;
}
</style>


</body>

</html>


<span id="counter" style="display: none;">10</span>
<script type="text/javascript">
function countdown() {

    var i = document.getElementById('counter');

    i.innerHTML = parseInt(i.innerHTML)-1;

if (parseInt(i.innerHTML)<=0) {

 window.close();

}

}

setInterval(function(){ countdown(); },300);

</script>
