<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opd extends CI_Controller {
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
		$this->load->model('m_opd');
		

	}



	public function data()
	{
		$data['all'] = $this->m_opd->m_data();	
		$this->load->view('data_opd',$data);
		
	}

	public function data_xl()
	{
		$data['all'] = $this->m_opd->m_data();	
		
		$file="Master_staff.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	
		
		$this->load->view('data_opd_xl',$data);
		
	}



	public function by_id($id)
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_opd->m_by_id($id);
		echo json_encode($data['all']);
	}



	public function simpan_form()
	{
		$id = $this->input->post('id');
		
		$serialize = $this->input->post();

		

		if($id=='')
		{
			
			$this->m_opd->tambah_data($serialize);
			die('1');
		}else{
			
			$this->m_opd->update_data($serialize,$id);
			die('1');			

		}
		

	}

	public function hapus($id)
	{
		$this->m_opd->m_hapus_data($id);
	}


	public function koordinat()
	{
		$this->load->view('koordinat');
	}
}
