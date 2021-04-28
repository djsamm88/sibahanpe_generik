<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_lokasi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');		
		$this->load->model('m_lokasi');		
		$this->load->helper('custom_func');				
		$this->load->helper('text');
		date_default_timezone_set("Asia/jakarta");
	}

	public function index(){

		//error_reporting(0);

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
		header('Content-Type: application/json');

		$lat_x = $this->input->get('lat');
		$lng_y = $this->input->get('lng'); 
		$nip = $this->input->get('nip'); 
		$id_opd = $this->input->get('id_opd'); 

		$data['lat_x'] = $lat_x;
		$data['lng_y'] = $lng_y; 
		$data['nip'] = $nip; 
		$data['id_opd'] = $id_opd; 

		$data1 = $this->m_lokasi->m_cek_lokasi($nip);
		$koordinat_all = $data1[0]->koordinat;
		//print_r($koordinat_all);

		$koordinat_all_explode = explode("),(",$koordinat_all);
		foreach ($koordinat_all_explode as $value1) {
			$value1 = str_replace(", "," ",$value1);
			$value1 = str_replace("(","",$value1);
			$value1 = str_replace(")","",$value1);
			$polygon[] = $value1;
		}

		$point = $lat_x." ".$lng_y;

		//$points = array("2.48847736495573 98.1529683642402");
		//$polygon = array("2.4887443888424206 98.1529535715823","2.48847374122775 98.15270814945744","2.4882097927579387 98.1530246501212","2.488497858344176 98.15326202561901","2.4887443888424206 98.1529535715823");
		//print_r($point);
		//print_r($polygon);

		$this->load->library('PointLocation');
		$pointLocation = new PointLocation();

		$cek = $pointLocation->pointInPolygon($point, $polygon);
		
		if($cek=='inside'){
			echo json_encode(array(array("msg"=>"sukses","deskripsi"=>"Anda di posisi")));
		}else if($cek=='outside'){
			echo json_encode(array(array("msg"=>"gagal","deskripsi"=>"Anda tidak di posisi")));
		}else{
			echo json_encode(array(array("msg"=>"gagal","deskripsi"=>"longitude_x dan latitude_y harus isset")));
		}

	}

	public function visual(){
		//error_reporting(0);

		$lat_x = $this->input->get('lat');
		$lng_y = $this->input->get('lng'); 
		$nip = $this->input->get('nip'); 
		$id_opd = $this->input->get('id_opd'); 

		$data['lat_x'] = $lat_x;
		$data['lng_y'] = $lng_y; 
		$data['nip'] = $nip; 
		$data['id_opd'] = $id_opd; 


		$data1 = $this->m_lokasi->m_cek_lokasi($nip);
		//print_r($data1);
		//$koordinat_all = $bb;
		$koordinat_all = $data1[0]->koordinat;
		$koordinat_all = str_replace(")","",$koordinat_all);
		$koordinat_all = str_replace("(","",$koordinat_all);
		$koordinat_all = str_replace(" ","",$koordinat_all);

		$koordinat_all_explode = explode(",",$koordinat_all);

		$i=0;
		foreach ($koordinat_all_explode as $value1) {
			$i++;
			if($i%2==0){
				$koordinat_y_arr[] = $value1;
			}else{
				$koordinat_x_arr[] = $value1;
			}
		}

		//$koordinat_x = array(2.554583014155121, 2.5610996473341987,2.5568981376286746,2.5448937484495056,2.5430073342586277, 2.5483235853591855, 2.550295737445332);
		$data['vertices_x'] = $koordinat_x_arr;

		//$koordinat_y = array(98.31793349204054, 98.32454245505323, 98.33518546042433, 98.32728903708448, 98.32153838095655, 98.31922095236769, 98.3173326772212);
		$data['vertices_y'] = $koordinat_y_arr;

		$this->load->view('v_cek_lokasi',$data);
	}

	public function visual2(){
		error_reporting(0);

		$lat_x = $this->input->get('lat');
		$lng_y = $this->input->get('lng'); 
		$nip = $this->input->get('nip'); 
		$id_opd = $this->input->get('id_opd'); 

		$data['lat_x'] = $lat_x;
		$data['lng_y'] = $lng_y; 
		$data['nip'] = $nip; 
		$data['id_opd'] = $id_opd; 

		$data1 = $this->m_cek_lokasi->view($nip,$id_opd);
		$koordinat_all = $data1[0]['koordinat'];
		//print_r($koordinat_all);

		$koordinat_all_explode = explode("),(",$koordinat_all);
		foreach ($koordinat_all_explode as $value1) {
			$value1 = str_replace(", "," ",$value1);
			$value1 = str_replace("(","",$value1);
			$value1 = str_replace(")","",$value1);
			$polygon[] = $value1;
		}

		$point = $lat_x." ".$lng_y;

		//$points = array("2.48847736495573 98.1529683642402");
		//$polygon = array("2.4887443888424206 98.1529535715823","2.48847374122775 98.15270814945744","2.4882097927579387 98.1530246501212","2.488497858344176 98.15326202561901","2.4887443888424206 98.1529535715823");
		//print_r($point);
		//print_r($polygon);

		$this->load->library('PointLocation');
		$pointLocation = new PointLocation();

		$cek = $pointLocation->pointInPolygon($point, $polygon);

		if($cek=='inside'){
			$data['warning'] = "Selamat!!! Lokasi anda tepat, Silahkan lanjutkan.";
			$data['zoom'] = 17;
		}else if($cek=='outside'){
			$data['warning'] = "Warning!!! anda diluar lokasi!!!";
			$data['zoom'] = 17;
		}else{
			$data['warning'] = "longitude_x dan latitude_y harus isset";
			$data['zoom'] = 17;
		}
		$this->load->view('v_cek_lokasi',$data);
	}
}