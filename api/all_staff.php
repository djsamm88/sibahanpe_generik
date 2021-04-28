<?php 
require_once("connect.php");
header('Content-Type: application/json');
date_default_timezone_set("Asia/jakarta");
set_time_limit(1000);


$q = $db->query("
					SELECT 
											a.FID,
											a.Nama,
											REPLACE(a.NIK, ' ', '') AS NIP,
											a.JABATAN,
											a.COSTUM_3 AS pangkat,
											a.COSTUM_4 AS golongan, 
											a.COSTUM_5 AS npwp ,
											a.COSTUM_2 AS password, 
											a.COSTUM_6 AS passcetak, 
											b.ID_OPD,b.OPD
										FROM 
											hr_staff_info a 
										LEFT JOIN 
											(
                                            	SELECT * FROM tbl_struktur GROUP BY ID_OPD
                                            )b 
										ON LEFT(a.Fid , 3)=b.ID_OPD										
					
		
				");

$arr_opd 	= array();

while($data = $q->fetch_object())
{
	
	
	$opd['FID']		= $data->FID;
	$opd['NIP']		= $data->NIP;
	
	$opd['NAMA']	= $data->Nama;		
	$opd['NPWP']	= $data->npwp;
	$opd['PANGKAT']	= $data->pangkat;
	$opd['GOL']		= $data->golongan;
	$opd['JABATAN']	= $data->JABATAN;
	$opd['ID_OPD']	= $data->ID_OPD;
	$opd['OPD']		= $data->OPD;
	
	array_push($arr_opd,$opd);

}



echo json_encode($arr_opd);

