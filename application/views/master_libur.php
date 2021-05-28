
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="judul">
        Table Data
        
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
          <h3 class="box-title" id="judul2"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="alert alert-warning">
          <strong>Informasi: </strong><i>Hari jumat,sabtu atau minggu, jika tidak masuk kerja, silahkan input sebagai libur.</i>
        </div>
          
              
              <button class="btn btn-primary" id="tambah_data"  onclick="tambah()">Tambah Data</button> 
              
<div class="table-responisve">
<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
              <th width="10px">Tgl Libur</th>           
              <th>Desc Ket.</th>                                                 
              <th>Action</th>                     
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        foreach($all as $x)
        {
          $btn = "<button class='btn btn-warning btn-xs' onclick='edit($x->id);return false;'>Edit</button>
                  <button class='btn btn-danger btn-xs' onclick='hapus($x->id);return false;'>Hapus</button>    ";
          $no++;
          
            echo (" 
              
              <tr>
                <td>$no</td>
                <td>$x->tgl_libur</td>
                <td>$x->desc_libur</td>                
                       
                
                <td>
                  $btn
                </td>
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>
</div>
<!--
<a href="<?php echo(base_url())?>index.php/staff/data_xl" target="blank" class="btn btn-primary">Excel</a>
-->
        </div>
        
      </div>
      <!-- /.box -->

</section>
    <!-- /.content -->




<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Data</h4>
      </div>
      <div class="modal-body">
          <form id="form_tambah_admin">
            <input type="hidden" name="id" id="id" class="form-control" readonly="readonly">            

            <div class="col-sm-4">Tgl libur</div>
            <div class="col-sm-8"><input type="text" name="tgl_libur" id="tgl_libur" required="required" class="form-control datepicker" placeholder="Tgl libur" autocomplete="off"></div>
            <div style="clear: both;"></div><br>


            <div class="col-sm-4">Keterangan </div>
            <div class="col-sm-8">
                    <textarea  id="desc_libur"  name="desc_libur" class="form-control" placeholder="Keterangan"></textarea>
            </div>
            <div style="clear: both;"></div><br>


        
        

            <div id="t4_info_form"></div>
            <button type="submit" class="btn btn-primary"> Simpan </button>
          </form>

          <div style="clear: both;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script>
console.log("<?php echo $this->router->fetch_class();?>");
var classnya = "<?php echo $this->router->fetch_class();?>";

$('.datepicker').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd' 
})

hanya_nomor(".nomor");
function edit(id)
{
  $.get("<?php echo base_url()?>index.php/"+classnya+"/master_libur_by_id/"+id,function(e){
    //console.log(e[0].id);
    $("#id").val(e[0].id);
    $("#tgl_libur").val(e[0].tgl_libur);
    $("#desc_libur").val(e[0].desc_libur);
    
    
  })
  $("#myModal").modal('show');
}

function tambah()
{
    $("#id").val('');
    
    
  $("#myModal").modal('show');
}

function hapus(id)
{
  if(confirm("Anda yakin menghapus?"))
  {
    $.get("<?php echo base_url()?>index.php/"+classnya+"/hapus_libur/"+id,function(e){
      eksekusi_controller('<?php echo base_url()?>index.php/'+classnya+'/master_libur',document.title);
    })  
  }
  
}

$("#form_tambah_admin").on("submit",function(){
  $("#t4_info_form").html('Loading...');
  if($("#pass_admin").val() != $("#conf_pass_admin").val())
  {
    
    $("#t4_info_form").html("<div class='alert alert-warning'>Password dan Confirm Password tidak sama.</div>").fadeIn().delay(3000).fadeOut();
    return false;
  }

  var ser = $(this).serialize();

      $.ajax({
            url: "<?php echo base_url()?>index.php/"+classnya+"/simpan_master_libur",
            type: "POST",
            contentType: false,
            processData:false,
            data:  new FormData(this),
            beforeSend: function(){
                //alert("sedang uploading...");
            },
            success: function(e){
                console.log(e);
                $("#t4_info_form").html("<div class='alert alert-success'>Berhasil.</div>").fadeIn().delay(3000).fadeOut();
                  setTimeout(function(){
                    $("#myModal").modal('hide');
                  },3000);

                
            },
            error: function(er){
                $("#t4_info_form").html("<div class='alert alert-warning'>Ada masalah! "+er+"</div>");
            }           
       });
  return false;
})


$("#myModal").on("hidden.bs.modal", function () {
  eksekusi_controller('<?php echo base_url()?>index.php/'+classnya+'/master_libur',document.title);
});

$(document).ready(function(){

  $('#tbl_datanya').dataTable();

});
$("#judul2").html("DataTable "+document.title);
</script>
