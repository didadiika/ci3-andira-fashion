

<section class="content-header">
      <h1>
        Laporan Stok
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cube"></i> Kelola Data Barang</a></li>
        <li class="active">Laporan Stok</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-warning">
   
        <div class="box-header with-border">
          <h3 class="box-title">Pilih Periode Rekap Stok</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" action='<?php echo base_url('barang/laporan_stok_tampil');?>' method='post' target='_blank' autocomplete="off">
            

            
           



            <div id="tagNama" class="form-group">
                  <label class="control-label" for="inputError"><i id="iconNama"></i> Sampai</label>
                  <select name="tgl2" id="tgl2"  required class="form-control">
    <option value="">Tgl*</option>
    <?php
    for($t = 1; $t <= 31; $t++)
    {
        if(date("d") == $t)
        {
            echo"<option value='$t' selected='".date("d")."'>$t</option>";
        }
        else
        {
            echo"<option value='$t'>$t</option>";
        }
        
    }
    ?>
    </select>
    <select name="bln2" id="bln2" required class="form-control">
    <option value="">Bulan*</option>
    <?php
    $nama_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    for($b = 1; $b <= 12; $b++)
    {
        if(date("m") == $b)
        {
            echo"<option value='$b' selected='".date("m")."'>$nama_bulan[$b]</option>";
        }
        else
        {
            echo"<option value='$b'>$nama_bulan[$b]</option>";
        }
        
    }
    ?>
    </select>
    <select name="thn2" id="thn2" required class="form-control">
    <option value="">Tahun*</option>
    <?php
    for($th = date("Y")-5; $th <= date("Y"); $th++)
    {
        if(date("Y") == $th)
        {
            echo"<option value='$th' selected='".date("Y")."'>$th</option>";
        }
        else
        {
            echo"<option value='$th'>$th</option>";
        }
    }
    ?>
    </select>
                  <span class="help-block" id="pesanNama"></span>
            </div>

            
          
          <button class="btn btn-app" type="submit" id="submit">
          <i class="fa fa-file-text-o"></i> Tampilkan
          </button>
         
          <button class="btn btn-app" type="reset">
          <i class="fa fa-refresh"></i> Ulangi
          </button>
            
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>