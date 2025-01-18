
<script type="text/javascript">
  const autoNumericOptions = {
    allowDecimalPadding        : false, 
    currencySymbol             : '',
    currencySymbolPlacement    : 'p',
    decimalCharacter           : ',',
    digitGroupSeparator        : '.',
    emptyInputBehavior         : 'zero',
    minimumValue               : '0',
    leadingZero                : 'deny'
};


  $(document).ready(function(){
    new AutoNumeric('[name="bayar"]', autoNumericOptions);
    
    var table_penjualan = $('#tabel-penjualan').DataTable({
       "language": {
              "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
          },
          "processing": true,
          "serverSide": true,
          "order": [],
          "columnDefs": [{
                          "targets": [0],
                          "orderable": false,
                          "searchable": false,
                        } ,{
                          "targets": [8],
                          "orderable": false,
                          "searchable": false,
          }],
          "ajax": {
                url:"<?php echo base_url('penjualan/penjualan_tampil');?>",
                type:"POST",
          }
  
      });

      var table_purchase = $('#tabel-purchase-order').DataTable({
       "language": {
              "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
          },
          "processing": true,
          "serverSide": true,
          "order": [],
          "columnDefs": [{
                          "targets": [0],
                          "orderable": false,
                          "searchable": false,
                        } ,{
                          "targets": [8],
                          "orderable": false,
                          "searchable": false,
          }],
          "ajax": {
                url:"<?php echo base_url('penjualan/purchase_order_tampil');?>",
                type:"POST",
          }
  
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
        var produksi = [];
        table.$('input[type="checkbox"]:checked').each(function(){
            produksi[i] = $(this).val();
  
            i++;
        });
        var produksi_json = JSON.stringify(produksi);
        
        $.ajax({
          url:"<?php echo base_url("produksi/produksi_hapus_produksi_ajax");?>",
          type:"POST",
          data:{produksi:produksi_json},
          success:function(){
            console.log(produksi_json);
          },
          error:function()
          {console.log("ERROR");}
        
        });
        table.ajax.reload(null, false);
        return false;
     });
  
  //GET HAPUS
  $('#tabel-penjualan').on('click','.item_hapus',function(){
              var id=$(this).attr('data');
              var no_nota=$(this).attr('no-nota');
              $('#ModalHapus').modal('show');
              $('[name="id_hapus"]').val(id);
              $('#no_nota').html(no_nota);
          });

 $('#tabel-purchase-order').on('click','.item_hapus',function(){
              var id=$(this).attr('data');
              var no_nota=$(this).attr('no-nota');
              $('#ModalHapus').modal('show');
              $('[name="id_hapus"]').val(id);
              $('#no_nota').html(no_nota);
  });

  $('#tabel-penjualan').on('click','.item_alamat',function(){
      var id=$(this).attr('data');
      var alamat=$(this).attr('alamat');
      $('#ModalAlamat').modal('show');
      $('[name="id_alamat"]').val(id);
      $('[name="alamat_lama"]').html(alamat);
  });

  $('#tabel-purchase-order').on('click','.item_alamat',function(){
      var id=$(this).attr('data');
      var alamat=$(this).attr('alamat');
      $('#ModalAlamat').modal('show');
      $('[name="id_alamat"]').val(id);
      $('[name="alamat_lama"]').html(alamat);
  });

$("#form-alamat").submit(function(e) {
e.preventDefault(); // avoid to execute the actual submit of the form.
var form = $(this);
var actionUrl = form.attr('action');
var method = form.attr('method');
$.ajax({
    type: method,
    url: actionUrl,
    data: form.serialize(), // serializes the form's elements.
    success: function(data)
    {
      console.log('Submit Berhasil !');
      location.reload();
    },
    error: function (data) {
      console.log('Submit Error !');
    },
});
$("#form-alamat")[0].reset();
$("#modalAlamat").modal('hide');
});

  $('#tabel-penjualan').on('click','.item_bayar',function(){
              var id=$(this).attr('data');

              $.ajax({
                url:"<?php echo base_url("penjualan/get-data-nota");?>",
                type:"GET",
                data:{"id_penjualan":id},
                success:function(response){
                  var d = JSON.parse(response);

                  $('#ModalBayar').modal('show');
                  $('[name="id_bayar"]').val(id);
                  $('[name="no_nota"]').val(d.nota);
                  $('[name="pelanggan"]').val(d.pelanggan);
                  $('[name="tanggal"]').val(d.tanggal);
                  $('[name="jenis"]').val(d.jenis);
                  $('[name="total"]').val(uang(d.total));
                  $('[name="sudah_bayar"]').val(uang(d.sudah_bayar));
                  $('[name="k_bayar"]').val(uang(d.kurang_bayar));
                  AutoNumeric.set('[name="bayar"]',0);
                  $('[name="sisa"]').val(uang(d.kurang_bayar));
                },
                error:function(){
                  console.log("Error");
                }
              });
  });

  $('#tabel-purchase-order').on('click','.item_bayar',function(){
              var id=$(this).attr('data');

              $.ajax({
                url:"<?php echo base_url("penjualan/get-data-nota");?>",
                type:"GET",
                data:{"id_penjualan":id},
                success:function(response){
                  var d = JSON.parse(response);

                  $('#ModalBayar').modal('show');
                  $('[name="id_bayar"]').val(id);
                  $('[name="no_nota"]').val(d.nota);
                  $('[name="pelanggan"]').val(d.pelanggan);
                  $('[name="tanggal"]').val(d.tanggal);
                  $('[name="jenis"]').val(d.jenis);
                  $('[name="total"]').val(uang(d.total));
                  $('[name="sudah_bayar"]').val(uang(d.sudah_bayar));
                  $('[name="k_bayar"]').val(uang(d.kurang_bayar));
                  AutoNumeric.set('[name="bayar"]',0);
                  $('[name="sisa"]').val(uang(d.kurang_bayar));
                },
                error:function(){
                  console.log("Error");
                }
              });
  });
  
          //Hapus Barang
          $('#btn_hapus').on('click',function(){
            $('#btn_hapus').prop("disabled",true);
              var id=$('#id_hapus').val();
              $.ajax({
              type : "POST",
              url  : "<?php echo base_url('penjualan/penjualan_hapus_nota/')?>"+id,
              data : {id: id},
                      success: function(data){
                              $('#ModalHapus').modal('hide');
                              table.ajax.reload(null, false);
                              $('#btn_hapus').prop("disabled",false);
                      }
                  });
                  return false;
              });

  });


function hitungBayar(){
 var k_bayar = $("#k_bayar").val() == '' ? '0' : $("#k_bayar").val();
 var k_bayar = parseInt(k_bayar.toString().replace(/\./g,""));

 var bayar = $("#bayar").val() == '' ? '0' : $("#bayar").val();
 var bayar = parseInt(bayar.toString().replace(/\./g,""));
 
 var sisa = k_bayar - bayar;

 if(bayar > k_bayar){
  AutoNumeric.set('[name="bayar"]',k_bayar);
    $("#sisa").val(0);
 }
 else
 {
    $("#sisa").val(uang(sisa));
 }

}
  </script>
  <section class="content-header">
      <h1>
        Daftar Penjualan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Penjualan</a></li>
        <li class="active">Daftar Penjualan</li>
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
            
            <div class="row">
            <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
              <li class="active"><a href="#penjualan" data-toggle="tab">Penjualan</a></li>
              <li><a href="#purchase_order" data-toggle="tab">Purchase Order</a></li>
            </ul>


            <div class="tab-content">
            
            <div class="tab-pane active" id="penjualan">
            <div class="table-responsive">
            <table id="tabel-penjualan" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Nota</th>
                <th>Pelanggan</th>
                <th>Grand Total</th>
                <th>Berat (gr)</th>
                <th>Status</th>
                <th>Status Kirim</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
            </div>

            <div class="tab-pane" id="purchase_order">
            <div class="table-responsive">
            <table id="tabel-purchase-order" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Nota</th>
                <th>Pelanggan</th>
                <th>Grand Total</th>
                <th>Berat (gr)</th>
                <th>Status</th>
                <th>Status Kirim</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
            </div>
            </div>

</div>
</div>
</div>





              
            <!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Penjualan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                           
                            <input type="hidden" name="id_hapus" id="id_hapus" value="">
                            <div class="alert alert-danger"><p>Apakah Anda yakin mau menghapus <span id="no_nota"></span> ini?</p></div>
                                         
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

        

        <!--MODAL BAYAR-->
        <div class="modal modal-primary fade" id="ModalBayar">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Pembayaran Nota</h4>
              </div>
              <div class="box-body">

              <form role="form" action="<?php echo base_url('penjualan/simpan-pembayaran/') ;?>" method="post" autocomplete="off">
              <input type="hidden" name="id_bayar" value="">

              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Nota</label>
                  <input type="text" name="no_nota" id="no_nota" class="form-control" placeholder="No Nota" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pelanggan</label>
                  <input type="text" name="pelanggan" id="pelanggan" class="form-control" placeholder="Pelanggan" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal Nota</label>
                  <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jenis Penjualan</label>
                  <input type="text" name="jenis" id="jenis" class="form-control" placeholder="Jenis Penjualan" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>


              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total Tagihan</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Total Tagihan" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i>  Sudah Bayar</label>
                  <input type="text" name="sudah_bayar" id="sudah_bayar" class="form-control" placeholder="Sudah Bayar" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Kurang Bayar</label>
                  <input type="text" name="k_bayar" id="k_bayar" class="form-control" placeholder="Kurang Bayar" readonly>
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div class="row">
              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Metode Bayar</label>
                  <select name="metode_bayar"  class="form-control" required>
                  <option value=''>*Pilih</option>
	                  <?php
                    $nama_jenis = array("Cash","BCA","BRI","BNI","Mandiri");
                      foreach($nama_jenis as $s)
	                    {
                        echo"<option value='$s'>$s</option>";
                      }
	                  ?>
                  </select>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>

              <div class="col-md-6">
              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Tanggal Bayar</label>
                  <input type="text" name="tanggal_bayar" id="datepicker" class="form-control" data-date-end-date="0d" data-date-format="dd-mm-yyyy" placeholder="Tanggal Bayar" required>
                  <span class="help-block" id="pesanNama"></span>
              </div>
              </div>
              </div>


              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nominal Bayar</label>
                  <input type="text" name="bayar" id="bayar" class="form-control" placeholder="Nominal Bayar" required onKeyup="hitungBayar()">
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Sisa</label>
                  <input type="text" name="sisa" id="sisa" class="form-control" placeholder="Sisa" readonly value="">
                  <span class="help-block" id="pesanNama"></span>
              </div>

              </div>
              <div class="modal-footer">
                <button class="btn btn-outline pull-left" type="submit"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> Batal</a>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--END MODAL BAYAR-->


        <!--MODAL ALAMAT-->
        <div class="modal modal-primary fade" id="ModalAlamat">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Edit Alamat</h4>
              </div>
              <div class="box-body">

              <form id="form-alamat" role="form" action="<?php echo base_url("penjualan/penjualan_update_alamat");?>" method="post" autocomplete="off">
              <input type="hidden" name="id_alamat" value="">

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat Lama</label>
                  <textarea name="alamat_lama" id="alamat_lama" class="form-control" placeholder="Alamat Lama" readonly></textarea>
                  <span class="help-block" id="pesanNama"></span>
              </div>

              <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat Baru</label>
                  <textarea name="alamat_baru" id="alamat_baru" class="form-control" placeholder="Alamat Baru" required></textarea>
                  <span class="help-block" id="pesanNama"></span>
              </div>

              </div>
              <div class="modal-footer">
                <button class="btn btn-outline pull-left" type="submit"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> Batal</a>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--END MODAL ALAMAT-->


            </div>

            <!-- /.box-body -->
          </div>
          </section>