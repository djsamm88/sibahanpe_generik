Mulai <?php echo $tgl_awal?> s/d <?php echo $tgl_akhir?> 

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
             
                echo "
                  <tr>
                    <td>$no</td>
                    <td>$key->Fid</td>
                    
                    <td>$key->Nama_Staff</td>
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
                      <a href='".base_url()."bukti_absensi/$key->image' target='blank'>$key->image</a>
                    </td>
                  </tr>
                ";
              }
             ?>
             
           </tbody>
           
         </table>
