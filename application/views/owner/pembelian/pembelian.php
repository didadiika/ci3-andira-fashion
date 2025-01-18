<section class="content-header">
      <h1>
        Transaksi Pembelian
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-arrow-down"></i> Kelola Pembelian</a></li>
        <li class="active">Transaksi Pembelian</li>
      </ol>
    </section>



    <section class="content">

<a class="btn btn-app" href="<?php echo base_url('pembelian/pembelian/input');?>">
<i class="fa fa-plus"></i> Pembelian Baru
</a>



<div class="box">
  <!--Tombol Tambah Data-->
<?php
if($pembelian->num_rows() > 0){
?>
            <div class="box-header">
              <h3 class="box-title">Daftar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Toko</th>
                  <th>Jenis Pembelian</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  foreach($pembelian->result() as $s){
                    $no++;
                  ?>
                <tr>
                <td><?php echo $no;?></td>
                <td><?php echo tgl_db($s->tanggal);?></td>
                <td><?php echo $s->nama_toko;?></td>
                <td><?php echo $s->jenis_pembelian;?></td>
                <td><?php echo uang($s->total);?></td>
                <td>
                <a class="btn btn-default" href="<?php echo base_url('pembelian/pembelian/edit/'.$this->enkripsi_url->encode($s->id_beli));?>" title="Edit">
                <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-default" href="#" data-toggle="modal" 
                data-target="#modal-danger<?php echo $s->id_beli;?>" title="Hapus">
                <i class="fa fa-trash-o"></i>
                </a>
                <div class="modal modal-danger fade" id="modal-danger<?php echo $s->id_beli;?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus Transaksi Pembelian <strong>Toko : <?php echo $s->nama_toko;?>, Tanggal : <?php echo tgl_db($s->tanggal);?> </strong> ?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url('pembelian/pembelian_hapus/'.$this->enkripsi_url->encode($s->id_beli));?>">Ya</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
              </td>
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
          </section>