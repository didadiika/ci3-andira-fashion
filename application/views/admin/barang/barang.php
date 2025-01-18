<script type="text/javascript">
  
$(document).ready(function(){
  var table = $('#tabel-barang').DataTable({
     "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
              url:"<?php echo base_url('barang/barang_tampil');?>",
              type:"POST",
        },
        "columnDefs": [ {
            "targets": 0,
            "orderable":false,
            "searchable":false
        },
        {
            "targets": 7,
            "orderable":false,
            "searchable":false
        }
        ],

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
      var barang = [];
      table.$('input[type="checkbox"]:checked').each(function(){
          barang[i] = $(this).val();

          i++;
      });
      var barang_json = JSON.stringify(barang);
      
      $.ajax({
        url:"<?php echo base_url("barang/barang_hapus_ajax");?>",
        type:"POST",
        data:{barang:barang_json},
        success:function(){
          console.log(barang_json);
        },
        error:function()
        {console.log("ERROR");}
      
      });
      table.ajax.reload();
      return false;
   });

//GET HAPUS
$('#tabel-barang').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            var nama=$(this).attr('nama-barang');
            $('#ModalHapus').modal('show');
            $('[name="id_hapus"]').val(id);
            $('#nama_barang').html(nama);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
          $('#btn_hapus').prop("disabled",true);
            var id=$('#id_hapus').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('barang/barang_hapus/')?>"+id,
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
        Data Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cube"></i> Barang</a></li>
        <li class="active">Data Barang</li>
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
              <table id="tabel-barang" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Berat</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                  <th>Stok</th>
                  <th>Foto</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Berat</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                  <th>Stok</th>
                  <th>Foto</th>
                </tr>
                </tfoot>
              </table>
            </div>
           

            </div>

            <!-- /.box-body -->
          </div>
          </section>