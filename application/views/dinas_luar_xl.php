
          <h3 class="box-title" id="judul2">Log Dinas Luar <?php echo $tgl_awal?> s/d <?php echo $tgl_akhir?></h3>

         <table class="table table-bordered" id="tbl_log" border="1">
           <thead>
             <tr>
                <th>No.</th>
                <th>Nama</th>                
                <th>Tanggal</th>
                <th>Ket.</th>
                <th>Status</th>
                
                
             </tr>
           </thead>
           <tbody>
             <?php 
             $no=0;         
             
              foreach ($all as $key) {
                $no++;
             
                echo "
                  <tr>
                    <td>$no</td>                    
                    <td>$key->Nama <br> <i>$key->NIK</i></td>
                    <td>".tglindo($key->tanggal)."</td>
                    <td>$key->keterangan </td>
                    <td>$key->status </td>                    
                  </tr>
                ";
              }
             ?>
             
           </tbody>
           
         </table>
