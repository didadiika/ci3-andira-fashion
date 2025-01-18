<script type="text/javascript">
  
$(document).ready(function(){
  var table = $('#tabel-kain').DataTable({
     "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
              url:"<?php echo base_url('produksi/kain_tampil');?>",
              type:"POST",
        },
        "columnDefs": [ {
            "targets": 0,
            "orderable":false,
            "searchable":false
        }],

    });

// Handle click on "Select all" control
$('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#tabel-kain tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });

   // Handle form submission event
   $('#frm-example').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      var semua = table.$('input[type="checkbox"]').length;
      var dipilih = table.$('input[type="checkbox"]:checked').length;
      var i = 0;
      var kain = [];
      table.$('input[type="checkbox"]:checked').each(function(){
          kain[i] = $(this).val();

          i++;
      });
      var kain_json = JSON.stringify(kain);
      
      $.ajax({
        url:"<?php echo base_url("produksi/kain_hapus_ajax");?>",
        type:"POST",
        data:{kain:kain_json},
        success:function(){
          console.log(kain_json);
        },
        error:function()
        {console.log("ERROR");}
      
      });
      table.ajax.reload();
      return false;
   });

//GET HAPUS
$('#tabel-kain').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            var nama=$(this).attr('nama-kain');
            $('#ModalHapus').modal('show');
            $('[name="id_hapus"]').val(id);
            $('#nama_kain').html(nama);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
          $('#btn_hapus').prop("disabled",true);
            var id=$('#id_hapus').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('produksi/kain_hapus/')?>"+id,
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
        Data Kain
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cogs"></i> Kelola Produksi</a></li>
        <li class="active">Kain</li>
      </ol>
    </section>



    <section class="content">

<a class="btn btn-app" href="<?php echo base_url('produksi/kain/input');?>">
<i class="fa fa-plus"></i> Tambah Kain Baru
</a>



<div class="box">
  <!--Tombol Tambah Data-->

            <div class="box-header">
              <h3 class="box-title">Daftar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              
              <table id="tabel-kain" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                  <th>No</th>
                  <th>Jenis Kain</th>
                  <th>Nama Toko</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th>Status Bayar</th>
                  <th>Status Barang</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
                 <tfoot>
                <tr>
                  
                  <th></th>
                  <th>No</th>
                  <th>Jenis Kain</th>
                  <th>Nama Toko</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th>Status Bayar</th>
                  <th>Status Barang</th>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Kain</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                           
                            <input type="hidden" name="id_hapus" id="id_hapus" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin mau menghapus <span id="nama_kain"></span> ini?</p></div>
                                         
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

            <form id="frm-example">
            <button type="submit" id="frm-examples" class="btn btn-danger">Hapus Yang Dipilih</button>
            </form>
            </div>

            <!-- /.box-body -->
          </div>
          </section>