<section class="content-header">
      <h1>
        Edit Pemotong
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cogs"></i> Kelola Produksi</a></li>
        <li class="active">Pemotong</li>
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
        foreach($pemotong->result() as $r){
        ?>
          <form role="form" action="<?php echo base_url('produksi/pemotong_update/'.$this->uri->segment(4)); ?>" method="post" autocomplete="off">
            <!-- text input -->
            

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Nama Pemotong</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Pemotong"  required  maxlength="100" value="<?php echo $r->nama_pemotong;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Alamat</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required ><?php echo $r->alamat;?></textarea>
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