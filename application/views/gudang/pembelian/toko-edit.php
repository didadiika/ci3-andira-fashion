<section class="content-header">
      <h1>
        Edit Toko
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-arrow-down"></i> Pembelian</a></li>
        <li class="active">Toko</li>
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
        foreach($toko->result() as $s){
        ?>
          <form role="form" action="<?php echo base_url('pembelian/toko_update/'.$this->enkripsi_url->encode($s->id_toko)); ?>" method="post" autocomplete="off">
            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> ID Toko</label>
                  <input type="text" name="kode" id="kode" class="form-control" maxlength="32" placeholder="ID Toko" value="<?php echo $s->kode_toko; ?>" readonly>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Toko</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Toko" value="<?php echo $s->nama_toko; ?>" required  maxlength="100">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required ><?php echo $s->alamat;?></textarea>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> No HP</label>
                  <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="No HP" required  maxlength="15" value="<?php echo $s->no_hp; ?>">
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