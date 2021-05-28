<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

	class M_staff extends CI_Model {
		
		function __construct() {
			parent::__construct();
		
			$this->load->helper('custom_func');
		}


	public function m_data()
	{
		/*jika admin opd*/
		if($this->session->userdata('level')==2)
		{
			$ID_OPD = $this->session->userdata('ID_OPD');
			$where =" WHERE LEFT(a.Fid , 3)='$ID_OPD'";
		}else{
			$where="";
		}

		$q = $this->db->query("SELECT a.*,b.OPD,c.nama_sift,c.masuk,c.keluar,d.nama_lokasi,d.id_lokasi
				FROM `hr_staff_info` a 
				LEFT JOIN tbl_struktur b ON LEFT(a.FID,3)=b.ID_OPD
				LEFT JOIN master_sift c ON a.COSTUM_8=c.id
				LEFT JOIN (
					SELECT a.nip,b.nama_lokasi,a.id_lokasi FROM `tbl_set_lokasi` a 
					LEFT JOIN tbl_lokasi b ON a.id_lokasi=b.id
				)d ON a.NIK=d.nip
				$where
				");
		return $q->result();
	}

	public function m_by_id($id)
	{
		$q = $this->db->query("SELECT a.*,b.OPD,c.nama_sift,c.masuk,c.keluar,d.nama_lokasi,d.id_lokasi
				FROM `hr_staff_info` a 
				LEFT JOIN tbl_struktur b ON LEFT(a.FID,3)=b.ID_OPD
				LEFT JOIN master_sift c ON a.COSTUM_8=c.id
				LEFT JOIN (
					SELECT a.nip,b.nama_lokasi,a.id_lokasi FROM `tbl_set_lokasi` a 
					LEFT JOIN tbl_lokasi b ON a.id_lokasi=b.id
				)d ON a.NIK=d.nip
				 WHERE a.id='$id'");
		return $q->result();
	}



	public function m_by_nip($nip)
	{
		$q = $this->db->query("SELECT a.*,b.OPD,c.nama_sift,c.masuk,c.keluar,d.nama_lokasi,d.id_lokasi
				FROM `hr_staff_info` a 
				LEFT JOIN tbl_struktur b ON LEFT(a.FID,3)=b.ID_OPD
				LEFT JOIN master_sift c ON a.COSTUM_8=c.id
				LEFT JOIN (
					SELECT a.nip,b.nama_lokasi,a.id_lokasi FROM `tbl_set_lokasi` a 
					LEFT JOIN tbl_lokasi b ON a.id_lokasi=b.id
				)d ON a.NIK=d.nip
				 WHERE a.NIK='$nip'");
		return $q->result();
	}




	public function tambah_data($serialize)
	{
		$this->db->set($serialize);
		$this->db->insert('hr_staff_info');
	}


	public function update_data($serialize,$id)
	{
		$this->db->set($serialize);
		$this->db->where('id',$id);
		$this->db->update('hr_staff_info');
	}

	public function m_hapus_data($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('hr_staff_info');
	}


}