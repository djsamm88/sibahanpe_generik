<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');		
		$this->load->model('m_absensi');
		$this->load->helper('custom_func');
		
		$this->load->helper('text');
		date_default_timezone_set("Asia/jakarta");
		
	}
	
    
    
	public function view_history_by_id()
	{
				
		$Id = $this->input->get('id');
        
        $x = "SELECT 
                    Id,
                    Fid,                     
                    lat,
                    lng,
                    image,
                    STR_TO_DATE(DateTime,'%d/%m/%Y') AS tanggal,
                    STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS waktu, 
                    Jam_Log AS jam 
                FROM ta_log
                WHERE
                    Id='$Id'    
                    ";
        
        //echo $x;
		$q = $this->db->query($x);
        $qq = $q->result();
        
        $data['byId'] = $qq[0];
        $this->load->view('maps.php',$data);
	}
	
    
    
}