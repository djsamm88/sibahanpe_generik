<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');		
		$this->load->model('m_absensi');
		$this->load->model('m_staff');
		$this->load->helper('custom_func');
		
		$this->load->helper('text');
		date_default_timezone_set("Asia/jakarta");
		
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
		header('Content-Type: application/json');
	}
	
	
	
	public function dapat_absen_by_nik()
	{
		
		$nik = $this->input->get('nik', TRUE);
		$bulan = $this->input->get('bulan', TRUE);
		$tahun = $this->input->get('tahun', TRUE);
		$q_tgl_bulan_ini = $this->m_absensi->m_tanggal_berisi_bulan($bulan,$tahun);
		
		
		
		
		$a = array();		
		$b = array();		
		foreach($q_tgl_bulan_ini as $tgl)
		{
			$a[] = $this->m_absensi->m_absen_by_nik($nik,$tgl->tanggal);			
			$b[] = $tgl->tanggal;
		}
		$data['absen_by_nik']=$a;
		$data['tgl']=$b;
		$data['tgl_libur']=$this->m_absensi->m_tbl_libur($bulan,$tahun);
		$data['tgl_sakit']=$this->m_absensi->m_tbl_surat_sakit($nik,$bulan);
		$data['tgl_dinas']=$this->m_absensi->m_tbl_dinas_luar($nik,$bulan);
		$data['tgl_cut_sak']=$this->m_absensi->m_tbl_cuti_sakit($nik,$bulan);
		$data['tgl_cut_la']=$this->m_absensi->m_tbl_cuti_lain($nik,$bulan);
    $data['tgl_cut_tah']=$this->m_absensi->m_tbl_cuti_tahunan($nik,$bulan);
		$data['tbl_surat_ijin_keterangan']=$this->m_absensi->m_tbl_surat_ijin_keterangan($nik,$bulan);
		//ambil_data dari e kinerja
		$data['ekinerja'] = json_decode(exec_url("https://ekinerja.pakpakbharatkab.go.id/res/get_json_hasil.php?menu=laporan_bulanan&judul=Laporan%20Bulanan&aksi=cari&bulan=$bulan&keywords=$tahun&nip=$nik"));
		
		
		$data['bulan'] = $bulan;
		$this->load->view('template/part/api_absen.php',$data);
	}
	
	
	
	public function absensi_by_nip()
	{
		
		$nik = $this->input->get('nik', TRUE);
		$bulan = $this->input->get('bulan', TRUE);
		$tahun = $this->input->get('tahun', TRUE);
		$q_tgl_bulan_ini = $this->m_absensi->m_tanggal_berisi_bulan($bulan,$tahun);
		
		
		
		
		$a = array();		
		$b = array();		
		foreach($q_tgl_bulan_ini as $tgl)
		{
			$a[] = $this->m_absensi->m_absen_by_nik($nik,$tgl->tanggal);			
			$b[] = $tgl->tanggal;
		}
		$data['absen_by_nik']=$a;
		$data['tgl']=$b;
		$data['tgl_libur']=$this->m_absensi->m_tbl_libur($bulan,$tahun);
		$data['tgl_sakit']=$this->m_absensi->m_tbl_surat_sakit($nik,$bulan);
		$data['tgl_dinas']=$this->m_absensi->m_tbl_dinas_luar($nik,$bulan);
		$data['tgl_cut_sak']=$this->m_absensi->m_tbl_cuti_sakit($nik,$bulan);
		$data['tgl_cut_la']=$this->m_absensi->m_tbl_cuti_lain($nik,$bulan);
        $data['tgl_cut_tah']=$this->m_absensi->m_tbl_cuti_tahunan($nik,$bulan);
		$data['tbl_surat_ijin_keterangan']=$this->m_absensi->m_tbl_surat_ijin_keterangan($nik,$bulan);
		//ambil_data dari e kinerja
		$data['ekinerja'] = json_decode(exec_url("https://ekinerja.pakpakbharatkab.go.id/res/get_json_hasil2.php?menu=laporan_bulanan&judul=Laporan%20Bulanan&aksi=cari&bulan=$bulan&keywords=$tahun&nip=$nik"));
		
		
		$data['bulan'] = $bulan;
		$this->load->view('template/part/api_absen.php',$data);
        
        //echo json_encode($data);
	}
	
	
    
	/*****************************************************************************dinas luar*****************************************/
	
	
	public function set_form_dinas_luar()
	{
        $json = file_get_contents('php://input');        
        $data = json_decode($json);
	   //var_dump($json);
	   
        $NIK 		= $data->NIK;
		$FID 		= $data->FID; 
		$tanggal 	= $data->tanggal; 
		$tanggal_antara	= $data->tanggal_antara; 
		$keterangan	= $data->keterangan; 
		
		
		
		$arr_tgl = tanggal_antara($tanggal,$tanggal_antara);
		
		
		
		foreach($arr_tgl as $z)
		{
			
			$serialize = array(
					'FID'			=> $FID,
					'NIK'			=> $NIK,
					'tanggal'		=> $z,
					'keterangan'	=> $keterangan				
				);
			
			//cek kesalahan tanggal
            $datenya = DateTime::createFromFormat("Y-m-d", $z);
            if($datenya->format("Y")==date('Y'))
            {
                $libur = $this->m_absensi->m_set_form_dinas_luar($serialize);    
            }
			
			
		}
		
		
		
		
	}
	
	

	
	public function data_dinas_luar_by_nik()
	{
        $nip = $this->input->get('nik');
		$q = $this->db->query("SELECT * FROM  `tbl_dinas_luar` WHERE NIK='$nip' AND YEAR(NOW())=YEAR(tanggal) ORDER BY tanggal DESC");
        $qq = $q->result();
        
        echo json_encode($qq);
        
	}
	
	
	
	/*****************************************************************************dinas luar*****************************************/
	
	
	
    
    
	
	
	/*****************************************************************************cuti sakit*****************************************/
	
    
	
	
	public function set_form_cuti_sakit()
	{
				
        $json = file_get_contents('php://input');        
        $data = json_decode($json);
        $NIK 		= $data->NIK;
		$FID 		= $data->FID; 
		$tanggal 	= $data->tanggal; 		
		$keterangan	= $data->keterangan; 
		
	   
		
		
		
		$serialize = array(
				'FID'			=> $FID,
				'NIK'			=> $NIK,
				'tanggal'		=> $tanggal,
				'keterangan'	=> $keterangan				
			);
		
		$libur = $this->m_absensi->m_set_form_cuti_lain($serialize);
		
	}
	
	
	
	public function data_cuti_sakit_by_nik()
	{
		$nip = $this->input->get('nik');
		$q = $this->db->query("SELECT * FROM  `tbl_cuti_sakit` WHERE NIK='$nip' AND YEAR(NOW())=YEAR(tanggal) ORDER BY tanggal DESC");
        $qq = $q->result();
        
        echo json_encode($qq);
	}
	
	
	
	
	/*****************************************************************************cuti sakit*****************************************/
	
	
	/*****************************************************************************cuti lain*****************************************/
	
	
	public function set_form_cuti_lain()
	{
		
		$json = file_get_contents('php://input');        
        $data = json_decode($json);
        $NIK 		= $data->NIK;
		$FID 		= $data->FID; 
		$tanggal 	= $data->tanggal; 		
		$keterangan	= $data->keterangan; 
		
		
		$serialize = array(
				'FID'			=> $FID,
				'NIK'			=> $NIK,
				'tanggal'		=> $tanggal,
				'keterangan'	=> $keterangan				
			);
		
		$libur = $this->m_absensi->m_set_form_cuti_lain($serialize);
		
	}
	
	
	public function data_cuti_lain_by_nik()
	{
        $nip = $this->input->get('nik');
		$q = $this->db->query("SELECT * FROM  `tbl_cuti_lain` WHERE NIK='$nip' AND YEAR(NOW())=YEAR(tanggal) ORDER BY tanggal DESC");
        $qq = $q->result();
        
        echo json_encode($qq);
	}
	
	
	
	/*****************************************************************************cuti lain*****************************************/
	
	
	
	/******************************************sakit berganti jadi izin keterangan sah****************************************/
	
	
	
	public function set_form_sakit()
	{
		$json = file_get_contents('php://input');        
        $data = json_decode($json);
        $NIK 		= $data->NIK;
		$FID 		= $data->FID; 
		$tanggal 	= $data->tanggal; 		
		$keterangan	= $data->keterangan; 
		
		
		
		$serialize = array(
				'FID'			=> $FID,
				'NIK'			=> $NIK,
				'tanggal'		=> $tanggal,
				'keterangan'	=> $keterangan				
			);
		
		$libur = $this->m_absensi->m_set_form_sakit($serialize);
		
	}
	
	
	public function data_sakit_by_nik()
	{
				
		$nip = $this->input->get('nik');
		$q = $this->db->query("SELECT * FROM  `tbl_surat_sakit` WHERE NIK='$nip' AND YEAR(NOW())=YEAR(tanggal) ORDER BY tanggal DESC");
        $qq = $q->result();
        
        echo json_encode($qq);
	}
	
	
	
	
	/******************************************sakit berganti jadi izin keterangan sah****************************************/
	
	
	
	
	/*****************************************************************************cuti_tahunan*****************************************/
	

	
	public function set_form_cuti_tahunan()
	{
		
		$json = file_get_contents('php://input');        
        $data = json_decode($json);
	   
        $NIK 		= $data->NIK;
		$FID 		= $data->FID; 
		$tanggal 	= $data->tanggal; 
		$tanggal_antara	= $data->tanggal_antara; 
		$keterangan	= $data->keterangan; 
		
		
		
		$arr_tgl = tanggal_antara($tanggal,$tanggal_antara);
		
		
		
		foreach($arr_tgl as $z)
		{
			
			$serialize = array(
					'FID'			=> $FID,
					'NIK'			=> $NIK,
					'tanggal'		=> $z,
					'keterangan'	=> $keterangan				
				);
			
			
			
			$libur = $this->m_absensi->m_set_form_cuti_tahunan($serialize);
		}
		
		
		
	}
	
	


	public function data_cuti_tahunan_by_nik()
	{
	   $nip = $this->input->get('nik');
		$q = $this->db->query("SELECT * FROM  `tbl_cuti_tahunan` WHERE NIK='$nip' AND YEAR(NOW())=YEAR(tanggal) ORDER BY tanggal DESC");
        $qq = $q->result();
        
        echo json_encode($qq);
        
	}
	
	
	/*****************************************************************************cuti_tahunan*****************************************/
	
	
    
    

	public function gps_lolos()
	{
	   
		$q = $this->db->query("SELECT * FROM  `tbl_gps_lolos` ");
        $qq = $q->result();
        
        echo json_encode($qq);
        
	}
	
    
	
	/******** ini nanti hapus ya *********/
	/*
	public function    simpan_absensi_base64()
	{
		$json = file_get_contents('php://input');        
        $data = json_decode($json);
        
        $Tanggal_Log = date("d/m/Y");
        $Jam_Log = date("H:i:s");
        $DateTime = $Tanggal_Log." ".$Jam_Log;
        
        //echo $DateTime;
        
        if($json)
        {

            $NIP = $data->NIP;
            $Fid = $data->fid;
            $Nama_Staff = $data->nama;

            $lat = $data->lat;
            $lng = $data->lng;
            $base64 = $data->base64;

            $wak = date('YmdHi');
            $image = $this->base64_to_jpeg( $base64, 'bukti_absensi/'.$NIP.'_'.$wak.'.jpg' );


            $this->db->query("INSERT INTO ta_log SET 

                                    lat='$lat',
                                    lng='$lng', 
                                    image='$image', 
                                    Fid='$Fid',
                                    Nama_Staff='$Nama_Staff',
                                    Tanggal_Log='$Tanggal_Log',
                                    Jam_Log='$Jam_Log',
                                    DateTime='$DateTime'                                
                                ");

           
        }else{
           
        }
        
        
	}
	*/
	/******** Hapus sampai sini *********/



	public function    simpan_absensi_base64_new()
	{
		$json = file_get_contents('php://input');        
        $data = json_decode($json);
        
        $Tanggal_Log = date("d/m/Y");
        $Jam_Log = date("H:i:s");
        $DateTime = $Tanggal_Log." ".$Jam_Log;
        
        //echo $DateTime;
        
        if($json)
        {

            $NIP = $data->NIP;
            $Fid = $data->fid;
            $Nama_Staff = $data->nama;

            $lat = $data->lat;
            $lng = $data->lng;
            $base64 = $data->base64;

            $wak = date('YmdHi');
            $image = $this->base64_to_jpeg( $base64, 'bukti_absensi/'.$NIP.'_'.$wak.'.jpg' );


            /**** pengetesan nip... jika tidak melapor, maka bahaya ****/
            if($NIP=='197511072011012002' || $NIP=='198004222010011014' || $NIP=='197207272003121002')
            {
            	$this->db->query("INSERT INTO ta_log_pantau SET 

                                    lat='$lat',
                                    lng='$lng', 
                                    image='$image', 
                                    Fid='$Fid',
                                    Nama_Staff='$Nama_Staff',
                                    Tanggal_Log='$Tanggal_Log',
                                    Jam_Log='$Jam_Log',
                                    DateTime='$DateTime'                                
                                ");
            }else{
            	$this->db->query("INSERT INTO ta_log SET 

                                    lat='$lat',
                                    lng='$lng', 
                                    image='$image', 
                                    Fid='$Fid',
                                    Nama_Staff='$Nama_Staff',
                                    Tanggal_Log='$Tanggal_Log',
                                    Jam_Log='$Jam_Log',
                                    DateTime='$DateTime'                                
                                ");
            }
            /**** pengetesan nip... jika tidak melapor, maka bahaya ****/

            

           
        }else{
           
        }
        
        
	}




	public function    simpan_absensi_base64()
	{
		

		//die();

		$json = file_get_contents('php://input');        
        $data = json_decode($json);
        
        $Tanggal_Log = date("d/m/Y");
        $Jam_Log = date("H:i:s");
        $DateTime = $Tanggal_Log." ".$Jam_Log;
        
        //echo $DateTime;
        
        if($json)
        {

            $NIP = $data->NIP;
            $Fid = $data->fid;
            $Nama_Staff = $data->nama;

            $lat = $data->lat;
            $lng = $data->lng;
            $base64 = $data->base64;
            $In_out = $data->In_out;

            $wak = date('YmdHi');
            $image = $this->base64_to_jpeg( $base64, 'bukti_absensi/'.$NIP.'_'.$wak.'.jpg' );


            $q = $this->m_staff->m_by_nip($NIP);


            $sift_masuk = @$q[0]->masuk;
            $sift_keluar = @$q[0]->keluar;
            $nama_sift = @$q[0]->nama_sift;
            $gaji_pokok = @$q[0]->COSTUM_7;

            	$this->db->query("INSERT INTO ta_log SET 

                                    lat='$lat',
                                    lng='$lng', 
                                    image='$image', 
                                    Fid='$Fid',
                                    nip='$NIP',
                                    Nama_Staff='$Nama_Staff',
                                    Tanggal_Log='$Tanggal_Log',
                                    Jam_Log='$Jam_Log',
                                    In_out='$In_out',
                                    sift_masuk='$sift_masuk',
                                    sift_keluar='$sift_keluar',
                                    nama_sift='$nama_sift',
                                    gaji_pokok='$gaji_pokok',
                                    DateTime='$DateTime'                                
                                ");
            
            

           
        }else{
           
        }
        
        
	}

	

	
	
    private function base64_to_jpeg( $base64_string, $output_file ) 
    {
            $ifp = fopen( $output_file, "wb" ); 
            fwrite( $ifp, base64_decode( $base64_string) ); 
            fclose( $ifp ); 
            return( $output_file ); 
    }


    
	public function all_history_by_nip()
	{
				
		$fid = $this->input->get('fid');
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        
        $x = "SELECT 
                    Id,
                    Fid,                     
                    lat,
                    lng,
                    image,
                    STR_TO_DATE(DateTime,'%d/%m/%Y') AS tanggal,
                    STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS waktu, 
                    Jam_Log AS jam,
                    In_out,
                    CASE
						    WHEN In_out = 'masuk' 
						    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(Jam_Log,sift_masuk))/60),0))
							WHEN In_out = 'pulang' 
							THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(sift_keluar,Jam_Log))/60),0))
						END AS telat 
                FROM ta_log
                WHERE
                    Fid='$fid'    
                    AND
                    (
                        MONTH(STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s'))='$bulan'
                            AND 
                        YEAR(STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s'))='$tahun'
                    ) 
                ORDER BY waktu DESC";
        
		$q = $this->db->query($x);
        $qq = $q->result();
        
        echo json_encode($qq);
	}
	
	
	
	
}
