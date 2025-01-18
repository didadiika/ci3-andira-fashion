<section class="content-header">
      <h1>
        Edit Barang
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
        <?php
        foreach($barang->result() as $s){
        ?>
          <form role="form" action="<?php echo base_url('barang/barang_update/'.$this->enkripsi_url->encode($s->id_brg)); ?>" method="post" autocomplete="off">
            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No Barang</label>
                  <input type="text" name="kode" id="kode" class="form-control" maxlength="32" placeholder="No / Kode Barang" autofocus="autofocus" required value="<?php echo $s->kode_barang;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Barang</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang"  required  maxlength="100" value="<?php echo $s->nama_barang;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Berat (Gram)</label>
                  <input type="text" name="berat" class="form-control" placeholder="Berat" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo uang($s->berat);?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <?php
            if($harga->num_rows() > 0){
            foreach($harga->result() as $r){
            ?>
            <input type="hidden" name="jh[]" value="<?php echo $r->id_jh;?>">
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> <?php echo $r->nama_jenis;?></label>
                  <input type="text" name="harga[]" id="harga<?php echo $r->id_jh;?>" class="form-control" placeholder="<?php echo $r->nama_jenis;?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo uang($r->harga);?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>
            <?php
            }
            }
            ?>
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required ><?php echo $s->keterangan;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>
            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Simpan
          </button>
         
          <button class="btn btn-app" type="button" onClick="self.history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
          </button>
            
          </form>
          <?php 
            }
          ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>