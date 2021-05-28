<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

	class M_opd extends CI_Model {
		
		function __construct() {
			parent::__construct();
		
			$this->load->helper('custom_func');
		}


	public function m_data()
	{
		$q = $this->db->query("SELECT a.*,b.user_admin FROM `tbl_struktur` a 
								LEFT JOIN tbl_super_admin b ON a.ID_OPD=b.ID_OPD
							");
		return $q->result();
	}

	public function m_by_id($id)
	{
		$q = $this->db->query("SELECT a.*,b.user_admin FROM `tbl_struktur` a 
								LEFT JOIN tbl_super_admin b ON a.ID_OPD=b.ID_OPD
							WHERE a.id='$id'");
		return $q->result();
	}




	public function tambah_data($serialize)
	{
		$this->db->set($serialize);
		$this->db->insert('tbl_struktur');
	}


	public function update_data($serialize,$id)
	{
		$this->db->set($serialize);
		$this->db->where('id',$id);
		$this->db->update('tbl_struktur');
	}

	public function m_hapus_data($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('tbl_struktur');
	}

}