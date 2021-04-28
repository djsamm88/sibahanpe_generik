
<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%" border="1">
      <thead>
        <tr>
              
              <th>No</th>
              <th width="10px">FID</th>           
              <th>Nama</th>                     
              <th>NIP</th>                     
              <th>Jabatan</th>                     
              <th>Photo</th>                     
              <th>Password</th>                     
                              
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        foreach($all as $x)
        {
          
          $no++;
          
            echo (" 
              
              <tr>
                <td>$no</td>
                <td>$x->FID</td>
                <td>$x->Nama</td>                
                <td>$x->NIK</td>                
                <td>$x->JABATAN</td>                
                <td>$x->PHOTO</td>                
                <td>$x->COSTUM_6</td>                           
                
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>
