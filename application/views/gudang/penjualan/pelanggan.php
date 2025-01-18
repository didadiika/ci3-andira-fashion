<script type="text/javascript">
  
$(document).ready(function(){
  var table = $('#tabel-pelanggan').DataTable({
     "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
              url:"<?php echo base_url('penjualan/pelanggan_tampil');?>",
              type:"POST",
        }

    });

//GET HAPUS
$('#tabel-pelanggan').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            var nama=$(this).attr('nama-pelanggan');
            $('#ModalHapus').modal('show');
            $('[name="id_hapus"]').val(id);
            $('#nama_pelanggan').html(nama);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
          $('#btn_hapus').prop("disabled",true);
            var id=$('#id_hapus').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('penjualan/pelanggan_hapus/')?>"+id,
            data : {id: id},
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            table.ajax.reload();
                            $('#btn_hapus').prop("disabled",false);
                    }
                });
                return false;
            });
});
</script>
<section class="content-header">
      <h1>
        Pelanggan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Kelola Penjualan</a></li>
        <li class="active">Pelanggan</li>
      </ol>
    </section>



    <section class="content">

<a class="btn btn-app" href="<?php echo base_url('penjualan/pelanggan/input');?>">
<i class="fa fa-plus"></i> Tambah Pelanggan
</a>



<div class="box">
  <!--Tombol Tambah Data-->

            <div class="box-header">
              <h3 class="box-title">Daftar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="tabel-pelanggan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>No Pelanggan</th>
                  <th>Nama Pelanggan</th>
                  <th>Alamat</th>
                  <th>Kota</th>
                  <th>No Hp</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>No Pelanggan</th>
                  <th>Nama Pelanggan</th>
                  <th>Alamat</th>
                  <th>Kota</th>
                  <th>No Hp</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Pelanggan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                           
                            <input type="hidden" name="id_hapus" id="id_hapus" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin mau menghapus <span id="nama_pelanggan"></span> ini?</p></div>
                                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->
            </div>

            <!-- /.box-body -->
          </div>
          </section>