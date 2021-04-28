
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
          <h3 class="box-title" id="judul2">Log Dinas Luar</h3>

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
                <th>Nama</th>                
                <th>Tanggal</th>
                <th>Ket.</th>
                <th>Status</th>
                <th>Action</th>
                
                
             </tr>
           </thead>
           <tbody>
             <?php 
             $no=0;         
             
              foreach ($all as $key) {
                $no++;
                if($key->status=='pending')
                {
                  $btn="
                      <button class='btn btn-xs btn-success' onclick='setujui(1,$key->id)'>Setujui</button>
                      <button class='btn btn-xs btn-danger' onclick='setujui(0,$key->id)'>Tolak</button>
                      ";
                }else{
                  $btn ="-";
                }       

                echo "
                  <tr>
                    <td>$no</td>                    
                    <td>$key->Nama <br> <i>$key->NIK</i></td>
                    <td>".tglindo($key->tanggal)."</td>
                    <td>$key->keterangan </td>
                    <td>$key->status </td>
                    <td>
                      $btn
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
    $('#tbl_log').dataTable({} );
  })

function setujui(x,z)
{
  if(confirm("Anda yakin?"))
  {
    $.get("<?php echo base_url()?>index.php/absensi/setujui_dl",{action:x,id:z},function(x){
        console.log(x);


        var tgl_awal   = $("#tgl_awal").val();
        var tgl_akhir  = $("#tgl_akhir").val();
        if( (new Date(tgl_awal).getTime() > new Date(tgl_akhir).getTime()))
        {
          alert("Perhatikan pengisian tanggal. Ada yang salah.");
          return false;
        }

        eksekusi_controller('<?php echo base_url()?>index.php/absensi/dinas_luar/?tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,'Log Absensi');
        

    })  
  }
  
}

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

    eksekusi_controller('<?php echo base_url()?>index.php/absensi/dinas_luar/?tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,'Log Absensi');
  return false;
})

$("html, body").animate({ scrollTop: 0 }, "slow");



$("#download_pdf").on("click",function(){
  var ser = $("#go_trx_jurnal").serialize();
  var url="<?php echo base_url()?>index.php/absensi/dinas_luar_xl/?"+ser;
  window.open(url);

  return false;
})

</script>