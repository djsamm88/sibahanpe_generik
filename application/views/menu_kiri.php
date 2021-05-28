
        <li>
          <a href="<?php echo base_url()?>index.php/welcome">
            <i class="fa fa-home"></i> <span>Beranda</span>
          </a>
        </li>



        <?php 
        //admin
        if($this->session->userdata('level')=='1')
        {
        ?>

        <li>
          <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/admin/data_admin','Master Admin');return false;">
            <i class="fa fa-lock"></i> <span>Master Admin</span>
          </a>
        </li>
        


        <li class="treeview">
          
          <a href="#"><i class="fa fa-database"></i> <span>Master Staff <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/staff/data','Master Staff');return false;">
                <i class="fa fa-link"></i> <span>Data Staff</span>
              </a>
            </li>

            
            
          </ul>
        </li>

        <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/master_sift','Master Sift');return false;">
                <i class="fa fa-link"></i> <span>Data Shift</span>
              </a>
            </li>


        <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/master_libur','Master Libur');return false;">
                <i class="fa fa-link"></i> <span>Data Libur</span>
              </a>
            </li>



        <li class="treeview">
          
          <a href="#"><i class="fa fa-database"></i> <span>Master OPD <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/opd/data','Master Staff');return false;">
                <i class="fa fa-link"></i> <span>Data OPD</span>
              </a>
            </li>

            
            
          </ul>
        </li>




        <li class="treeview">
          
          <a href="#"><i class="fa fa-database"></i> <span>Master Lokasi <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/lokasi/data','Master Lokasi');return false;">
                <i class="fa fa-link"></i> <span>Data Lokasi</span>
              </a>
            </li>

            <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/lokasi/form_set_lokasi','Set Lokasi');return false;">
                <i class="fa fa-link"></i> <span>Set Lokasi</span>
              </a>
            </li>

            
            
          </ul>
        </li>



        <li class="treeview">
          
          <a href="#"><i class="fa fa-gear"></i> <span>Pengaturan Shift <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/staff/set_shift','Set Shift');return false;">
                <i class="fa fa-link"></i> <span>Set Shift</span>
              </a>
            </li>

            <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/lokasi/form_set_lokasi','Set Lokasi');return false;">
                <i class="fa fa-link"></i> <span>Set Lokasi</span>
              </a>
            </li>

            
            
          </ul>
        </li>









            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/dinas_luar/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Dinas Luar');return false;">
                <i class="fa fa-link"></i> <span>Dinas Luar <span class='badge badge_dinas_luar'></span></span>
              </a>
            </li>



            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/cuti_lain/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Ijin Lain');return false;">
                <i class="fa fa-link"></i> <span>Ijin Lainnya <span class='badge badge_ijin_lain'></span></span>
              </a>
            </li>


            


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/log_absensi/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+1 days'));?>','Log Absensi');return false;">
                <i class="fa fa-link"></i> <span>Log Absensi</span>
              </a>
            </li>


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/form_lap_by_nip/','Lap Absensi');return false;">
                <i class="fa fa-link"></i> <span>Lap Absensi</span>
              </a>
            </li>


        <?php }?>



        <?php 
        //staff
        if($this->session->userdata('level')=='3')
        {
        ?>

     


        <li class="treeview">
          
          <a href="#"><i class="fa fa-gear"></i> <span>Pengaturan Shift <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/staff/set_shift','Set Shift');return false;">
                <i class="fa fa-link"></i> <span>Set Shift</span>
              </a>
            </li>

            <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/lokasi/form_set_lokasi','Set Lokasi');return false;">
                <i class="fa fa-link"></i> <span>Set Lokasi</span>
              </a>
            </li>

            
            
          </ul>
        </li>









            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/dinas_luar/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Dinas Luar');return false;">
                <i class="fa fa-link"></i> <span>Dinas Luar <span class='badge badge_dinas_luar'></span></span>
              </a>
            </li>



            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/cuti_lain/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Ijin Lain');return false;">
                <i class="fa fa-link"></i> <span>Ijin Lainnya <span class='badge badge_ijin_lain'></span></span>
              </a>
            </li>


            


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/log_absensi/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+1 days'));?>','Log Absensi');return false;">
                <i class="fa fa-link"></i> <span>Log Absensi</span>
              </a>
            </li>


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/form_lap_by_nip/','Lap Absensi');return false;">
                <i class="fa fa-link"></i> <span>Lap Absensi</span>
              </a>
            </li>


        <?php }?>





        <?php 
        //admin OPD
        if($this->session->userdata('level')=='2')
        {
        ?>

       <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/staff/data','Master Staff');return false;">
                <i class="fa fa-link"></i> <span>Data Staff</span>
              </a>
            </li>

            


        <li class="treeview">
          
          <a href="#"><i class="fa fa-gear"></i> <span>Pengaturan Shift <span class="label label-danger pull-right badge_barang"></span></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>

          <ul class="treeview-menu">
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/staff/set_shift','Set Shift');return false;">
                <i class="fa fa-link"></i> <span>Set Shift</span>
              </a>
            </li>

            <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/lokasi/form_set_lokasi','Set Lokasi');return false;">
                <i class="fa fa-link"></i> <span>Set Lokasi</span>
              </a>
            </li>

            
            
          </ul>
        </li>









            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/dinas_luar/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Dinas Luar');return false;">
                <i class="fa fa-link"></i> <span>Dinas Luar <span class='badge badge_dinas_luar'></span></span>
              </a>
            </li>



            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/cuti_lain/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+7 days'));?>','Ijin Lain');return false;">
                <i class="fa fa-link"></i> <span>Ijin Lainnya <span class='badge badge_ijin_lain'></span></span>
              </a>
            </li>


            


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/log_absensi/?tgl_awal=<?php echo date('Y-m-').'01'?>&tgl_akhir=<?php echo date('Y-m-d',strtotime('+1 days'));?>','Log Absensi');return false;">
                <i class="fa fa-link"></i> <span>Log Absensi</span>
              </a>
            </li>


            
             <li>
              <a href="#" onclick="eksekusi_controller('<?php echo base_url()?>index.php/absensi/form_lap_by_nip/','Lap Absensi');return false;">
                <i class="fa fa-link"></i> <span>Lap Absensi</span>
              </a>
            </li>


        <?php }?>


        
        
        <li>
          <a href="#">
             &nbsp;
          </a>
        </li>


            
           