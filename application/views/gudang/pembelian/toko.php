<section class="content-header">
      <h1>
        Toko
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-arrow-down"></i> Pembelian</a></li>
        <li class="active">Toko</li>
      </ol>
    </section>



    <section class="content">

<a class="btn btn-app" href="<?php echo base_url('pembelian/toko/input');?>">
<i class="fa fa-plus"></i> Toko Baru
</a>



<div class="box">
  <!--Tombol Tambah Data-->
<?php
if($toko->num_rows() > 0){
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
                  <th>ID Toko</th>
                  <th>Nama Toko</th>
                  <th>Alamat</th>
                  <th>No Hp</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                  <?php
                  $no = "";
                  foreach($toko->result() as $s){
                    $no++;
                  ?>
                <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $s->kode_toko;?></td>
                <td><?php echo $s->nama_toko;?></td>
                <td><?php echo $s->alamat;?></td>
                <td><?php echo $s->no_hp;?></td>
                <td>
                <a class="btn btn-default" href="<?php echo base_url('pembelian/toko/edit/'.$this->enkripsi_url->encode($s->id_toko));?>" title="Edit">
                <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-default" href="#" data-toggle="modal" 
                data-target="#modal-danger<?php echo $s->id_toko;?>" title="Hapus">
                <i class="fa fa-trash-o"></i>
                </a>
                <div class="modal modal-danger fade" id="modal-danger<?php echo $s->id_toko;?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
              </div>
              <div class="modal-body">
                <p>Hapus <?php echo $s->nama_toko;?>?</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline pull-left" data-dismiss="modal">Tidak</a>
                <a class="btn btn-outline" href="<?php echo base_url('pembelian/toko_hapus/'.$this->enkripsi_url->encode($s->id_toko));?>">Ya</a>
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