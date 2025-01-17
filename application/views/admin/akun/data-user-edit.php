<section class="content-header">
      <h1>
        Edit User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Akun</a></li>
        <li class="active">Data User</li>
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
        foreach($user->result() as $r){
        ?>
          <form role="form" action="<?php echo base_url('akun/data_user_update/'. $this->enkripsi_url->decode($this->uri->segment(3))); ?>" method="post" autocomplete="off">
            <!-- text input -->
            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Username</label>
                  <input type="text" name="username" id="username" class="form-control" placeholder="Username"  required  maxlength="100" value="<?php echo $r->username;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Password</label>
                  <input type="text" name="password" id="password" class="form-control" placeholder="Password"  required  maxlength="100" value="<?php echo $r->password;?>">
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Pilih Level</label>
                  <select name="level"  class="form-control" id="level" required>
   
	<?php
    $nama_level = array("Admin","Owner");
    for($i = 0; $i < count($nama_level); $i++)
	{
        if($r->level == $nama_level[$i]){
            echo"<option value='$nama_level[$i]' selected='$r->level'>$nama_level[$i]</option>";
        }
        else{
            echo"<option value='$nama_level[$i]'>$nama_level[$i]</option>";
        }


		
	}
	?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Status Akun</label>
                  <select name="status"  class="form-control" id="status" required>
   
	<?php
    $nama_s = array("Aktif","Blokir");
    for($i = 0; $i < count($nama_s); $i++)
	{
        if($r->status_akun == $nama_s[$i]){
            echo"<option value='$nama_s[$i]' selected='$r->status_akun'>$nama_s[$i]</option>";
        }
        else{
            echo"<option value='$nama_s[$i]'>$nama_s[$i]</option>";
        }

		
	}
	?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-save"></i> Simpan
          </button>
         
          <button class="btn btn-app" type="button" onClick="self.history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
          </button>
            
          </form>
<?php } ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>