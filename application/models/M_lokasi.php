<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

	class M_lokasi extends CI_Model {
		
		function __construct() {
			parent::__construct();
		
			$this->load->helper('custom_func');
		}


	public function m_data()
	{
		$q = $this->db->query("SELECT * FROM `tbl_lokasi`");
		return $q->result();
	}

	public function m_by_id($id)
	{
		$q = $this->db->query("SELECT * FROM `tbl_lokasi` WHERE id='$id'");
		return $q->result();
	}




	public function tambah_data($serialize)
	{
		$this->db->set($serialize);
		$this->db->insert('tbl_lokasi');
	}


	public function update_data($serialize,$id)
	{
		$this->db->set($serialize);
		$this->db->where('id',$id);
		$this->db->update('tbl_lokasi');
	}

	public function m_hapus_data($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('tbl_lokasi');
	}

	public function m_cek_lokasi($nip)
	{
		$q = $this->db->query("SELECT a.*,b.OPD,c.nama_sift,c.masuk,c.keluar,d.nama_lokasi,d.id_lokasi,d.koordinat
				FROM `hr_staff_info` a 
				LEFT JOIN tbl_struktur b ON LEFT(a.FID,3)=b.ID_OPD
				LEFT JOIN master_sift c ON a.COSTUM_8=c.id
				LEFT JOIN (
					SELECT a.nip,b.nama_lokasi,a.id_lokasi,b.koordinat FROM `tbl_set_lokasi` a 
					LEFT JOIN tbl_lokasi b ON a.id_lokasi=b.id
				)d ON a.NIK=d.nip
				 WHERE a.NIK='$nip'
				  ");
		return $q->result();
	}

}