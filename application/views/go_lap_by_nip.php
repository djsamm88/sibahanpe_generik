<?php 
$list_date=array();
$month = $bulan;
$year = $tahun;

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
        $list_date[]=date('Y-m-d', $time);
}


?>


<div class="table-responisve">
<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
              <th>Nama</th>                                   
              <th>Tanggal</th>           
              <th>Masuk</th>                                   
              <th>Pulang</th>                                   
              <th>Shift</th>                                   
              <th>Telat</th>                                   
              
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        $total_telat = 0;
        $total_tidak_hadir = 0;
        $total_dinas_luar = 0;
        $total_ijin_lainnya = 0;
        $total_libur=0;
        foreach($list_date as $x)
        {
        	$no++;
        	$class='';
        	 

        	$q = $this->m_absensi->lap_absensi($nik,$x);
          	$y =@$q[0];

          	if($y->masuk ==null && $y->pulang==null)
          	{
          		$class='danger';          		
          		$y->shift='[Tidak Hadir]';
          		$total_tidak_hadir++;
          	}


          	
          	$dinas_luar = $this->m_absensi->dinas_luar_by_nip($nik,$x);
          	$z = @$dinas_luar[0];
          	if(count($dinas_luar)>0)
          	{
          		$class='info';
          		$y->total_telat=0;
          		$y->shift='[Dinas Luar] '.$z->keterangan;
          		$total_dinas_luar++;
          	}

            $libur = $this->m_absensi->libur_by_tgl($x);
            $zz = @$libur[0];
            if(count($libur)>0)
            {
              $class='success';
              $y->total_telat=0;
              $y->shift='[Libur] '.$zz->desc_libur;
              $total_libur++;
            }


          	$ijin_lain = $this->m_absensi->ijin_lain_by_nip($nik,$x);
          	$a = @$ijin_lain[0];
          	if(count($ijin_lain)>0)
          	{
          		$class='warning';
          		$y->total_telat=0;
          		$y->shift='[Ijin Lainnya] '.$a->keterangan;
          		$total_ijin_lainnya++;
          	}

          	

          	$total_telat +=$y->total_telat;

            echo (" 
              
              <tr class='$class'>
                <td>$no</td>
                <td>$y->Nama <br> <i>$nik</i></td>
                <td>$x</td>
                <td>$y->masuk <br>$y->telat_masuk</td>
                <td>$y->pulang <br>$y->cepat_pulang</td>
                <td>$y->shift</td>
                <td>$y->total_telat</td>
                
                      
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>
</div>

<div class="alert alert-info"><b>Info!!! </b> Keterangan kehadiran dibawah</div>
<table class="table table-bordered">
	<tr class="danger" >
		<td width='100px'>Tidak hadir</td> <td><?php echo $total_tidak_hadir?> Hari</td>
	</tr>

	<tr class="">
		<td>Terlambat</td> <td><?php echo $total_telat?> Menit</td>
	</tr>

	<tr class="info">
		<td>Dinas Luar</td> <td><?php echo $total_dinas_luar?> Hari</td>
	</tr>

	<tr class="info">
		<td>Ijin Lainnya</td> <td><?php echo $total_ijin_lainnya?> Hari</td>
	</tr>

    <tr class="info">
    <td>Libur</td> <td><?php echo $total_libur?> Hari</td>
  </tr>

</table>

