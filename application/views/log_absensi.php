
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="judul">
        Selamat datang di Sistem Informasi 
        
      </h1>      
    </section>

    <!-- Main content -->
    <section class="content container-fluid" >

      <!--------------------------
        | Your Page Content Here |
        -------------------------->    
<!-- Default box -->
      

<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title" id="judul2">Log Absensi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="alert alert-info">
          <form id="go_trx_jurnal">
              <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal"  value="<?php echo $tgl_awal ?>" >
              </div>
              <div class="col-sm-5">
                <input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir"  value="<?php echo $tgl_akhir ?>">
              </div>
              <div class="col-sm-2">
                <input type="submit" class="btn btn-primary btn-block" value="Go">
              </div>
          </form>
          <div style="clear: both"></div>
        </div>
         <table class="table table-bordered" id="tbl_log">
           <thead>
             <tr>
                <th>No.</th>
                <th>Fid</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam Log</th>
                <th>Shift</th>
                <th>Telat</th>
                <th>Lokasi</th>
                
             </tr>
           </thead>
           <tbody>
             <?php 
             $no=0;         
             
              foreach ($all as $key) {
                $no++;
                if($key->telat<=10)
                {
                  $class='';
                }else if($key->telat>10 && $key->telat<=30)
                {
                  $class='warning';
                }else{
                  $class='danger';
                }
                
                $x = explode("/", $key->image);
                $y = explode("_", $x[1]);
                $nip=$y[0];
             
                echo "
                  <tr class='$class'>
                    <td>$no</td>
                    <td>$key->Fid</td>
                    
                    <td>$key->Nama_Staff <br> $nip</td>
                    <td>".tglindo($key->formated)."</td>
                    <td>$key->Jam_Log $key->In_out</td>
                    <td>
                      $key->sift_masuk - $key->sift_keluar<br>
                    </td>
                    <td>$key->telat</td>
                    <td>
                      <a href='https://www.google.com/maps/search/?api=1&query=$key->lat,$key->lng' target='blank'>                          
                          $key->lat,$key->lng
                      </a><br>
                      <a href='".base_url()."$key->image' target='blank'>$key->image</a>
                    </td>
                  </tr>
                ";
              }
             ?>
             
           </tbody>
           
         </table>



      </div>

      <input type="button" class="btn btn-primary" value="Download" id="download_pdf">
      <!-- /.box -->
    </div>
</section>
    <!-- /.content -->

<script type="text/javascript">
  
  $(document).ready(function(){
    $('#tbl_log').dataTable({        "iDisplayLength": 100
                                    

                          } );
  })


function formatRupiah(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
$('.datepicker').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd' 
})

$("#go_trx_jurnal").on("submit",function(){
    var tgl_awal   = $("#tgl_awal").val();
    var tgl_akhir  = $("#tgl_akhir").val();
    if( (new Date(tgl_awal).getTime() > new Date(tgl_akhir).getTime()))
    {
      alert("Perhatikan pengisian tanggal. Ada yang salah.");
      return false;
    }

    eksekusi_controller('<?php echo base_url()?>index.php/absensi/log_absensi/?tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,'Log Absensi');
  return false;
})

$("html, body").animate({ scrollTop: 0 }, "slow");



$("#download_pdf").on("click",function(){
  var ser = $("#go_trx_jurnal").serialize();
  var url="<?php echo base_url()?>index.php/absensi/log_absensi_xl/?"+ser;
  window.open(url);

  return false;
})

</script>