<?php 

 class Model_cuti extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    private $ci;
    private $ekin;

    function __construct()
    {        
        parent::__construct();
        $this->load->library('encrypt'); 

         $this->ci =& get_instance();
        $this->ci->load->database(); 

        $this->ekine = $this->ci->load->database('ekinerja', TRUE);
        $this->ekine16 = $this->ci->load->database('ekinerja16', TRUE);
        // $this->prod = $this->ci->load->database('ORP1', TRUE);
        
    } 

    public function cari_plt($nrk_plt,$spmu='',$nrk_user=''){
        if($spmu !='' && $nrk_user !=''){
            $sql = "SELECT PG.NRK,PG.NAMA,PG.NIP18,PG.KOLOK,PG.KOJAB,PG.SPMU
                        FROM PERS_PEGAWAI1 pg
                        WHERE PG.NRK  = '".$nrk_plt."'
                        AND PG.NRK  <> '".$nrk_user."'
                        AND PG.SPMU  = '".$spmu."'
                        ";
        }else{
            $sql = "SELECT PG.NRK,PG.NAMA,PG.NIP18,PG.KOLOK,PG.KOJAB,PG.SPMU
                        FROM PERS_PEGAWAI1 pg
                        WHERE PG.NRK  = '".$nrk_plt."'
                        ";
        }
        
        // echo $cek_eselon;exit();
        $query = $this->db->query($sql)->row();
        return $query;
    }

    public function kolok_plt_plh($nrk){
        $sql = "SELECT PG.NRK,PG.NAMA,PG.NIP18,PG.SPMU
                        FROM PERS_PEGAWAI1 pg
                        WHERE PG.NRK  = '".$nrk."' ";
        // echo $cek_eselon;exit();
        $query = $this->db->query($sql)->row();


        $klogad3 = "SELECT KOLOK,NALOK,SPMU,AKTIF
                        FROM PERS_KLOGAD3
                        WHERE SPMU  = '".$query->SPMU."'
                        AND AKTIF = 1
                    ";
        $q_klogad3 = $this->db->query($klogad3)->result();
            
        // $option="";
        // if($query != NULL){
        //     foreach ($q_klogad3 as $key) {
        //         // echo $key->KOLOK;
        //         $option .= "<option value='".$key->KOLOK."'>".$key->NALOK."</option>";
        //     }
        // }
        // exit();

        return $q_klogad3;
    }

    public function get_kojab_tbl($kolok){
        $sql = "SELECT
                        KOLOK,
                        KOJAB,
                        NAJABL
                    FROM
                        PERS_KOJAB_TBL
                    WHERE
                        KOLOK = '".$kolok."'
                    AND AKTIF = 1
                    ORDER BY
                        KDSORT ASC
                    ";
        return $this->db->query($sql)->result();
    }

    public function atasan_cuti($nrk){
        $cek_eselon = "SELECT PG.NRK,PG.KOLOK,PG.KOJAB,PG.SPMU, JBT.ESELON
                        ,JBT.NESELON
                        FROM PERS_PEGAWAI1 pg
                        LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                        WHERE PG.NRK  = '".$nrk."' ";
        // echo $cek_eselon;exit();
        $q_cek_eselon = $this->db->query($cek_eselon)->row();

        #cek pimpinan dari ekin
        $cek_pimpinan = "SELECT count(*) as jml
                            FROM
                            (
                            SELECT
                                kolok,kojab,eselon,unit_id,update_by
                            FROM
                                master_pimpinan_pegawai
                            WHERE
                                update_by = 'AKTIF'
                            AND substr(kolok, 6, 3) <> '350'
                            AND substr(unit_id, 9) NOT IN ('a', 'c', 'd', 'e')
                            )b
                            WHERE b.kolok = '".$q_cek_eselon->KOLOK."' AND b.kojab = '".$q_cek_eselon->KOJAB."' ";
        // echo $cek_pimpinan;exit();
        $q_cek_pimpinan = $this->ekine16->query($cek_pimpinan)->row();
        // echo $q_cek_pimpinan->jml;exit();

        $option="";

        #jika bukan gubernur
        if($nrk != '000000'){
        	#jika merupakan pimpinan berdasarkan data ekin
	        if($q_cek_pimpinan->jml >= 1){

                #jika pegawai adalah sekda
                if($q_cek_eselon->KOLOK == '000001102' && $q_cek_eselon->KOJAB == '000000'){
                    #maka atasan adalah gubernur
                    $cek_atasan_sekda = "SELECT PG.NRK,PG.NIP18,PG.NAMA,PG.KOLOK,PG.KOJAB,PG.SPMU, JBT.ESELON
                        ,JBT.NESELON
                        FROM PERS_PEGAWAI1 pg
                        LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                        WHERE PG.NRK  = '000000' ";
                    $cek_atasan_sekda = $this->db->query($cek_atasan_sekda)->row();
                    $option .= "<option value='".$cek_atasan_sekda->NRK."' selected>".$cek_atasan_sekda->NIP18." - ".$cek_atasan_sekda->NAMA."</option>";
                }else{
                    $cek_sekda = "SELECT PG.NRK,PG.NIP18,PG.NAMA,PG.KOLOK,PG.KOJAB,PG.SPMU, JBT.ESELON
                            ,JBT.NESELON
                            FROM PERS_PEGAWAI1 pg
                            LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                            WHERE PG.KOLOK  = '000001102' AND PG.KOJAB  = '000000' ";
                    // echo $cek_sekda;exit();
                    $q_cek_sekda = $this->db->query($cek_sekda)->row();


                    $option .= "<option value='".$q_cek_sekda->NRK."' selected>".$q_cek_sekda->NIP18." - ".$q_cek_sekda->NAMA."</option>";
                }
	            

	        }else{
	            if($q_cek_eselon->NESELON == 'NON ESELON'){
	                #cek atasan dari ekin
	                $cek_atasan = "SELECT \"nrk_atasan\",\"nrk_bawahan\" FROM \"vw_kepala_bawahan\" WHERE \"nrk_bawahan\" = '".$nrk."'
	                                ORDER BY \"thbl\" DESC LIMIT 1 ";
	                $q_cek_atasan = $this->ekine16->query($cek_atasan)->row();

	                #data atasan dari simpeg
	                $cek_atasan2 = "SELECT PG.NRK,PG.NIP18,PG.NAMA
	                            FROM PERS_PEGAWAI1 pg
	                            WHERE PG.NRK  = '".$q_cek_atasan->nrk_atasan."' ";
	                $q_cek_atasan2 = $this->db->query($cek_atasan2)->row();

	                
	                $option .= "<option value='".$q_cek_atasan2->NRK."' selected>".$q_cek_atasan2->NIP18." - ".$q_cek_atasan2->NAMA."</option>";

	                #data eselon 4 dengan spmu yang sama
	                $cek_eselon_4 = "SELECT PG.NRK,PG.NIP18,PG.NAMA,PG.KOLOK,PG.KOJAB,PG.SPMU, JBT.ESELON
	                            ,JBT.NESELON
	                            FROM PERS_PEGAWAI1 pg
	                            LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
	                            WHERE PG.SPMU  = '".$q_cek_eselon->SPMU."' 
	                            AND JBT.ESELON LIKE '%4%'
	                            AND PG.NRK <> '".$q_cek_atasan2->NRK."' ";
	                $q_cek_eselon_4 = $this->db->query($cek_eselon_4)->result();
	                foreach($q_cek_eselon_4 as $row){
	                   
	                    $option .= "<option value='".$row->NRK."'>".$row->NIP18." - ".$row->NAMA."</option>";
	                    
	                }
	            }else{
	                #cek atasan bawahan berdasarkan kolok,kojab dan spmu
	                $sql_struktur_kojab = "SELECT KOLOK_ATASAN,KOJAB_ATASAN,SPMU_ATASAN 
	                                        FROM PERSDN_STRUKTUR_KOJAB
	                                        WHERE 
	                                            KOLOK_BAWAHAN = '".$q_cek_eselon->KOLOK."'
	                                            AND KOJAB_BAWAHAN = '".$q_cek_eselon->KOJAB."'
	                                            AND SPMU_BAWAHAN  = '".$q_cek_eselon->SPMU."'
	                                        ";
	                // echo $q_cek_eselon->NESELON.'<br>'.$nrk.'<br>'; echo $sql_struktur_kojab;exit();
	                $q_struktur_kojab = $this->db->query($sql_struktur_kojab)->row();
	                // var_dump($q_struktur_kojab);exit();
	                if($q_struktur_kojab==NULL){
	                	$option .= "";
	                }else{
		                #data atasan ada atau tidak di pegawai1 (plt/plh)
		                $cek_sts_atasan = "SELECT COUNT(*) AS JML FROM PERS_PEGAWAI1 
		                                WHERE KOLOK = '".$q_struktur_kojab->KOLOK_ATASAN."' 
		                                AND KOJAB = '".$q_struktur_kojab->KOJAB_ATASAN."'
		                                AND SPMU = '".$q_struktur_kojab->SPMU_ATASAN."'
		                                        ";
		                $q_sts_atasan = $this->db->query($cek_sts_atasan)->row();

		                if($q_sts_atasan->JML >= 1){
		                    #data atasan dari pegawai1
		                    $sql_atasan = "SELECT NRK,NIP18,NAMA FROM PERS_PEGAWAI1 
		                                    WHERE KOLOK = '".$q_struktur_kojab->KOLOK_ATASAN."' 
		                                    AND KOJAB = '".$q_struktur_kojab->KOJAB_ATASAN."'
		                                    AND SPMU = '".$q_struktur_kojab->SPMU_ATASAN."'
		                                            ";
		                    // echo $sql_atasan;exit();
		                    $q_atasan = $this->db->query($sql_atasan)->row();
		                    $option="";
		                    $option .= "<option value='".$q_atasan->NRK."' selected>".$q_atasan->NIP18." - ".$q_atasan->NAMA."</option>";
		                }else{
		                    #data atasan dari plt/plh
		                    $sql_atasan = "SELECT
		                                        PLT.NRK,
		                                        PLT.NIP18,
		                                        PG.NAMA,
		                                        PLT.STATUS,
		                                        PLT.AKTIF
		                                    FROM
		                                        PERS_JABATAN_PLT_HIST PLT
		                                    LEFT JOIN
		                                        PERS_PEGAWAI1 PG ON PLT.NRK = PG.NRK
		                                    WHERE
		                                        PLT.KOLOK = '".$q_struktur_kojab->KOLOK_ATASAN."' 
		                                    AND PLT.KOJAB = '".$q_struktur_kojab->KOJAB_ATASAN."'
		                                    AND PLT.SPMU = '".$q_struktur_kojab->SPMU_ATASAN."'
		                                    AND PLT.AKTIF = 1
		                                            ";
		                    // echo $sql_atasan;exit();
		                    $q_atasan = $this->db->query($sql_atasan)->row();
		                    $option="";
		                    $option .= "<option value='".$q_atasan->NRK."' selected>".$q_atasan->NIP18." - ".$q_atasan->NAMA."</option>";
		                }
	                }
	            }
	        }
        }
        
        
        
        // echo $option;exit();

        return $option;

        
    }

    public function kolok_kojab($nrk){

        $sql = "SELECT NRK,KOLOK,KOJAB FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk."' ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();

    }

    public function cek_pyb($nrk,$kolok,$kojab){
    	#cek data nrk di tabel plt/plh
    	// $cek_plt = "SELECT COUNT(*) AS JML FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// $q_cek_plt = $this->db->query($cek_plt)->row();

        $cek_plt = "SELECT COUNT(*) AS jml FROM history_plt_plh WHERE nrk = '".$nrk."' and flag_status = 'active' ";
        // echo $cek_plt;exit();
        $q_cek_plt = $this->ekine16->query($cek_plt)->row();

        

    	if($q_cek_plt->jml <= 0){
    		$sql = "SELECT COUNT(*) AS JML FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
    	}else{
    		$plt = "SELECT kolok,kojab FROM history_plt_plh WHERE nrk = '".$nrk."' and flag_status = 'active' ";
    		$q_plt = $this->ekine16->query($plt)->row();

    		$sql = "SELECT COUNT(*) AS JML FROM PERS_KOJAB_PYB_CUTI WHERE (KOLOK_PYB = '".$kolok."' OR KOLOK_PYB = '".$q_plt->kolok."') 
    				AND (KOJAB_PYB = '".$kojab."' OR KOJAB_PYB = '".$q_plt->kojab."') ";
    	}
        
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function get_data_pyb($nrk,$kolok,$kojab){
    	// #cek data nrk di tabel plt/plh
    	// $cek_plt = "SELECT COUNT(*) AS JML FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// $q_cek_plt = $this->db->query($cek_plt)->row();

    	// if($q_cek_plt->JML <= 0){
    	// 	$sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
    	// }else{
    	// 	$plt = "SELECT KOLOK,KOJAB FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// 	$q_plt = $this->db->query($plt)->row();

    	// 	$sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE (KOLOK_PYB = '".$kolok."' OR KOLOK_PYB = '".$q_plt->KOLOK."') 
    	// 			AND (KOJAB_PYB = '".$kojab."' OR KOJAB_PYB = '".$q_plt->KOJAB."') ";
    	// }
        
        $sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
        // echo $sql; exit();
        return $this->db->query($sql)->result();
    }

    

    public function get_data_pyb_plt($nrk,$kolok,$kojab){
    	#cek data nrk di tabel plt/plh
    	// $cek_plt = "SELECT COUNT(*) AS JML FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// $q_cek_plt = $this->db->query($cek_plt)->row();

    	// if($q_cek_plt->JML <= 0){
    	// 	$sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
    	// }else{
    	// 	$plt = "SELECT KOLOK,KOJAB FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// 	$q_plt = $this->db->query($plt)->row();

    	// 	$sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE (KOLOK_PYB = '".$kolok."' OR KOLOK_PYB = '".$q_plt->KOLOK."') 
    	// 			AND (KOJAB_PYB = '".$kojab."' OR KOJAB_PYB = '".$q_plt->KOJAB."') ";
    	// }

    	$plt = "SELECT KOLOK,KOJAB FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    		$q_plt = $this->db->query($plt)->row();

    		$sql = "SELECT ESELON,SPMU,KOLOK,KOJAB,JENCUTI FROM PERS_KOJAB_PYB_CUTI WHERE (KOLOK_PYB = '".$kolok."' OR KOLOK_PYB = '".$q_plt->KOLOK."') 
    				AND (KOJAB_PYB = '".$kojab."' OR KOJAB_PYB = '".$q_plt->KOJAB."') ";
        
        // echo $sql; exit();
        return $this->db->query($sql)->result();
    }

    public function count_getStrukturPegawai($nrk){
        $sql = "SELECT COUNT(*) AS JML FROM PERS_CUTI_HIST WHERE NRK_ATASAN = '".$nrk."' ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function count_getStrukturPegawai_old($nrk,$tahun,$thbl){
        $sql = "SELECT count(*) as jml FROM (
                    SELECT DISTINCT
                        vw.nrk_bawahan,
                        peg.nama
                    FROM
                        vw_kepala_bawahan vw
                    LEFT JOIN pegawai_new peg ON vw.nrk_bawahan = peg.nrk
                    WHERE
                        vw.nrk_atasan = '".$nrk."'
                    AND vw.thbl = '".$thbl."'
                ) a";

        // $tahun = substr($thbl, 0,4);

        if (intval($tahun) > 2015) {
            $query = $this->ekine16->query($sql)->row();     
        }else{
            $query = $this->ekine->query($sql)->row();     
        }    

        return $query;   

    }

    public function getStrukturPegawai($nrk,$tahun,$thbl){
        $sql = "SELECT DISTINCT vw.nrk_bawahan, peg.nama
                FROM vw_kepala_bawahan vw
                LEFT JOIN pegawai_new peg ON vw.nrk_bawahan = peg.nrk
                WHERE vw.nrk_atasan = '".$nrk."' AND vw.thbl = '".$thbl."'";

        // $tahun = substr($thbl, 0,4);

        if (intval($tahun) > 2015) {
            $query = $this->ekine16->query($sql)->result();     
        }else{
            $query = $this->ekine->query($sql)->result();     
        }    

        return $query;   

    }

    

    public function get_data_cuti($nrk)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        // if($count_bawahan > 0){
        //     $bawahan = $this->getStrukturPegawai($nrk,$tahun,$thbl);
        //     // var_dump($bawahan);exit();

        //     $nrk_b = "";
        //     foreach ($bawahan as $data) {
        //         $nrk_b .= "'".$data->nrk_bawahan."'," ;           
        //     }

        //     $nrk_bawahan = substr($nrk_b, 0, -1);

        //     $or = "OR a.NRK IN (".$nrk_bawahan.")";
        // }else{
        //     $or = "";
        // }



        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        F.ID_LOKASI,
                        F.KET AS KET_LOKASI
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_CUTI_LOKASI F ON A.ID_LOKASI = F.ID_LOKASI
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE a.NRK = '".$nrk."'
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        F.ID_LOKASI,
                        F.KET AS KET_LOKASI
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_CUTI_LOKASI F ON A.ID_LOKASI = F.ID_LOKASI
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE a.NRK = '".$nrk."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti .= "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";

                if($row->STATUS_CUTI == 8 || $row->STATUS_CUTI == 11){
                    $detail_cuti .= "&nbsp;<button type='button' class='btn btn-sm btn-warning btn-outline' title='Cetak SK' onClick='cetak_sk_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Cetak SK</button>";
                }
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                	<button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                	<button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            // $rubah_ajukan_kembali = "";
            if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\",\"".$row->ID_LOKASI."\");'><i class='fa fa-align-justify'></i></button>

                ";
            }else if($user_login == $row->NRK && ($row->STATUS_CUTI == 1)){
                $verifikasi_atasan = "<button type='button' class='btn btn-danger btn-circle  btn-outline' title='Batalkan pengajuan cuti' onClick='batal_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                ";
            }

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_atasan_old($nrk,$tahun,$thbl)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        $bawahan = $this->getStrukturPegawai($nrk,$tahun,$thbl);
        // var_dump($bawahan);exit();

        $nrk_b = "";
        foreach ($bawahan as $data) {
            $nrk_b .= "'".$data->nrk_bawahan."'," ;           
        }

        $nrk_bawahan = substr($nrk_b, 0, -1);

        $where_nrk_bawahan = " a.NRK IN (".$nrk_bawahan.")";



        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE ".$where_nrk_bawahan."
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE ".$where_nrk_bawahan."
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            $rubah_ajukan_kembali = "";
            if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

                ";
            }

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_atasan($nrk,$tahun,$thbl)
    {
        // echo 'atasan';exit();
        $requestData = $this->input->post(); 
        $user_login = $nrk;
        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE A.NRK_ATASAN = ".$nrk."
                AND A .STATUS_CUTI IN (1,6)
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE A.NRK_ATASAN = ".$nrk."
                AND A .STATUS_CUTI IN (1,6)
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();    

        $cek_gub_sekda = $this->pgw_cuti($user_login);
        // echo $user_login.' - '.$cek_gub_sekda->KOLOK.' - '.$cek_gub_sekda->KOJAB;exit();

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";

            
            if($user_login == '000000' || ($cek_gub_sekda->KOLOK == '000001102' && $cek_gub_sekda->KOJAB == '000000')){
                // $pesan = 'sekda gub';
            }else{
                // $pesan = 'pegawai';
                #tampil jika bukan gubernur dan sekda
                if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                    $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                        <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                        <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                    ";
                }
            }

            // echo $pesan;exit();
            
                
            

            $rubah_ajukan_kembali = "";
            if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

                ";
            }

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_atasan_sudah_validasi($nrk,$tahun,$thbl)
    {
        $requestData = $this->input->post(); 
        $user_login = $nrk;
        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE A.NRK_ATASAN = ".$nrk."
                AND A .STATUS_CUTI NOT IN (1,6)
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE A.NRK_ATASAN = ".$nrk."
                AND A .STATUS_CUTI NOT IN (1,6)
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            $rubah_ajukan_kembali = "";
            if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

                ";
            }

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_pyb($nrk,$thbl)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        $kolok_kojab = $this->kolok_kojab($nrk);
        $pyb = $this->get_data_pyb($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);


        
        // var_dump($pyb);exit();
        if($pyb != NULL){
        	// echo 'dd';
	        $esl = "" ; 
	        $sp = "" ; 
	        $klok = "" ;   
	        $kjab = "" ; 
	        $jncuti = "" ;  
	        foreach ($pyb as $data) {
	            $esl .= "'".$data->ESELON."'," ; 
	            $sp .= "'".$data->SPMU."'," ; 
	            $klok .= "'".$data->KOLOK."'," ;   
	            $kjab .= "'".$data->KOJAB."'," ; 
	            $jncuti .= "'".$data->JENCUTI."'," ;          
	        }

	        $eselon = substr($esl, 0, -1);
	        $spmu = substr($sp, 0, -1);
	        $kolok = substr($klok, 0, -1);
	        $kojab = substr($kjab, 0, -1);
	        $jencuti = substr($jncuti, 0, -1);
	    }else{
	    	// echo 'ff';
	    	$eselon = "''" ; 
	        $spmu = "''" ; 
	        $kolok = "''" ;   
	        $kojab = "''" ; 
	        $jencuti = "''" ; 
	    }

	    // exit();

        // echo $jencuti;exit();

     //    $plt = "SELECT KOLOK,KOJAB,STATUS FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
    	// $q_plt = $this->db->query($plt)->row();


        $plt = "SELECT kolok,kojab,eselon FROM history_plt_plh WHERE nrk = '".$nrk."' and flag_status = 'active' ";
        $q_plt = $this->ekine16->query($plt)->row();
    	// $pyb = $this->get_data_pyb($nrk,$q_plt->KOLOK,$q_plt->KOJAB);

    	 $status_plt = "";
    	if($q_plt!=NULL){
    		$status_plt .= $q_plt->STATUS;
    		$pyb_plt = $this->get_data_pyb($nrk,$q_plt->kolok,$q_plt->kojab);
    		// var_dump($pyb_plt);exit();
        // $pyb_plt = $this->get_data_pyb_plt($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);
    		$esl_plt = "" ; 
	        $sp_plt = "" ; 
	        $klok_plt = "" ;   
	        $kjab_plt = "" ; 
	        $jncuti_plt = "" ; 
	    		foreach ($pyb_plt as $data_plt) {
	            $esl_plt .= "'".$data_plt->ESELON."'," ; 
	            $sp_plt .= "'".$data_plt->SPMU."'," ; 
	            $klok_plt .= "'".$data_plt->KOLOK."'," ;   
	            $kjab_plt .= "'".$data_plt->KOJAB."'," ; 
	            $jncuti_plt .= "'".$data_plt->JENCUTI."'," ;          
	        }

	        $eselon_plt = substr($esl_plt, 0, -1);
	        $spmu_plt = substr($sp_plt, 0, -1);
	        $kolok_plt = substr($klok_plt, 0, -1);
	        $kojab_plt = substr($kjab_plt, 0, -1);
	        $jencuti_plt = substr($jncuti_plt, 0, -1);
        }else{
        	$eselon_plt = "''" ; 
	        $spmu_plt = "''" ; 
	        $kolok_plt = "''" ;   
	        $kojab_plt = "''" ; 
	        $jencuti_plt = "''" ; 
        }


        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok.")
                AND E.KOJAB IN (".$kojab.")
                AND E.SPMU IN (".$spmu.")
                AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND F.ESELON IN (".$eselon.")
                AND A .JENCUTI IN (".$jencuti.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL

                UNION ALL

                SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '".$status_plt."' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok_plt.")
                AND E.KOJAB IN (".$kojab_plt.")
                AND E.SPMU IN (".$spmu_plt.")
                AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND F.ESELON IN (".$eselon_plt.")
                AND A .JENCUTI IN (".$jencuti_plt.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL
                )A";

                
        // echo $sql;exit();
        // AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4 OR A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok.")
                AND E.KOJAB IN (".$kojab.")
                AND E.SPMU IN (".$spmu.")
                AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND F.ESELON IN (".$eselon.")
                AND A .JENCUTI IN (".$jencuti.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL

                UNION ALL

                SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '".$status_plt."' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok_plt.")
                AND E.KOJAB IN (".$kojab_plt.")
                AND E.SPMU IN (".$spmu_plt.")
                AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND F.ESELON IN (".$eselon_plt.")
                AND A .JENCUTI IN (".$jencuti_plt.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_pejabat = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 4)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\",\"".$row->STATUS_PLT."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\",\"".$row->STATUS_PLT."\");'><i class='fa fa-check'></i></button>

                ";
            }else if($user_login != $row->NRK && ($row->STATUS_CUTI == 3)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-warning btn-circle btn-outline' title='Setujui Penangguhan' onClick='verif_setujui_penangguhan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\",\"".$row->STATUS_PLT."\");'><i class='fa fa-check'></i></button>

                ";
            }

            // $rubah_ajukan_kembali = "";
            // if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
            //     $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

            //     ";
            // }

            $nestedData[] = $detail_cuti.' '.$verifikasi_pejabat
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_pyb_2($nrk,$thbl)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        $kolok_kojab = $this->kolok_kojab($nrk);
        $pyb = $this->get_data_pyb($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);


        
        // var_dump($pyb);exit();
        if($pyb != NULL){
            // echo 'dd';
            $esl = "" ; 
            $sp = "" ; 
            $klok = "" ;   
            $kjab = "" ; 
            $jncuti = "" ;  
            foreach ($pyb as $data) {
                $esl .= "'".$data->ESELON."'," ; 
                $sp .= "'".$data->SPMU."'," ; 
                $klok .= "'".$data->KOLOK."'," ;   
                $kjab .= "'".$data->KOJAB."'," ; 
                $jncuti .= "'".$data->JENCUTI."'," ;          
            }

            $eselon = substr($esl, 0, -1);
            $spmu = substr($sp, 0, -1);
            $kolok = substr($klok, 0, -1);
            $kojab = substr($kjab, 0, -1);
            $jencuti = substr($jncuti, 0, -1);
        }else{
            // echo 'ff';
            $eselon = "''" ; 
            $spmu = "''" ; 
            $kolok = "''" ;   
            $kojab = "''" ; 
            $jencuti = "''" ; 
        }

        // exit();

        // echo $jencuti;exit();

     //    $plt = "SELECT KOLOK,KOJAB,STATUS FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$nrk."' and AKTIF = 1 ";
        // $q_plt = $this->db->query($plt)->row();


        $plt = "SELECT kolok,kojab,eselon FROM history_plt_plh WHERE nrk = '".$nrk."' and flag_status = 'active' ";
        $q_plt = $this->ekine16->query($plt)->row();
        // $pyb = $this->get_data_pyb($nrk,$q_plt->KOLOK,$q_plt->KOJAB);

         $status_plt = "";
        if($q_plt!=NULL){
            $status_plt .= $q_plt->STATUS;
            $pyb_plt = $this->get_data_pyb($nrk,$q_plt->kolok,$q_plt->kojab);
            // var_dump($pyb_plt);exit();
        // $pyb_plt = $this->get_data_pyb_plt($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);
            $esl_plt = "" ; 
            $sp_plt = "" ; 
            $klok_plt = "" ;   
            $kjab_plt = "" ; 
            $jncuti_plt = "" ; 
                foreach ($pyb_plt as $data_plt) {
                $esl_plt .= "'".$data_plt->ESELON."'," ; 
                $sp_plt .= "'".$data_plt->SPMU."'," ; 
                $klok_plt .= "'".$data_plt->KOLOK."'," ;   
                $kjab_plt .= "'".$data_plt->KOJAB."'," ; 
                $jncuti_plt .= "'".$data_plt->JENCUTI."'," ;          
            }

            $eselon_plt = substr($esl_plt, 0, -1);
            $spmu_plt = substr($sp_plt, 0, -1);
            $kolok_plt = substr($klok_plt, 0, -1);
            $kojab_plt = substr($kjab_plt, 0, -1);
            $jencuti_plt = substr($jncuti_plt, 0, -1);
        }else{
            $eselon_plt = "''" ; 
            $spmu_plt = "''" ; 
            $kolok_plt = "''" ;   
            $kojab_plt = "''" ; 
            $jencuti_plt = "''" ; 
        }


        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok.")
                AND E.KOJAB IN (".$kojab.")
                AND E.SPMU IN (".$spmu.")
                AND (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND F.ESELON IN (".$eselon.")
                AND A .JENCUTI IN (".$jencuti.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL

                UNION ALL

                SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '".$status_plt."' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok_plt.")
                AND E.KOJAB IN (".$kojab_plt.")
                AND E.SPMU IN (".$spmu_plt.")
                AND (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND F.ESELON IN (".$eselon_plt.")
                AND A .JENCUTI IN (".$jencuti_plt.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL
                )A";
        // echo $sql;exit();
        // AND (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4 OR A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok.")
                AND E.KOJAB IN (".$kojab.")
                AND E.SPMU IN (".$spmu.")
                AND (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND F.ESELON IN (".$eselon.")
                AND A .JENCUTI IN (".$jencuti.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL

                UNION ALL

                SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU,
                        '".$status_plt."' AS STATUS_PLT
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_DUK_PANGKAT_HISTDUK F ON A .NRK = F .NRK AND F.THBL = '".$thbl."'
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE E.KOLOK IN (".$kolok_plt.")
                AND E.KOJAB IN (".$kojab_plt.")
                AND E.SPMU IN (".$spmu_plt.")
                AND (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND F.ESELON IN (".$eselon_plt.")
                AND A .JENCUTI IN (".$jencuti_plt.")
                AND A.ID_LOKASI = 1
                AND A .ID_HIST is NOT NULL
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_pejabat = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 4)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }else if($user_login != $row->NRK && ($row->STATUS_CUTI == 3)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-warning btn-circle btn-outline' title='Setujui Penangguhan' onClick='verif_setujui_penangguhan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            // $rubah_ajukan_kembali = "";
            // if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
            //     $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

            //     ";
            // }

            $nestedData[] = $detail_cuti.' '.$verifikasi_pejabat
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_pyb_lokasi_luar_negeri($nrk)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        // $kolok_kojab = $this->kolok_kojab($nrk);
        // $pyb = $this->get_data_pyb($kolok_kojab->KOLOK,$kolok_kojab->KOJAB);
        // // var_dump($pyb);exit();

        // $esl = "" ; 
        // $sp = "" ; 
        // $klok = "" ;   
        // $kjab = "" ;  
        // foreach ($pyb as $data) {
        //     $esl .= "'".$data->ESELON."'," ; 
        //     $sp .= "'".$data->SPMU."'," ; 
        //     $klok .= "'".$data->KOLOK."'," ;   
        //     $kjab .= "'".$data->KOJAB."'," ;          
        // }

        // $eselon = substr($esl, 0, -1);
        // $spmu = substr($sp, 0, -1);
        // $kolok = substr($klok, 0, -1);
        // $kojab = substr($kjab, 0, -1);


        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE  (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND A.ID_LOKASI = 2
                AND A .ID_HIST is NOT NULL
                )A";
        // echo $sql;exit();
        // WHERE  (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4 OR A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE  (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4)
                AND A.ID_LOKASI = 2
                AND A .ID_HIST is NOT NULL
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_pejabat = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 4)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }else if($user_login != $row->NRK && ($row->STATUS_CUTI == 3)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-warning btn-circle btn-outline' title='Setujui Penangguhan' onClick='verif_setujui_penangguhan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            // $rubah_ajukan_kembali = "";
            // if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
            //     $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

            //     ";
            // }

            $nestedData[] = $detail_cuti.' '.$verifikasi_pejabat
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_pyb_lokasi_luar_negeri_2($nrk)
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $count_bawahan; exit();

        $user_login = $nrk;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE  (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND A.ID_LOKASI = 2
                AND A .ID_HIST is NOT NULL
                )A";
        // echo $sql;exit();
        // WHERE  (A.STATUS_CUTI = 3 OR A.STATUS_CUTI = 4 OR A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        E. KOLOK,
                        E. KOJAB,
                        E. SPMU
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE  (A.STATUS_CUTI = 5 OR A.STATUS_CUTI = 7 OR A.STATUS_CUTI = 8 OR A.STATUS_CUTI = 10 OR A.STATUS_CUTI = 11)
                AND A.ID_LOKASI = 2
                AND A .ID_HIST is NOT NULL
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_pejabat = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 4)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }else if($user_login != $row->NRK && ($row->STATUS_CUTI == 3)){
                $verifikasi_pejabat = "

                    <button type='button' class='btn btn-warning btn-circle btn-outline' title='Setujui Penangguhan' onClick='verif_setujui_penangguhan_pyb(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            // $rubah_ajukan_kembali = "";
            // if($user_login == $row->NRK && ($row->STATUS_CUTI == 2)){
            //     $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-outline' title='Ubah dan ajukan kembali' onClick='rubah_ajukan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-align-justify'></i></button>

            //     ";
            // }

            $nestedData[] = $detail_cuti.' '.$verifikasi_pejabat
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }


    public function getJenisCuti(){
        $sql = "SELECT JENCUTI, KETERANGAN FROM PERS_JENCUTI_RPT WHERE JENCUTI IN ('1','2','3') ORDER BY JENCUTI ASC";

        $query = $this->ci->db->query($sql);        

        $option  = "";
        
        foreach($query->result() as $row){

        	// echo 'jen '.$row->JENCUTI;
           
            $option .= "<option value='".$row->JENCUTI."'>".$row->KETERANGAN."</option>";
            
        }
        
        // echo $option;exit();

        return $option;
    }

    public function lokasi_cuti($id_lokasi=""){
        $sql = "SELECT ID_LOKASI, KET FROM PERS_CUTI_LOKASI ORDER BY ID_LOKASI ASC";

        $query = $this->ci->db->query($sql);        

        $option  = "";
        
        foreach($query->result() as $row){

            // echo 'jen '.$row->ID_LOKASI;
            if($id_lokasi == $row->ID_LOKASI)
            {
                $option .= "<option selected value='".$row->ID_LOKASI."'>".$row->KET."</option>";
            }
            else
            {
                $option .= "<option value='".$row->ID_LOKASI."'>".$row->KET."</option>";
            }
           
            
            
        }
        
        // echo $option;exit();

        return $option;
    }

    public function cek_masker($nrk){
        $sql = "SELECT MONTHS_BETWEEN(TO_DATE(to_char(SYSDATE,'dd-mm-yyyy'),'dd-mm-yyyy'),TO_DATE(to_char(MUANG,'dd-mm-yyyy'),'dd-mm-yyyy')) as MASKER_BLN 
                FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk."' ";
        // $sql = "SELECT MONTHS_BETWEEN (TO_DATE ('2018-12-12','YYYY-MM-DD'), TO_DATE ('2017-12-11','YYYY-MM-DD')) as MASKER_BLN  FROM DUAL ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_masker_dari_tmt($nrk,$tmt){
        $sql = "SELECT MONTHS_BETWEEN(TO_DATE('".$tmt."','dd-mm-yyyy'),TO_DATE(to_char(MUANG,'dd-mm-yyyy'),'dd-mm-yyyy')) as MASKER_BLN 
                FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk."' ";
        // $sql = "SELECT MONTHS_BETWEEN (TO_DATE ('2018-12-12','YYYY-MM-DD'), TO_DATE ('2017-12-11','YYYY-MM-DD')) as MASKER_BLN  FROM DUAL ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }


    public function cek_libur_nas($tmt,$tgakhir){
        $sql = "SELECT count(*) as JML FROM PERS_HARI_LIBUR
                WHERE TGL BETWEEN TO_DATE('".$tmt."', 'dd-mm-yyyy') and TO_DATE('".$tgakhir."', 'dd-mm-yyyy') ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_cuti_n($nrk,$thn){
        $sql = "SELECT NVL(SUM(CUTI_N),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1 OR JENCUTI = 2)
                AND TO_CHAR(TMT,'YYYY') = '".$thn."' 
                AND (STATUS_CUTI <> 3 AND STATUS_CUTI <> 7 AND STATUS_CUTI <> 9 AND STATUS_CUTI <> 10 AND STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_cuti_setuju($nrk,$thn){
        $sql = "SELECT NVL(SUM(CUTI_N),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1 OR JENCUTI = 2)
                AND (TO_CHAR(TMT,'YYYY') = '".$thn."' )
                AND STATUS_CUTI NOT IN (3,7,9,10,11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_cuti_setuju_n_1($nrk,$thn){
        $sql = "SELECT NVL(SUM(CUTI_N_1),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1 OR JENCUTI = 2)
                AND TAHUN_N_1 = '".$thn."' 
                AND STATUS_CUTI NOT IN (3,7,9,10,11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_cuti_setuju_n_2($nrk,$thn){
        $sql = "SELECT NVL(SUM(CUTI_N_2),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1 OR JENCUTI = 2)
                AND TAHUN_N_2 = '".$thn."' 
                AND STATUS_CUTI NOT IN (3,7,9,10,11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_jml_cuti_n_1($nrk,$thn_n_1){
        $sql = "SELECT NVL(SUM(CUTI_N_1),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1)
                AND (TAHUN_N_1 = '".$thn_n_1."') 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_jml_cuti_n_2($nrk,$thn_n_1){
        $sql = "SELECT NVL(SUM(CUTI_N_2),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1)
                AND (TAHUN_N_2 = '".$thn_n_1."') 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_count_cuti_besar($nrk,$thn_n_1){
        $sql = "SELECT COUNT(*) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 2)
                AND TO_CHAR(TMT,'YYYY') = '".$thn_n_1."' 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_count_cuti($nrk,$thn_n_1){
        $sql = "SELECT COUNT(*) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1)
                AND (TO_CHAR(TMT,'YYYY') = '".$thn_n_1."' ) 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function sum_cuti_n_1($nrk,$thn_n_1){
        $sql = "SELECT NVL(SUM(CUTI_N)) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1)
                AND TO_CHAR(TMT,'YYYY') = '".$thn_n_1."' 
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_status_cuti($nrk,$thn_n_1){
        $sql = "SELECT ID_HIST,NRK,TMT,STATUS_CUTI,CUTI_N,TOTAL_CUTI
                FROM
                (SELECT ID_HIST,NRK,TMT,STATUS_CUTI,CUTI_N,TOTAL_CUTI
                FROM PERS_CUTI_HIST
                WHERE NRK = '".$nrk."'
                AND (JENCUTI = 1)
                AND TO_CHAR(TMT,'YYYY') = '".$thn_n_1."' 
                ORDER BY ID_HIST DESC
                )
                WHERE ROWNUM = 1
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function count_rekap($nrk,$thn){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERS_REKAP_CUTI
                WHERE NRK = '".$nrk."'
                AND TAHUN = '".$thn."' 
                
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_rekap_cuti($nrk,$thn){
        $sql = "SELECT NRK,TAHUN,NVL(JML_CUTI,0) AS JML
                FROM PERS_REKAP_CUTI
                WHERE NRK = '".$nrk."'
                AND TAHUN = '".$thn."' 
                
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_rekap($nrk){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERS_REKAP_CUTI
                WHERE NRK = '".$nrk."'
                
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_jarak_tanggal($tmt){
        $sql = "SELECT MONTHS_BETWEEN(TO_DATE('".$tmt."','dd-mm-yyyy'),SYSDATE) as JML FROM DUAL ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function save_ct_tahunan($nrk,$jencuti,$id_lokasi,$alasan_cuti,$tmt,$tgakhir,$tahun_n_1,$tahun_n_2,$cuti_n_2,$cuti_n_1,$cuti_n,$total_cuti,$telp_cuti,$almt_cuti,$nrk_atasan,$status_atasan,$nrk_plt_plh,$kolok_plt_plh,$kojab_plt_plh){

        if($status_atasan == 'ATASAN'){
            $atasan = $this->cari_plt($nrk_atasan);
            $nrk_atasan = $nrk_atasan;
            $kolok_atasan = $atasan->KOLOK;
            $kojab_atasan = $atasan->KOJAB;
        }else{
            $nrk_atasan = $nrk_plt_plh;
            $kolok_atasan = $kolok_plt_plh;
            $kojab_atasan = $kojab_plt_plh;
        }

        $sql_seq_hist = "SELECT PERS_CUTI_HIST_SEQ.nextval AS NEXT_ID FROM DUAL";
        // echo $sql; exit();
        $query_seq_hist = $this->db->query($sql_seq_hist)->row();

        // echo $query_seq_hist->NEXT_ID;exit();
        $id_next_hist = $query_seq_hist->NEXT_ID;
        $status_flow = 1;

        // $sql_ct_hist = "INSERT INTO PERS_CUTI_HIST(ID_HIST,NRK,JENCUTI,ALSN_CUTI,TMT,TGAKHIR,CUTI_N_2,CUTI_N_1,CUTI_N,TAHUN_N_1,TAHUN_N_2,TOTAL_CUTI,TELP_CUTI,ALMT_CUTI,STATUS_CUTI,USER_ID,TG_UPD) 
        //         VALUES (".$id_next_hist.",'".$nrk."',".$jencuti.",'".$alasan_cuti."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),TO_DATE('".$tgakhir."', 'DD-MM-YYYY'),".$cuti_n_2.",".$cuti_n_1.",".$cuti_n.",'".$tahun_n_1."','".$tahun_n_2."',".$total_cuti.",'".$telp_cuti."','".$almt_cuti."',".$status_flow.",'".$nrk."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'))"; 

        $sql_ct_hist = "INSERT INTO PERS_CUTI_HIST(ID_HIST,NRK,JENCUTI,ID_LOKASI,ALSN_CUTI,TMT,TGAKHIR,CUTI_N_2,CUTI_N_1,CUTI_N,TAHUN_N_1,TAHUN_N_2,TOTAL_CUTI,TELP_CUTI,ALMT_CUTI,STATUS_CUTI,USER_ID,TG_UPD,NRK_ATASAN,KOLOK_ATASAN,KOJAB_ATASAN,STATUS_ATASAN) 
                VALUES (".$id_next_hist.",'".$nrk."',".$jencuti.",".$id_lokasi.",'".$alasan_cuti."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),TO_DATE('".$tgakhir."', 'DD-MM-YYYY'),".$cuti_n_2.",".$cuti_n_1.",".$cuti_n.",'".$tahun_n_1."','".$tahun_n_2."',".$total_cuti.",'".$telp_cuti."','".$almt_cuti."',".$status_flow.",'".$nrk."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),'".$nrk_atasan."','".$kolok_atasan."','".$kojab_atasan."','".$status_atasan."')"; 

        // echo $sql_ct_hist;exit();
        $this->db->query($sql_ct_hist);

        $ket_detail = 'Pengajuan oleh pegawai';
        $upd_detail = $nrk;

        $insert_hist_detail = $this->insert_hist_detail($id_next_hist,$status_flow,$ket_detail,$upd_detail);

        return true;
    }

    public function insert_hist_detail($id_next_hist,$status_flow,$ket_detail,$upd_detail,$status_pyb='',$kolok_atasan='',$kojab_atasan='',$status_atasan=''){
        $sql_cek_pgw = "SELECT COUNT(*) as JML FROM PERS_PEGAWAI1 WHERE NRK = '".$upd_detail."' ";
        // echo $sql; exit();
        $cek_pgw = $this->db->query($sql_cek_pgw)->row();

        if($upd_detail == '000000'){
            $user_kojab = '';
            $user_kolok = '';
            $user_kd_jab = '';
        }else{

            if($cek_pgw->JML >= 1){
            	if($status_pyb !=''){ #jika yg validasi adalah plt/plh maka ambil kolok kojab pada tabel plt/plh
        //     		$plt = "SELECT KOLOK,KOJAB,STATUS FROM PERS_JABATAN_PLT_HIST WHERE NRK = '".$upd_detail."' and AKTIF = 1 ";
    				// $q_plt = $this->db->query($plt)->row();

                    $plt = "SELECT kolok,kojab,eselon FROM history_plt_plh WHERE nrk = '".$nrk."' and flag_status = 'active' ";
                    $q_plt = $this->ekine16->query($plt)->row();

    				$user_kojab = $q_plt->kolok;
	                $user_kolok = $q_plt->kojab;
	                $user_kd_jab = '';
            	}else{
                    // echo $status_atasan;exit();
                    if($status_atasan =='PLT' || $status_atasan =='PLH'){
                        $user_kojab = $kojab_atasan;
                        $user_kolok = $kolok_atasan;
                        $user_kd_jab = '';
                        $status_pyb = $status_atasan;
                    }else{
                        $sql_klk_kjb = "SELECT NRK,KOLOK,KOJAB,KD FROM PERS_PEGAWAI1 WHERE NRK = '".$upd_detail."' ";
                        // echo $sql; exit();
                        $cek_klk_kjb = $this->db->query($sql_klk_kjb)->row();

                        $user_kojab = $cek_klk_kjb->KOJAB;
                        $user_kolok = $cek_klk_kjb->KOLOK;
                        $user_kd_jab = $cek_klk_kjb->KD;
                    }
            		
            	}
                

            }else{
                $user_kojab = '';
                $user_kolok = '';
                $user_kd_jab = '';
            }

        }

        $sql = "INSERT INTO PERS_DETAIL_CUTI(ID_DETAIL,ID_CUTI_HIST,ID_STATUS_CUTI,KET,TG_UPD,UPD_BY,KOLOK,KOJAB,KD,STATUS_PLT_PLH) 
                VALUES (PERS_DETAIL_CUTI_SEQ.nextval,".$id_next_hist.",".$status_flow.",'".$ket_detail."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),'".$upd_detail."','".$user_kolok."','".$user_kojab."','".$user_kd_jab."','".$status_pyb."')"; 
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return true;
    }



// START DETAIL CUTI

    public function detail_cuti_tahunan($id_hist){
        $sql = "SELECT
                A .ID_HIST,
                A .NRK,
                E.NAMA,
                TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                A .NOSK,
                TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                A .JENCUTI,
                b.KETERANGAN,
                TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                TO_CHAR (
                    A .TG_UPD,
                    'DD-MM-YYYY HH24:MI:SS'
                ) TG_UPD,
                A .USER_ID,
                A .STATUS_CUTI,
                D .TAHAP,
                A.ALMT_CUTI,
                A.TELP_CUTI,
                A.ALSN_CUTI,
                A.CUTI_N,
                A.CUTI_N_1,
                A.CUTI_N_2,
                A.TOTAL_CUTI,
                c.KETERANGAN AS KET_PEJTT,
                F.KET AS KET_LOKASI
            FROM
                PERS_CUTI_HIST A
            LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
            LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D.ID
            LEFT JOIN PERS_PEGAWAI1 E ON A.NRK = E.NRK
            LEFT JOIN PERS_CUTI_LOKASI F ON A.ID_LOKASI = F.ID_LOKASI
            LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
            WHERE A.ID_HIST = ".$id_hist."
                
                ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }


    public function hist_detail_cuti()
    {
        $requestData = $this->input->post(); 
        $id_hist = $requestData['id_hist'];

        // echo $tahun; exit();
        // $key = "rayjrdn012345467879";

        $columns = array( 
        // datatable column index  => database column name
            0 => 'ID_DETAIL',
            1 => 'TAHAP',
            2 => 'KET', 
            3 => 'TGL'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .ID_DETAIL,
                        A .ID_CUTI_HIST,
                        A .ID_STATUS_CUTI,
                        B.TAHAP,
                        A .KET,
                        A .TG_UPD,
                        TO_CHAR (A .TG_UPD, 'DD-MM-YYYY') TGL,
                        A .UPD_BY,
                        A .FILE_CUTI,
                        C.\"user_name\" NAMA_UPD
                    FROM
                        PERS_DETAIL_CUTI A
                    LEFT JOIN PERS_STATUS_CUTI B ON A .ID_STATUS_CUTI = B. ID
                    LEFT JOIN \"master_user\" C ON A .UPD_BY = C.\"user_id\"
                    WHERE
                        A .ID_CUTI_HIST = ".$id_hist."
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .ID_DETAIL,
                        A .ID_CUTI_HIST,
                        A .ID_STATUS_CUTI,
                        B.TAHAP,
                        A .KET,
                        A .TG_UPD,
                        TO_CHAR (A .TG_UPD, 'DD-MM-YYYY') TGL,
                        A .UPD_BY,
                        A .FILE_CUTI,
                        C.\"user_name\" NAMA_UPD
                    FROM
                        PERS_DETAIL_CUTI A
                    LEFT JOIN PERS_STATUS_CUTI B ON A .ID_STATUS_CUTI = B. ID
                    LEFT JOIN \"master_user\" C ON A .UPD_BY = C.\"user_id\"
                    WHERE
                        A .ID_CUTI_HIST = ".$id_hist."
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TGL) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->TAHAP;

            // $ket = $row->KET;
            $file_cuti = '';
            if($row->FILE_CUTI != '' || $row->FILE_CUTI != NULL){
                $file_cuti .= '<br/>Nodin : <a target = "_blank" href="javascript:void(0)" onclick="d_rs(\''.base64_encode($row->FILE_CUTI).'\')" >Download</a>';
                // $link = $this->encrypt->encode($row->FILE_CUTI);
                // $deski = $this->encrypt->decode($link);
                // $file_cuti .= '<br/>Nodin : <a target = "_blank" href="javascript:void(0)" onclick="d_rs(\''.$this->encrypt->encode($row->FILE_CUTI).'\')" >Download</a>';
            }

            

            $nestedData[] = $row->KET.''.$file_cuti;
            $nestedData[] = "Tanggal : <b>".$row->TGL."</b>, oleh : <b>".$row->NAMA_UPD."</b>";
            
            
            
                        
                            
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

// END DETAIL CUTI


    public function update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,$status_pyb='',$kolok_atasan='',$kojab_atasan='',$status_atasan=''){
    	$sql = "UPDATE PERS_CUTI_HIST SET STATUS_CUTI = ".$id_status_baru.", TG_UPD = TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY') WHERE ID_HIST = ".$id_hist." "; 

        // echo $sql_ct_hist;exit();
        $this->db->query($sql);

        $ket_detail = $ket;
        $upd_detail = $user;

        $insert_hist_detail = $this->insert_hist_detail($id_hist,$id_status_baru,$ket,$user,$status_pyb,$kolok_atasan,$kojab_atasan,$status_atasan);

        return true;
    }

    // public function update_cuti_tahunan_atasan($id_hist,$jencuti,$ket,$id_status_baru,$user,$kolok_atasan='',$kojab_atasan=''){
    //     $sql = "UPDATE PERS_CUTI_HIST SET STATUS_CUTI = ".$id_status_baru.", TG_UPD = TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY') WHERE ID_HIST = ".$id_hist." "; 

    //     // echo $sql_ct_hist;exit();
    //     $this->db->query($sql);

    //     $ket_detail = $ket;
    //     $upd_detail = $user;

    //     $insert_hist_detail = $this->insert_hist_detail_atasan($id_hist,$id_status_baru,$ket,$user,$kolok_atasan='',$kojab_atasan='');

    //     return true;
    // }


    // start ubah cuti tahunan

    public function cek_cuti_n_ubah($id_hist,$nrk,$thn){
        $sql = "SELECT NVL(SUM(CUTI_N),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND (ID_HIST <> ".$id_hist." or ID_HIST IS NULL ) 
                AND (JENCUTI = 1 OR JENCUTI = 2)
                AND TO_CHAR(TMT,'YYYY') = '".$thn."' 
                AND (STATUS_CUTI <> 3 AND STATUS_CUTI <> 7 AND STATUS_CUTI <> 9 AND STATUS_CUTI <> 10 AND STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_jml_cuti_n_1_ubah($id_hist,$nrk,$thn_n_1){
        $sql = "SELECT NVL(SUM(CUTI_N_1),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND ID_HIST <> ".$id_hist." 
                AND (JENCUTI = 1)
                AND (TAHUN_N_1 = '".$thn_n_1."') 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_jml_cuti_n_2_ubah($id_hist,$nrk,$thn_n_1){
        $sql = "SELECT NVL(SUM(CUTI_N_2),0) AS JML FROM PERS_CUTI_HIST 
                WHERE NRK = '".$nrk."'
                AND ID_HIST <> ".$id_hist." 
                AND (JENCUTI = 1)
                AND (TAHUN_N_2 = '".$thn_n_1."') 
                AND (STATUS_CUTI <> 3 OR STATUS_CUTI <> 7 OR STATUS_CUTI <> 9 OR STATUS_CUTI <> 10 OR STATUS_CUTI <> 11) ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function save_ct_tahunan_ubah($id_hist,$nrk,$jencuti,$id_lokasi,$alasan_cuti,$tmt,$tgakhir,$tahun_n_1,$tahun_n_2,$cuti_n_2,$cuti_n_1,$cuti_n,$total_cuti,$telp_cuti,$almt_cuti,$ket){
        
        $status_flow = 6;

        $sql_ct_hist = "UPDATE PERS_CUTI_HIST SET ID_LOKASI = ".$id_lokasi.",ALSN_CUTI = '".$alasan_cuti."', TMT = TO_DATE('".$tmt."', 'DD-MM-YYYY'), TGAKHIR = TO_DATE('".$tgakhir."', 'DD-MM-YYYY'),CUTI_N_2 = ".$cuti_n_2.",CUTI_N_1 = ".$cuti_n_1.",CUTI_N = ".$cuti_n.",TAHUN_N_1 = '".$tahun_n_1."',TAHUN_N_2 = '".$tahun_n_2."',TOTAL_CUTI = ".$total_cuti.",TELP_CUTI = '".$telp_cuti."',ALMT_CUTI = '".$almt_cuti."',STATUS_CUTI = ".$status_flow.",USER_ID = '".$nrk."',TG_UPD = TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY')
            WHERE ID_HIST = ".$id_hist."

        ";
        // echo $sql_ct_hist;exit();
        $this->db->query($sql_ct_hist);

        // $ket_detail = 'Revisi oleh pegawai';
        $ket_detail = $ket;
        $upd_detail = $nrk;

        $insert_hist_detail = $this->insert_hist_detail($id_hist,$status_flow,$ket_detail,$upd_detail);

        return true;
    }
    // end ubah cuti tahunan

    // print cuti

    public function data_cuti($id_hist){

        // SELECT a.NRK,a.TMT,a.TGAKHIR,a.NOSK,a.TGSK,a.PEJTT,a.TAHUN_N_2,a.TAHUN_N_1,a.CUTI_N_2,a.CUTI_N_1,a.CUTI_N,
        // a.ALSN_CUTI,a.ALMT_CUTI,a.TELP_CUTI,a.STATUS_CUTI,a.TOTAL_CUTI,
        // b.*
        // from PERS_CUTI_HIST a 
        // LEFT JOIN
        // (
        // SELECT ID_CUTI_HIST,ID_STATUS_CUTI,KET,UPD_BY,KOJAB,KOLOK
        // FROM PERS_DETAIL_CUTI
        // WHERE ID_STATUS_CUTI = 1
        // )b on a.ID_HIST = b.ID_CUTI_HIST
        // WHERE a.ID_HIST = 35

        // $sql = "SELECT NRK,TMT,TGAKHIR,NOSK,TGSK,PEJTT,TAHUN_N_2,TAHUN_N_1,CUTI_N_2,CUTI_N_1,CUTI_N,
        //         ALSN_CUTI,ALMT_CUTI,TELP_CUTI,STATUS_CUTI,TOTAL_CUTI
        //         from PERS_CUTI_HIST WHERE ID_HIST = ".$id_hist." ";

        $sql = "SELECT a.NRK,a.TMT,a.TGAKHIR,a.NOSK,a.TGSK,a.PEJTT,a.TAHUN_N_2,a.TAHUN_N_1,a.CUTI_N_2,a.CUTI_N_1,a.CUTI_N,
                a.ALSN_CUTI,a.ALMT_CUTI,a.TELP_CUTI,a.STATUS_CUTI,a.TOTAL_CUTI,
                b.ID_CUTI_HIST,b.ID_STATUS_CUTI,b.KET,b.UPD_BY,b.KOJAB,b.KOLOK,b.KD,
                c.SPMU,d.NAMA as NAMA_SPMU,
                e.NIP18,e.NAMA as NAMA_PGW,e.MUANG,e.TMT_STAPEG
                from PERS_CUTI_HIST a 
                LEFT JOIN
                (
                SELECT ID_CUTI_HIST,ID_STATUS_CUTI,KET,UPD_BY,KOJAB,KOLOK,KD
                FROM PERS_DETAIL_CUTI
                WHERE ID_STATUS_CUTI = 1
                )b on a.ID_HIST = b.ID_CUTI_HIST
                LEFT JOIN PERS_KLOGAD3 c ON b.KOLOK = c.KOLOK
                LEFT JOIN PERS_TABEL_SPMU d on c.SPMU = d.KODE_SPM
                LEFT JOIN 
                (
                    SELECT nrk,NIP18,NAMA,MUANG,TMT_STAPEG
                    from PERS_PEGAWAI1
                )e on a.NRK = e.NRK
                WHERE a.ID_HIST = ".$id_hist." ";

        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function jab_pgw_cuti($kolok,$kojab,$kd){
        if($kd = 'S'){
            $sql = "SELECT KOJAB,NAJABL
                    FROM PERS_KOJAB_TBL
                    WHERE KOJAB = '".$kojab."'
                    AND KOLOK = '".$kolok."' ";
        }else{
            $sql = "SELECT KOJAB,NAJABL
                    FROM PERS_KOJABF_TBL 
                    WHERE KOJAB = '".$kojab."' ";
        }
        // echo $kd.' - '.$sql; exit();
        return $this->db->query($sql)->row();
    }

    public function stj_atasan($id_hist){
        $sql = "SELECT COUNT(*) as JML
                from PERS_DETAIL_CUTI WHERE ID_CUTI_HIST = ".$id_hist." AND ID_STATUS_CUTI = 4 "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function tangguh_atasan($id_hist){
        $sql = "SELECT COUNT(*) as JML
                from PERS_DETAIL_CUTI WHERE ID_CUTI_HIST = ".$id_hist." AND ID_STATUS_CUTI = 3 "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function stj_pejabat($id_hist){
        $sql = "SELECT COUNT(*) as JML
                from PERS_DETAIL_CUTI WHERE ID_CUTI_HIST = ".$id_hist." AND (ID_STATUS_CUTI = 5 or ID_STATUS_CUTI = 10) "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function tangguh_pejabat($id_hist){
        $sql = "SELECT COUNT(*) as JML
                from PERS_DETAIL_CUTI WHERE ID_CUTI_HIST = ".$id_hist." AND ID_STATUS_CUTI = 7 "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function dt_atasan($id_hist){
        $sql = "SELECT a.NRK_ATS,a.KOJAB_ATS,a.KOLOK_ATS,a.KD_ATS,b.NAMA,b.NIP18
                FROM 
                (
                select ID_CUTI_HIST,ID_STATUS_CUTI,KET,TG_UPD,UPD_BY as NRK_ATS,KOJAB as KOJAB_ATS,KOLOK as KOLOK_ATS,KD as KD_ATS
                FROM PERS_DETAIL_CUTI
                WHERE ID_CUTI_HIST = ".$id_hist." 
                AND (ID_STATUS_CUTI = 4 or ID_STATUS_CUTI = 3)
                ORDER BY TG_UPD DESC
                )a
                LEFT JOIN PERS_PEGAWAI1 b on a.NRK_ATS = b.NRK
                WHERE ROWNUM = 1"; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function dt_pejabat($id_hist){
        $sql = "SELECT a.NRK_PJB,a.KOJAB_PJB,a.KOLOK_PJB,a.KD_PJB,b.NAMA,b.NIP18,TO_CHAR(a.TG_UPD, 'YYYYMM') as THBL
                FROM 
                (
                select ID_CUTI_HIST,ID_STATUS_CUTI,KET,TG_UPD,UPD_BY as NRK_PJB,KOJAB as KOJAB_PJB,KOLOK as KOLOK_PJB,KD as KD_PJB
                FROM PERS_DETAIL_CUTI
                WHERE ID_CUTI_HIST = ".$id_hist."  
                AND (ID_STATUS_CUTI = 5 or ID_STATUS_CUTI = 7 or ID_STATUS_CUTI = 10)
                ORDER BY TG_UPD DESC
                )a
                LEFT JOIN PERS_PEGAWAI1 b on a.NRK_PJB = b.NRK
                WHERE ROWNUM = 1
                "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function lokasi_tbl($kolok){
        $sql = "SELECT KOLOK,NALOKL FROM PERS_LOKASI_TBL WHERE KOLOK = '".$kolok."'
                "; 
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }


    public function get_cuti_exist($id_hist){
        $sql = "SELECT ID_HIST,NRK,NRK_ATASAN,KOLOK_ATASAN,KOJAB_ATASAN,STATUS_ATASAN
                from PERS_CUTI_HIST WHERE ID_HIST = '".$id_hist."'  ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }



    public function pgw_cuti($nrk){
        $sql = "SELECT NRK,NIP18,NAMA,MUANG,TMT_STAPEG,SPMU,KOLOK,KOJAB
                from PERS_PEGAWAI1 WHERE NRK = '".$nrk."'  ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    

   // ========================================= akses bkd kesra ==============================================
    public function get_data_cuti_pimpinan($nrk)
    {
        // echo 'atasan';exit();
        $requestData = $this->input->post(); 
        $user_login = $nrk;
        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE (A.NRK_ATASAN = '000000' OR (KOLOK_ATASAN = '000001102' AND KOJAB_ATASAN = '000000'))
                AND A .STATUS_CUTI IN (1,6)
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE (A.NRK_ATASAN = '000000' OR (KOLOK_ATASAN = '000001102' AND KOJAB_ATASAN = '000000'))
                AND A .STATUS_CUTI IN (1,6)
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();    

        // echo $user_login.' - '.$cek_gub_sekda->KOLOK.' - '.$cek_gub_sekda->KOJAB;exit();

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";

            
            
                if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                    $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                        <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                        <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                    ";
                }
            

            // echo $pesan;exit();
            
                
            

            

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }

    public function get_data_cuti_pimpinan_sudah_validasi($nrk)
    {
        $requestData = $this->input->post(); 
        $user_login = $nrk;
        $columns = array( 
        // datatable column index  => database column name
            0 => 'TMT',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'KETERANGAN', 
            4 => 'TMT',
            5 => 'TGAKHIR',
            6 => 'TAHAP',
            7 => 'TAHAP'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE (A.NRK_ATASAN = '000000' OR (KOLOK_ATASAN = '000001102' AND KOJAB_ATASAN = '000000'))
                AND A .STATUS_CUTI NOT IN (1,6)
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT
                        ROWNUM AS RN,
                        A .NRK,
                        E .NAMA,
                        TO_CHAR (A .TMT, 'DD-MM-YYYY') TMT,
                        A .NOSK,
                        TO_CHAR (A .TGSK, 'DD-MM-YYYY') TGSK,
                        A .JENCUTI,
                        b.KETERANGAN,
                        TO_CHAR (A .TGAKHIR, 'DD-MM-YYYY') TGAKHIR,
                        TO_CHAR (
                            A .TG_UPD,
                            'DD-MM-YYYY HH24:MI:SS'
                        ) TG_UPD,
                        A .USER_ID,
                        A .ID_HIST,
                        A .STATUS_CUTI,
                        D .TAHAP,
                        c.KETERANGAN AS KET_PEJTT,
                        A.NRK_ATASAN
                    FROM
                        PERS_CUTI_HIST A
                    LEFT JOIN PERS_JENCUTI_RPT b ON A .JENCUTI = b.JENCUTI
                    LEFT JOIN PERS_STATUS_CUTI D ON A .STATUS_CUTI = D . ID
                    LEFT JOIN PERS_PEGAWAI1 E ON A .NRK = E .NRK
                    LEFT JOIN PERS_PEJTT_RPT c ON A .PEJTT = c.PEJTT
                WHERE (A.NRK_ATASAN = '000000' OR (KOLOK_ATASAN = '000001102' AND KOJAB_ATASAN = '000000'))
                AND A .STATUS_CUTI NOT IN (1,6)
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TMT) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(TAHAP) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        // $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        $sql.=" ORDER BY to_date(\"".$columns[$requestData['order'][0]['column']]."\",'DD-MM-YYYY') DESC ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KETERANGAN;
            $nestedData[] = $row->TMT;
            $nestedData[] = $row->TGAKHIR;
            if($row->STATUS_CUTI == 2){
                $nestedData[] = "<span class='label label-warning'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 3 || $row->STATUS_CUTI == 7 || $row->STATUS_CUTI == 9 || $row->STATUS_CUTI == 10 || $row->STATUS_CUTI == 11){
                $nestedData[] = "<span class='label label-danger'><strong>".$row->TAHAP."</strong></span>";
            }else if($row->STATUS_CUTI == 5 || $row->STATUS_CUTI == 4 || $row->STATUS_CUTI == 8){
                $nestedData[] = "<span class='label label-success'><strong>".$row->TAHAP."</strong></span>";
            }else{
                $nestedData[] = "<span class='label label-primary'><strong>".$row->TAHAP."</strong></span>";
            }
            
            
            $detail_cuti = '';
            if(isset($row->ID_HIST)){
                $detail_cuti = "<button type='button' class='btn btn-sm btn-info btn-outline' title='Detail Cuti ' onClick='detail_cuti(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'>Detail</button>";
            }

            // echo $user_login.' - '.$row->NRK.'<br>';

            $verifikasi_atasan = "";
            if($user_login != $row->NRK && ($row->STATUS_CUTI == 1 || $row->STATUS_CUTI == 6)){
                $verifikasi_atasan = "<button type='button' class='btn btn-warning btn-circle btn-outline' title='Perubahan kembali' onClick='verif_perubahan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-mail-reply'></i></button>

                    <button type='button' class='btn btn-danger btn-circle btn-outline' title='Ditangguhkan' onClick='verif_ditangguhkan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-times'></i></button>

                    <button type='button' class='btn btn-primary btn-circle btn-outline' title='Disetujui' onClick='verif_setujui_atasan(\"".$row->ID_HIST."\",\"".$row->JENCUTI."\");'><i class='fa fa-check'></i></button>

                ";
            }

            

            $nestedData[] = $detail_cuti.' '.$verifikasi_atasan
                         
                            ;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }


    public function update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru,$user,$nrk_atasan='',$kolok_atasan='',$kojab_atasan='',$status_atasan='',$location_file=''){
        $sql = "UPDATE PERS_CUTI_HIST SET STATUS_CUTI = ".$id_status_baru.", TG_UPD = TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY') WHERE ID_HIST = ".$id_hist." "; 

        // echo $sql_ct_hist;exit();
        $this->db->query($sql);

        $ket_detail = $ket;
        $upd_detail = $user;

        $insert_hist_detail = $this->insert_hist_detail_pimpinan($id_hist,$id_status_baru,$ket,$user,$nrk_atasan,$kolok_atasan,$kojab_atasan,$status_atasan,$location_file);

        return true;
    }

    public function insert_hist_detail_pimpinan($id_next_hist,$status_flow,$ket_detail,$upd_detail,$nrk_atasan='',$kolok_atasan='',$kojab_atasan='',$status_atasan='',$location_file=''){
        $sql_cek_pgw = "SELECT COUNT(*) as JML FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk_atasan."' ";
        // echo $sql; exit();
        $cek_pgw = $this->db->query($sql_cek_pgw)->row();

        

            if($cek_pgw->JML >= 1){
                    
                    $sql_klk_kjb = "SELECT NRK,KOLOK,KOJAB,KD FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk_atasan."' ";
                    // echo $sql; exit();
                    $cek_klk_kjb = $this->db->query($sql_klk_kjb)->row();

                    $user_kojab = $kojab_atasan;
                    $user_kolok = $kolok_atasan;
                    $user_kd_jab = $cek_klk_kjb->KD;

                    $status_pyb = '';
                    if($status_atasan =='PLT' || $status_atasan =='PLH'){
                        $status_pyb = $status_atasan;
                    }
                

            }else{
                $user_kojab = '';
                $user_kolok = '';
                $user_kd_jab = '';
                $status_pyb = '';
            }

        

        $sql = "INSERT INTO PERS_DETAIL_CUTI(ID_DETAIL,ID_CUTI_HIST,ID_STATUS_CUTI,KET,TG_UPD,UPD_BY,KOLOK,KOJAB,KD,STATUS_PLT_PLH,USER_BKD,FILE_CUTI) 
                VALUES (PERS_DETAIL_CUTI_SEQ.nextval,".$id_next_hist.",".$status_flow.",'".$ket_detail."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),'".$nrk_atasan."','".$user_kolok."','".$user_kojab."','".$user_kd_jab."','".$status_pyb."','".$upd_detail."','".$location_file."')"; 
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return true;
    }

    // ================================================================= akses bkd kesra ===========================================================
    
}

?>
