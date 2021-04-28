<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

	class M_absensi extends CI_Model {
		
		function __construct() {
			parent::__construct();
		
			$this->load->helper('custom_func');
		}




	public function log_absensi($tgl_awal,$tgl_akhir)
	{
		$q = $this->db->query("
					SELECT a.*,STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS formated,
						CASE
						    WHEN In_out = 'masuk' 
						    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
							WHEN In_out = 'pulang' 
							THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
						END AS telat
						FROM `ta_log` a 
					WHERE STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') 
					BETWEEN '$tgl_awal' AND '$tgl_akhir'
					ORDER BY id DESC
			");
		$x = $q->result();
		return $x;		
	}


	public function lap_absensi($nip,$tanggal)
	{
		$q = $this->db->query("
					


SELECT a.NIK,a.FID,a.Nama,
b.Fid,b.Tanggal_Log,CONCAT(b.sift_masuk,'-',b.sift_keluar,' <br>',b.nama_sift) AS shift, b.Jam_log AS masuk,
b.telat AS telat_masuk,
c.Jam_log AS pulang,
c.telat AS cepat_pulang,
(b.telat+c.telat) AS total_telat
FROM hr_staff_info a 
	LEFT JOIN (

		SELECT a.*,STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS formated, 
		CASE
		    WHEN In_out = 'masuk' 
		    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
			WHEN In_out = 'pulang' 
			THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
		END AS telat
		FROM `ta_log` a 
		WHERE STR_TO_DATE(DateTime,'%d/%m/%Y')='$tanggal' AND In_out='masuk' AND nip='$nip'
		ORDER BY (
		CASE
		    WHEN In_out = 'masuk' 
		    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
			WHEN In_out = 'pulang' 
			THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
		END
		) ASC LIMIT 1

)b
ON a.FID=b.Fid
LEFT JOIN 
(




SELECT a.*,STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS formated, 
CASE
    WHEN In_out = 'masuk' 
    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
	WHEN In_out = 'pulang' 
	THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
END AS telat
FROM `ta_log` a 
WHERE STR_TO_DATE(DateTime,'%d/%m/%Y')='$tanggal' AND In_out='pulang' AND nip='$nip'
ORDER BY (
CASE
    WHEN In_out = 'masuk' 
    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
	WHEN In_out = 'pulang' 
	THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
END
) ASC LIMIT 1

)c
ON a.FID=c.Fid

WHERE a.NIK='$nip'



			");
		$x = $q->result();
		return $x;		
	}




	public function dinas_luar($tgl_awal,$tgl_akhir)
	{
		$q = $this->db->query("
					SELECT a.*,b.Nama,b.NIK
					 FROM tbl_dinas_luar a
					 LEFT JOIN hr_staff_info b 
					 ON a.FID=b.FID
					WHERE a.tanggal
					BETWEEN '$tgl_awal' AND '$tgl_akhir'
					ORDER BY a.id DESC
			");
		$x = $q->result();
		return $x;		
	}



	public function dinas_luar_by_nip($nip,$tanggal)
	{
		$q = $this->db->query("
					SELECT a.*,b.Nama,b.NIK
					 FROM tbl_dinas_luar a
					 LEFT JOIN hr_staff_info b 
					 ON a.FID=b.FID
					WHERE a.tanggal='$tanggal' AND b.NIK='$nip' AND status='approve'
			");
		$x = $q->result();
		return $x;		
	}



		
		/** dinas luar **/
		public function m_set_form_dinas_luar($serialize)
		{	
			
			$this->db->insert('tbl_dinas_luar', $serialize);
		}

		
		
		/** cuti sakit **/
		public function m_set_form_cuti_lain($serialize)
		{	
			
			$this->db->insert('tbl_cuti_lain', $serialize);
		}


	public function cuti_lain($tgl_awal,$tgl_akhir)
	{
		$q = $this->db->query("
					SELECT a.*,b.Nama,b.NIK
					 FROM tbl_cuti_lain a
					 LEFT JOIN hr_staff_info b 
					 ON a.FID=b.FID
					WHERE a.tanggal
					BETWEEN '$tgl_awal' AND '$tgl_akhir'
					ORDER BY a.id DESC
			");
		$x = $q->result();
		return $x;		
	}


	public function ijin_lain_by_nip($nip,$tanggal)
	{
		$q = $this->db->query("
					SELECT a.*,b.Nama,b.NIK
					 FROM tbl_cuti_lain a
					 LEFT JOIN hr_staff_info b 
					 ON a.FID=b.FID
					WHERE a.tanggal='$tanggal' AND b.NIK='$nip' AND status='approve'
			");
		$x = $q->result();
		return $x;		
	}


	
	public function master_sift()
	{
		$q = $this->db->query("
					SELECT * FROM master_sift
			");
		$x = $q->result();
		return $x;		
	}
	
	

	public function master_sift_by_id($id)
	{
		$q = $this->db->query("
					SELECT * FROM master_sift WHERE id='$id'
			");
		$x = $q->result();
		return $x;		
	}



	public function tambah_data_master_sift($serialize)
	{
		$this->db->set($serialize);
		$this->db->insert('master_sift');
	}


	public function update_data_master_sift($serialize,$id)
	{
		$this->db->set($serialize);
		$this->db->where('id',$id);
		$this->db->update('master_sift');
	}
}