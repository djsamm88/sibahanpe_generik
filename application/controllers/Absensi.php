<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {
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
		$this->load->model('m_absensi');
		

	}


	public function form_lap_by_nip()
	{
		
		$this->load->view('form_lap_by_nip');
		
	}

	public function go_lap_by_nip()
	{
		$data['nik'] = trim($this->input->post('nik'));
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$this->load->view('go_lap_by_nip',$data);
		
	}

	public function go_lap_by_nip_xl()
	{
		
		
		$data['nik'] = $this->input->get('nik');
		$data['bulan'] = $this->input->get('bulan');
		$data['tahun'] = $this->input->get('tahun');

		$file="Laporan Absensi ".$data['nik']."-".$data['bulan']."-".$data['tahun']." .xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	

		$this->load->view('go_lap_by_nip_xl',$data);
		
	}

	public function log_absensi()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->log_absensi($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$this->load->view('log_absensi',$data);
		
	}


	public function log_absensi_xl()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->log_absensi($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$file="Log_absensi_ $tgl_awal - $tgl_akhir _.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	
		$this->load->view('log_absensi_xl',$data);
		
	}


	public function dinas_luar()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->dinas_luar($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$this->load->view('dinas_luar',$data);
		
	}

	public function count_dinas_luar()
	{
		/*jika admin opd*/
		if($this->session->userdata('level')==2)
		{
			$ID_OPD = $this->session->userdata('ID_OPD');
			$where =" AND  LEFT(FID , 3)='$ID_OPD'";
		}else{
			$where="";
		}
		/*jika admin opd*/


		$q = $this->db->query("SELECT COUNT(*) AS dinas FROM tbl_dinas_luar WHERE status='pending' $where");
		if($q->result()[0]->dinas >0)
		{
			echo $q->result()[0]->dinas;
		}
	}

	public function count_ijin_lain()
	{
		/*jika admin opd*/
		if($this->session->userdata('level')==2)
		{
			$ID_OPD = $this->session->userdata('ID_OPD');
			$where =" AND  LEFT(FID , 3)='$ID_OPD'";
		}else{
			$where="";
		}
		/*jika admin opd*/

		$q = $this->db->query("SELECT COUNT(*) AS lain FROM tbl_cuti_lain WHERE status='pending' $where");
		if($q->result()[0]->lain >0)
		{
			echo $q->result()[0]->lain;
		}
	}


	public function dinas_luar_xl()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->dinas_luar($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$file="dinas_luar_xl $tgl_awal - $tgl_akhir _.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	

		$this->load->view('dinas_luar_xl',$data);
		
	}

	public function setujui_dl()
	{
		$action = $this->input->get('action');
		$id 		= $this->input->get('id');

		$status = $action==1?"approve":"cancel";

		$this->db->query("UPDATE tbl_dinas_luar SET status='$status' WHERE id='$id'");
	}




	public function cuti_lain()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->cuti_lain($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$this->load->view('cuti_lain',$data);
		
	}


	public function cuti_lain_xl()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->cuti_lain($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$file="cuti_lain_xl $tgl_awal - $tgl_akhir _.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	

		$this->load->view('cuti_lain_xl',$data);
		
	}

	public function setujui_cuti_lain()
	{
		$action = $this->input->get('action');
		$id 		= $this->input->get('id');

		$status = $action==1?"approve":"cancel";

		$this->db->query("UPDATE tbl_cuti_lain SET status='$status' WHERE id='$id'");
	}




// sift


	public function master_sift()
	{
		
		$data['all'] = $this->m_absensi->master_sift();		
		$this->load->view('master_sift',$data);
		
	}


	public function master_sift_by_id($id)
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_absensi->master_sift_by_id($id);
		echo json_encode($data['all']);
	}



	public function simpan_master_sift()
	{
		$id = $this->input->post('id');
		
		$serialize = $this->input->post();

		

		if($id=='')
		{
			
			$this->m_absensi->tambah_data_master_sift($serialize);
			die('1');
		}else{
			
			$this->m_absensi->update_data_master_sift($serialize,$id);
			die('1');			

		}
		
	}

	public function master_sift_xl()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->master_sift($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$file="master_sift_xl $tgl_awal - $tgl_akhir _.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	

		$this->load->view('master_sift_xl',$data);
		
	}



// libur


	public function master_libur()
	{
		
		$data['all'] = $this->m_absensi->master_libur();		
		$this->load->view('master_libur',$data);
		
	}


	public function master_libur_by_id($id)
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_absensi->master_libur_by_id($id);
		echo json_encode($data['all']);
	}



	public function simpan_master_libur()
	{
		$id = $this->input->post('id');
		
		$serialize = $this->input->post();

		

		if($id=='')
		{
			
			$this->m_absensi->tambah_data_master_libur($serialize);
			die('1');
		}else{
			
			$this->m_absensi->update_data_master_libur($serialize,$id);
			die('1');			

		}
		
	}

	public function hapus_libur($id)
	{
		$this->db->query("DELETE FROM master_libur WHERE id='$id'");
	}

	public function master_libur_xl()
	{
		$tgl_awal = $this->input->get('tgl_awal');
		$tgl_akhir = $this->input->get('tgl_akhir');
		$data['all'] = $this->m_absensi->master_libur($tgl_awal,$tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$file="master_libur_xl $tgl_awal - $tgl_akhir _.xls";
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");	

		$this->load->view('master_libur_xl',$data);
		
	}

}
