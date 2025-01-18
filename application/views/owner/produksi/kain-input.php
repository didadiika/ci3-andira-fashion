<section class="content-header">
      <h1>
        Input Kain Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cogs"></i> Kelola Produksi</a></li>
        <li class="active">Kain</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('produksi/kain_simpan'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <!-- text input -->
            

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Jenis Kain</label>
                  <input type="text" name="jenis" id="jenis" class="form-control" placeholder="Jenis Kain" autofocus="autofocus" required  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Toko</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Toko"  required  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Harga Satuan</label>
                  <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga Satuan" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Total</label>
                  <input type="text" name="total" id="total" class="form-control" placeholder="Total" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),hitungTotal();" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required ></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Status Bayar</label>
                </br>
                  <input type="radio" name="status_bayar" value="Cash" checked> Cash
                  <input type="radio" name="status_bayar" value="Tempo"> Tempo
                  <span class="help-block" id="pesanNama"></span>
            </div>

            
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Simpan
          </button>
         
          <button class="btn btn-app" type="button" onClick="self.history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
          </button>
            
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>