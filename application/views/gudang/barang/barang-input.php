<section class="content-header">
      <h1>
        Input Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cube"></i> Barang</a></li>
        <li class="active">Data Barang</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Masukkan Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action="<?php echo base_url('barang/barang_simpan'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Barang</label>
                  <input type="text" name="kode" id="kode" class="form-control" maxlength="32" placeholder="No / Kode Barang" autofocus="autofocus" required >
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Barang</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang"  required  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Berat (Gram)</label>
                  <input type="text" name="berat" class="form-control" placeholder="Berat" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <?php
            if($harga->num_rows() > 0){
            foreach($harga->result() as $r){
            ?>
            <input type="hidden" name="jh[]" value="<?php echo $r->id_jh;?>">
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> <?php echo $r->nama_jenis;?></label>
                  <input type="text" name="harga[]" id="harga<?php echo $r->id_jh;?>" class="form-control" placeholder="<?php echo $r->nama_jenis;?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="0">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <?php
            }
            }
            ?>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required >-</textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Foto</label>
                  <input type="file" name="foto" id="foto" class="form-control" placeholder="Foto" accept="image/*">
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