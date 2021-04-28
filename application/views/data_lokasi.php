
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
              
              <button class="btn btn-primary" id="tambah_data"  onclick="tambah()">Tambah Data</button> 
              
<div class="table-responisve">
<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
              <th width="10px">ID LOKASI</th>           
              <th>Nama Lokasi</th>                                   
              <th>Koordinat</th>                                   
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
                <td>$x->id</td>
                <td>$x->nama_lokasi</td>                
                <td>$x->koordinat</td>                
                                         
                
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


            <div class="col-sm-4">Nama Lokasi </div>
            <div class="col-sm-8"><input type="text" name="nama_lokasi" id="nama_lokasi" required="required" class="form-control" placeholder="nama_lokasi"></div>
            <div style="clear: both;"></div><br>

            <div class="col-sm-4">Koordinat </div>
            <div class="col-sm-8"><textarea name="koordinat" id="koordinat" required="required" class="form-control" placeholder="koordinat"></textarea>
            <button type="button" class="btn btn-primary btn-xs" onclick="buka_popup_koordinat($(this))">Ambil koordinat</button>
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


hanya_nomor(".nomor");
function edit(id)
{
  $.get("<?php echo base_url()?>index.php/"+classnya+"/by_id/"+id,function(e){
    //console.log(e[0].id);
    $("#id").val(e[0].id);
    $("#nama_lokasi").val(e[0].nama_lokasi);    
    $("#koordinat").val(e[0].koordinat);

    
  })
  $("#myModal").modal('show');
}

function buka_popup_koordinat(ini)
{
  var koordinat = ini.parent().find("#koordinat").val();
  window.opener=self;
    window.open("<?php echo base_url();?>index.php/lokasi/koordinat/?koordinat="+koordinat,"","resizable=no,toolbar=no,menubar=no,scrollBars=yes,directories=no,location=no,status=no,width=1250,height=600,left=10,top=10");
}

function refreshFromPopup(koordinat){
  $("#koordinat").val(koordinat); 
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
    $.get("<?php echo base_url()?>index.php/"+classnya+"/hapus/"+id,function(e){
      eksekusi_controller('<?php echo base_url()?>index.php/'+classnya+'/data',document.title);
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
            url: "<?php echo base_url()?>index.php/"+classnya+"/simpan_form",
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
  eksekusi_controller('<?php echo base_url()?>index.php/'+classnya+'/data',document.title);
});

$(document).ready(function(){

  $('#tbl_datanya').dataTable();

});
$("#judul2").html("DataTable "+document.title);
</script>
