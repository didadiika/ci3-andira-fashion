<script type="text/javascript">
  
$(document).ready(function(){
  var table = $('#tabel-stok').DataTable({
     "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
              url:"<?php echo base_url('barang/stok_tampil');?>",
              type:"POST",
        }
        

    });
});
</script>
<section class="content-header">
      <h1>
        Stok Barang Hari Ini
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cube"></i> Barang</a></li>
        <li class="active">Stok Barang</li>
      </ol>
    </section>



    <section class="content">

<div class="box">
  <!--Tombol Tambah Data-->

            <div class="box-header">
              <h3 class="box-title">Daftar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="tabel-stok" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal Update</th>
                  <th>Kode - Nama Barang</th>
                  <th>Keterangan</th>
                  <th>Jumlah Masuk</th>
                  <th>Jumlah Keluar</th>
                  <th>Sisa</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Tanggal Update</th>
                  <th>Kode - Nama Barang</th>
                  <th>Keterangan</th>
                  <th>Jumlah Masuk</th>
                  <th>Jumlah Keluar</th>
                  <th>Sisa</th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>

            <!-- /.box-body -->
          </div>
          </section>