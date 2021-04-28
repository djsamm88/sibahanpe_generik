<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
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
		$this->load->model('m_staff');
		$this->load->model('m_absensi');
		

	}



	public function data()
	{
		$data['all'] = $this->m_staff->m_data();
		$data['sift'] = $this->m_absensi->master_sift();
		$this->load->view('data_staff',$data);
		
	}

	public function set_shift()
	{
		$data['all'] = $this->m_staff->m_data();
		$data['sift'] = $this->m_absensi->master_sift();
		$this->load->view('set_shift',$data);
	}

	public function data_xl()
	{
		$data['all'] = $this->m_staff->m_data();	
		
		$file="Master_staff.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	
		
		$this->load->view('data_staff_xl',$data);
		
	}



	public function by_id($id)
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_staff->m_by_id($id);
		echo json_encode($data['all']);
	}



	public function simpan_form()
	{
		$id = $this->input->post('id');
		
		$serialize = $this->input->post();
		
		$serialize['COSTUM_7']=hanya_nomor($serialize['COSTUM_7']);
		
		if($serialize['COSTUM_6']=="")
		{
			unset($serialize['COSTUM_6']);
		}

		if($serialize['COSTUM_6']!="")
		{
			$serialize['COSTUM_2']=md5($serialize['COSTUM_6']);
		}

		if($id=='')
		{
			$serialize['PHOTO'] = upload_file('PHOTO');
			$this->m_staff->tambah_data($serialize);
			die('1');
		}else{
			if(upload_file('PHOTO')!=""){
				$serialize['PHOTO'] = upload_file('PHOTO');	
			}
			$this->m_staff->update_data($serialize,$id);
			die('1');			

		}
		

	}

	public function hapus($id)
	{
		$this->m_staff->m_hapus_data($id);
	}

}
