<?php 
require_once("connect.php");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set("Asia/jakarta");
//set_time_limit(1000);
$q = $db->query("SELECT * FROM `tbl_struktur` GROUP BY ID_OPD");

$arr_opd 	= array();

while($data = $q->fetch_object())
{
	
	$opd['ID_OPD']	= $data->ID_OPD;
	$opd['OPD']		= $data->OPD;
	
	array_push($arr_opd,$opd);

}



echo json_encode($arr_opd);

