<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');				
		$this->load->helper('custom_func');
		if ($this->session->userdata('id_admin')=="") {
			redirect(base_url().'index.php/login');
		}
		$this->load->helper('text');
		date_default_timezone_set("Asia/jakarta");
		//$this->load->library('datatables');
		$this->load->model('m_admin');
		

		
	}

	public function index()
	{
		/*jika admin opd*/
		if($this->session->userdata('level')==2)
		{
			$ID_OPD = $this->session->userdata('ID_OPD');
			$where =" WHERE  LEFT(Fid , 3)='$ID_OPD'";
		}else{
			$where="";
		}
		/*jika admin opd*/

		$q_pengguna = $this->db->query("SELECT COUNT(*) AS penguna FROM hr_staff_info $where");
		$data['penguna'] = $q_pengguna->result()[0]->penguna;

		$tbl_lokasi = $this->db->query("SELECT COUNT(*) AS lokasi FROM tbl_lokasi ");
		$data['lokasi'] = $tbl_lokasi->result()[0]->lokasi;


		$master_sift = $this->db->query("SELECT COUNT(*) AS shift FROM master_sift");
		$data['shift'] = $master_sift->result()[0]->shift;

		
		$tbl_struktur = $this->db->query("SELECT COUNT(*) AS OPD FROM tbl_struktur");
		$data['opd'] = $tbl_struktur->result()[0]->OPD;

		
		$data['session'] = $this->session->userdata();		
		$this->load->view('welcome_message',$data);
	}



	public function simpan_chat()
	{
		$data = $this->input->post();
		$this->db->insert('tbl_chat',$data);
	}

	

}
