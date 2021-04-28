<?php 
require_once("connect.php");
header('Content-Type: application/json');
date_default_timezone_set("Asia/jakarta");
//set_time_limit(1000);

if(!isset($_GET['NIP']))
{
	$err = array();
	$err['msg']='NIP Required.';
	echo json_encode($err);
	die();
}


$NIP = $_GET['NIP'];


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
											tbl_struktur b 
										ON LEFT(a.Fid , 3)=b.ID_OPD					
					WHERE REPLACE(a.NIK, ' ', '')='$NIP'
					GROUP BY ID_OPD
					");

$arr_staff 	= array();

$arr_staff['count'] = $q->num_rows;

while($data = $q->fetch_object())
{
	
	$arr_staff['FID']	= trim($data->FID);
	$arr_staff['NIP']		= trim($data->NIP);
	$arr_staff['NAMA']	= $data->Nama;		
	$arr_staff['NPWP']	= $data->npwp;
	$arr_staff['PANGKAT']	= $data->pangkat;
	$arr_staff['GOL']		= $data->golongan;
	$arr_staff['JABATAN']	= $data->JABATAN;
	$arr_staff['ID_OPD']	= $data->ID_OPD;
	$arr_staff['OPD']		= $data->OPD;
	
	if($data->passcetak=='')
	{
		$pass=md5($data->NIP);
        $data->passcetak = $data->NIP;
	}else{
		$pass=md5($data->passcetak);
	}
	
	$arr_staff['PASS']	= $pass;
	$arr_staff['COSTUM_2']	= $data->passcetak;
	
	

}



echo json_encode(array($arr_staff));

//print_r($arr_staff);