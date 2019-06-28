<?php 

 class Model_setting_struktur extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    private $ci;
    private $ekin;

    function __construct()
    {        
        parent::__construct();

         $this->ci =& get_instance();
        $this->ci->load->database(); 

        $this->ekine = $this->ci->load->database('ekinerja', TRUE);
        $this->ekine16 = $this->ci->load->database('ekinerja16', TRUE);
        // $this->prod = $this->ci->load->database('ORP1', TRUE);
        
    } 

    public function get_spmu($username){

        $sql = "SELECT * FROM PERS_TABEL_SPMU WHERE KODE_UNIT_SIPKD ='".$username."'";
        // echo $getspmu;exit();
        return $this->db->query($sql)->row();

    }

    public function get_unit($username){

        // $sql = "select kode_skpd as kolok,NAMA_SKPD from master_skpd where unit_id = '".$username."' and status_aktif = 't' ";

        $sql = "SELECT
                    kode_skpd as kolok,
                    NAMA_SKPD,
                    unit_id,
                    jumlevel,
                    level1,
                    level2,
                    level3,
                    level4,
                    variasi,
                    kode_spm
                FROM
                    master_skpd
                LEFT JOIN pers_tabel_spmu ON master_skpd.kode_skpd = pers_tabel_spmu.klogad_induk
                WHERE
                    unit_id = '".$username."' and status_aktif = 't' ";
        // echo $sql;exit();
        return $this->db->query($sql)->row();

    }

    public function get_pimpinan($kolok){
        $sql_cek = "SELECT count(*) as JML from pers_pegawai1 where kolok = '".$kolok."' and kojab = '000000' ";
        // echo $sql_cek;exit();
        $q_cek = $this->db->query($sql_cek)->row();

        if($q_cek->JML <= 0){
            $sql = "SELECT (PLT.NRK||'-'||PLT.STATUS) as NRK,P1.NAMA,(PLT.NIP18||'-'||PLT.STATUS) as NIP18,PLT.KOLOK,PLT.KOJAB,PLT.SPMU,PLT.STATUS
                    from PERS_JABATAN_PLT_HIST PLT
                    LEFT JOIN PERS_PEGAWAI1 P1 ON PLT.NRK = P1.NRK
                    WHERE PLT.KOLOK = '".$kolok."'
                    AND PLT.AKTIF = 1";
        }else{
            $sql = "SELECT NRK,NAMA,NIP18,KOLOK,KOJAB,SPMU,'KEPALA' as STATUS
                    from PERS_PEGAWAI1
                    WHERE KOLOK = '".$kolok."'
                    AND KOJAB = '000000'";
        }
        // echo $sql;exit();
        return $this->db->query($sql)->row();
    }

    public function get_kabid($nip_kadis,$spmu_kadis){
        // if($spmu_kadis == 'C030' || $spmu_kadis == 'C031'){
        //     $where = "AND (p.spmu = 'C030' OR p.spmu = 'C031')";
        // }elseif($spmu_kadis == 'C040' || $spmu_kadis == 'C041'){
        //     $where = "AND (p.spmu = 'C040' OR p.spmu = 'C041')";
        // }else{
        //     $where = "AND (k.spmu_atasan = p.spmu)";
        // }

        $sql = "SELECT
                    P .*,JBT.NAJABL as JABATAN, K .tabel
                FROM
                    DN_KEPALA_BAWAHAN K
                    left join PERS_PEGAWAI1 P on K .nip_bawahan = P .nip18
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on P.NRK = JBT.NRK
                WHERE
                    P .nip18 = K .nip_bawahan
                AND K .nip_atasan = '".$nip_kadis."'
                AND (
                    K .tabel = 'kepala_kadis'
                    OR K .tabel = 'kepala_staff'
                )

                ";
        return $this->db->query($sql)->result();
    }

    public function get_bawahan($nip_kasi,$spmu_kasi){
        // if($spmu_kadis == 'C030' || $spmu_kadis == 'C031'){
        //     $where = "AND (p.spmu = 'C030' OR p.spmu = 'C031')";
        // }elseif($spmu_kadis == 'C040' || $spmu_kadis == 'C041'){
        //     $where = "AND (p.spmu = 'C040' OR p.spmu = 'C041')";
        // }else{
        //     $where = "AND (k.spmu_atasan = p.spmu)";
        // }

        $sql = "SELECT
                    P .*,JBT.NAJABL as JABATAN, K .tabel
                FROM
                    DN_KEPALA_BAWAHAN K
                    left join PERS_PEGAWAI1 P on K .nip_bawahan = P .nip18
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on P.NRK = JBT.NRK
                WHERE
                    P .nip18 = K .nip_bawahan
                AND K .nip_atasan = '".$nip_kasi."'
                AND (
                    K .tabel = 'kepala_kadis'
                    OR K .tabel = 'kepala_staff'
                )

                ";
        return $this->db->query($sql)->result();
    }

    // public function cek_pyb($kolok,$kojab){
    //     $sql = "SELECT COUNT(*) AS JML FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
    //     // echo $sql; exit();
    //     return $this->db->query($sql)->row();
    // }

    // public function get_data_pyb($kolok,$kojab){
    //     $sql = "SELECT ESELON,SPMU,KOLOK,KOJAB FROM PERS_KOJAB_PYB_CUTI WHERE KOLOK_PYB = '".$kolok."' AND KOJAB_PYB = '".$kojab."' ";
    //     // echo $sql; exit();
    //     return $this->db->query($sql)->result();
    // }



    public function table_wakil()
    {
        $requestData = $this->input->post(); 
        $spmu_pimpinan = $requestData['spmu_pimpinan'];
        $kolok1 = $requestData['kolok1'];
        $nip_kadis = $requestData['nip_kadis'];
        $kolok_kadis = $requestData['kolok_kadis'];
        $kojab_kadis = $requestData['kojab_kadis'];
        $nrk_kadis = $requestData['nrk_kadis'];

        if($spmu_pimpinan == 'C030' || $spmu_pimpinan == 'C031'){
            $where = "AND (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_pimpinan == 'C040' || $spmu_pimpinan == 'C041'){
            $where = "AND (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "AND pg.spmu = '".$spmu_pimpinan."' ";
        }

        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    WHERE pg.KOLOK = '".$kolok1."'
                    AND (
                    JBT.ESELON LIKE '%3%'
                    OR JBT.ESELON LIKE '%4%'
                    OR JBT.ESELON LIKE '%2%'
                    )
                    ".$where." 
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN)                                     
                    and PG.KOJAB <> '000000'
                )A";
        
        // echo $sql;exit();
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    WHERE pg.KOLOK = '".$kolok1."'
                    AND (
                    JBT.ESELON LIKE '%3%'
                    OR JBT.ESELON LIKE '%4%'
                    OR JBT.ESELON LIKE '%2%'
                    )
                    ".$where." 
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN)  
                    and PG.KOJAB <> '000000'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil(\''.$nip_kadis.'\',\''.$kolok_kadis.'\',\''.$kojab_kadis.'\',\''.$nrk_kadis.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_pimpinan.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
            
            // // $nestedData[] = $row->TABELID;
            // if($row->TABELID == 1){
            //     $nestedData[] = "<div align='center'>Gaji</div> ";
            // }else if($row->TABELID == 2){
            //     $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>TKD Guru</div> ";
            // }

            // // $nestedData[] = $row->BULANPLAIN;
            // if($row->BULANPLAIN == 13){
            //     $nestedData[] = "<div align='center'>Gaji 13</div> ";
            // }else if($row->BULANPLAIN == 14){
            //     $nestedData[] = "<div align='center'>Gaji 14</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>Gaji 15</div> ";
            // }
            
           
            
            
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

    public function pilih_wakil($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_wakil,$kolok_wakil,$kojab_wakil,$nrk_wakil,$spmu_wakil){


        $sql = "INSERT INTO \"kadis_wakil_new\" (\"nip_kadis\", \"nip_wakil\", \"kolok_kadis\", \"kojab_kadis\", \"nrk_kadis\", \"kolok_wakil\", \"kojab_wakil\", \"nrk_wakil\",\"tgl_update\", \"userid_update\", \"spmu_kadis\", \"spmu_wakil\")                

        VALUES ('".$nip_kadis."','".$nip18_wakil."','".$kolok_kadis."','".$kojab_kadis."','".$nrk_kadis."',
                '".$kolok_wakil."','".$kojab_wakil."','".$nrk_wakil."',SYSDATE,'".$user_id."'
                ,'".$spmu_kadis."','".$spmu_wakil."')"; 

        // echo $sql;exit();
        $this->db->query($sql);

        return true;


    }

    public function tabel_kabag()
    {
        $requestData = $this->input->post(); 
        $spmu_pimpinan = $requestData['spmu_pimpinan'];
        $kolok1 = $requestData['kolok1'];
        $nip_kadis = $requestData['nip_kadis'];
        $kolok_kadis = $requestData['kolok_kadis'];
        $kojab_kadis = $requestData['kojab_kadis'];
        $nrk_kadis = $requestData['nrk_kadis'];

        if($spmu_pimpinan == 'C030' || $spmu_pimpinan == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_pimpinan == 'C040' || $spmu_pimpinan == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_pimpinan."' ";
        }

        // echo $where;exit();
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%3%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%3%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_kabid(\''.$nip_kadis.'\',\''.$kolok_kadis.'\',\''.$kojab_kadis.'\',\''.$nrk_kadis.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_pimpinan.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
            
            // // $nestedData[] = $row->TABELID;
            // if($row->TABELID == 1){
            //     $nestedData[] = "<div align='center'>Gaji</div> ";
            // }else if($row->TABELID == 2){
            //     $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>TKD Guru</div> ";
            // }

            // // $nestedData[] = $row->BULANPLAIN;
            // if($row->BULANPLAIN == 13){
            //     $nestedData[] = "<div align='center'>Gaji 13</div> ";
            // }else if($row->BULANPLAIN == 14){
            //     $nestedData[] = "<div align='center'>Gaji 14</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>Gaji 15</div> ";
            // }
            
           
            
            
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

    public function tabel_kabag_ubah()
    {
        $requestData = $this->input->post(); 
        $spmu_pimpinan = $requestData['spmu_pimpinan'];
        $nip_kabag_old = $requestData['nip_kabag_old'];

        if($spmu_pimpinan == 'C030' || $spmu_pimpinan == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_pimpinan == 'C040' || $spmu_pimpinan == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_pimpinan."' ";
        }
        
        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%3%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%3%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_kabid_ubah(\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$row->SPMU.'\',\''.$nip_kabag_old.'\')"><i class="fa fa-check"></i> Pilih </a>';       
            
            
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


    public function pilih_kabid($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala){


        $sql = "INSERT INTO \"kadis_kepala_new\" (\"nip_kadis\", \"nip_kepala\", \"kolok_kadis\", \"kojab_kadis\", \"nrk_kadis\", \"kolok_kepala\", \"kojab_kepala\", \"nrk_kepala\",\"tglupdate\", \"userid_update\", \"spmu_kadis\", \"spmu_kepala\")                

        VALUES ('".$nip_kadis."','".$nip18_kepala."','".$kolok_kadis."','".$kojab_kadis."','".$nrk_kadis."',
                '".$kolok_kepala."','".$kojab_kepala."','".$nrk_kepala."',SYSDATE,'".$user_id."'
                ,'".$spmu_kadis."','".$spmu_kepala."')"; 

        // echo $sql;exit();
        $this->db->query($sql);

        return true;


    }

    public function pilih_kabid_ubah($user_id,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip_kabag_old){

        $sql_insert_history = "INSERT INTO \"kadis_kepala_new_history\" (SELECT * from \"kadis_kepala_new\" WHERE \"nip_kepala\" = '".$nip_kabag_old."' )";
        // echo $sql_insert_history;exit();
        $this->db->query($sql_insert_history);

        #update data kabid
        $sql_update = "UPDATE \"kadis_kepala_new\" 
                            set \"nip_kepala\" = '".$nip18_kepala."', 
                            \"kolok_kepala\" = '".$kolok_kepala."' ,
                            \"kojab_kepala\" = '".$kojab_kepala."',
                            \"nrk_kepala\" = '".$nrk_kepala."',
                            \"spmu_kepala\" = '".$spmu_kepala."',
                            \"userid_update\" = '".$user_id."',
                            \"tglupdate\" = SYSDATE
                            WHERE \"nip_kepala\" = '".$nip_kabag_old."' ";
        $this->db->query($sql_update);

        #update data kabid bawahan kadis_kepala_new
        $sql_cek_bawahan = "SELECT count(*) as JML from \"kadis_kepala_new\" where \"nip_kadis\" = '".$nip_kabag_old."' " ; 
        $q_cek_bawahan = $this->db->query($sql_cek_bawahan)->row();
        if($q_cek_bawahan->JML > 0){

            $sql_insert_bawahan_history = "INSERT INTO \"kadis_kepala_new_history\" (SELECT * from \"kadis_kepala_new\" WHERE \"nip_kadis\" = '".$nip_kabag_old."' )";
            // echo $sql_insert_history;exit();
            $this->db->query($sql_insert_bawahan_history);

            $sql_update_bawahan1 = "UPDATE \"kadis_kepala_new\" 
                                set \"nip_kadis\" = '".$nip18_kepala."', 
                                \"kolok_kadis\" = '".$kolok_kepala."' ,
                                \"kojab_kadis\" = '".$kojab_kepala."',
                                \"nrk_kadis\" = '".$nrk_kepala."',
                                \"spmu_kadis\" = '".$spmu_kepala."',
                                \"userid_update\" = '".$user_id."',
                                \"tglupdate\" = SYSDATE
                                WHERE \"nip_kadis\" = '".$nip_kabag_old."' ";
            $this->db->query($sql_update_bawahan1);
        }

        $sql_cek_bawahan_staff = "SELECT count(*) as JML from \"kepala_staff_new\" where \"nip_kepala\" = '".$nip_kabag_old."' " ; 
        $q_cek_bawahan_staff = $this->db->query($sql_cek_bawahan_staff)->row();
        if($q_cek_bawahan_staff->JML > 0){

            $sql_insert_history_staff = "INSERT INTO \"kepala_staff_new_history\" (SELECT * from \"kepala_staff_new\" WHERE \"nip_kepala\" = '".$nip_kabag_old."' )";
            // echo $sql_insert_history;exit();
            $this->db->query($sql_insert_history_staff);

            $sql_update_bawahan2 = "UPDATE \"kepala_staff_new\" 
                            set \"nip_kepala\" = '".$nip18_kepala."', 
                            \"kolok_kepala\" = '".$kolok_kepala."' ,
                            \"kojab_kepala\" = '".$kojab_kepala."',
                            \"nrk_kepala\" = '".$nrk_kepala."',
                            \"spmu_kepala\" = '".$spmu_kepala."',
                            \"userid_update\" = '".$user_id."',
                            \"tglupdate\" = SYSDATE
                            WHERE \"nip_kepala\" = '".$nip_kabag_old."' ";
            $this->db->query($sql_update_bawahan2);
        }

        return true;


    }


    public function tabel_kasubag()
    {
        $requestData = $this->input->post(); 
        $spmu_pimpinan = $requestData['spmu_pimpinan'];
        $kolok1 = $requestData['kolok1'];
        $nip_kadis = $requestData['nip_kadis'];
        $kolok_kadis = $requestData['kolok_kadis'];
        $kojab_kadis = $requestData['kojab_kadis'];
        $nrk_kadis = $requestData['nrk_kadis'];

        if($spmu_pimpinan == 'C030' || $spmu_pimpinan == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_pimpinan == 'C040' || $spmu_pimpinan == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_pimpinan."' ";
        }

        // echo $where;exit();
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_kasi(\''.$nip_kadis.'\',\''.$kolok_kadis.'\',\''.$kojab_kadis.'\',\''.$nrk_kadis.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_pimpinan.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
            
            // // $nestedData[] = $row->TABELID;
            // if($row->TABELID == 1){
            //     $nestedData[] = "<div align='center'>Gaji</div> ";
            // }else if($row->TABELID == 2){
            //     $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>TKD Guru</div> ";
            // }

            // // $nestedData[] = $row->BULANPLAIN;
            // if($row->BULANPLAIN == 13){
            //     $nestedData[] = "<div align='center'>Gaji 13</div> ";
            // }else if($row->BULANPLAIN == 14){
            //     $nestedData[] = "<div align='center'>Gaji 14</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>Gaji 15</div> ";
            // }
            
           
            
            
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

    public function pilih_kasi($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala){


        $sql = "INSERT INTO \"kadis_kepala_new\" (\"nip_kadis\", \"nip_kepala\", \"kolok_kadis\", \"kojab_kadis\", \"nrk_kadis\", \"kolok_kepala\", \"kojab_kepala\", \"nrk_kepala\",\"tglupdate\", \"userid_update\", \"spmu_kadis\", \"spmu_kepala\")                

        VALUES ('".$nip_kadis."','".$nip18_kepala."','".$kolok_kadis."','".$kojab_kadis."','".$nrk_kadis."',
                '".$kolok_kepala."','".$kojab_kepala."','".$nrk_kepala."',SYSDATE,'".$user_id."'
                ,'".$spmu_kadis."','".$spmu_kepala."')"; 

        // echo $sql;exit();
        $this->db->query($sql);

        return true;


    }

    public function pilih_kasi_from_kabid_ubah($user_id,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip_kabag_old){

        $sql_insert_history = "INSERT INTO \"kadis_kepala_new_history\" (SELECT * from \"kadis_kepala_new\" WHERE \"nip_kepala\" = '".$nip_kabag_old."' )";
        // echo $sql_insert_history;exit();
        $this->db->query($sql_insert_history);

        #update data kabid
        $sql_update = "UPDATE \"kadis_kepala_new\" 
                            set \"nip_kepala\" = '".$nip18_kepala."', 
                            \"kolok_kepala\" = '".$kolok_kepala."' ,
                            \"kojab_kepala\" = '".$kojab_kepala."',
                            \"nrk_kepala\" = '".$nrk_kepala."',
                            \"spmu_kepala\" = '".$spmu_kepala."',
                            \"userid_update\" = '".$user_id."',
                            \"tglupdate\" = SYSDATE
                            WHERE \"nip_kepala\" = '".$nip_kabag_old."' ";
        $this->db->query($sql_update);

        #update data kabid bawahan

        $sql_cek_bawahan_staff = "SELECT count(*) as JML from \"kepala_staff_new\" where \"nip_kepala\" = '".$nip_kabag_old."' " ; 
        $q_cek_bawahan_staff = $this->db->query($sql_cek_bawahan_staff)->row();
        if($q_cek_bawahan_staff->JML > 0){

            $sql_insert_history_staff = "INSERT INTO \"kepala_staff_new_history\" (SELECT * from \"kepala_staff_new\" WHERE \"nip_kepala\" = '".$nip_kabag_old."' )";
            // echo $sql_insert_history;exit();
            $this->db->query($sql_insert_history_staff);

            $sql_update_bawahan2 = "UPDATE \"kepala_staff_new\" 
                            set \"nip_kepala\" = '".$nip18_kepala."', 
                            \"kolok_kepala\" = '".$kolok_kepala."' ,
                            \"kojab_kepala\" = '".$kojab_kepala."',
                            \"nrk_kepala\" = '".$nrk_kepala."',
                            \"spmu_kepala\" = '".$spmu_kepala."',
                            \"userid_update\" = '".$user_id."',
                            \"tglupdate\" = SYSDATE
                            WHERE \"nip_kepala\" = '".$nip_kabag_old."' ";
            $this->db->query($sql_update_bawahan2);
        }

        return true;


    }

    public function tabel_pegawai()
    {
        $requestData = $this->input->post(); 
        $spmu_pimpinan = $requestData['spmu_pimpinan'];
        $kolok1 = $requestData['kolok1'];
        $nip_kadis = $requestData['nip_kadis'];
        $kolok_kadis = $requestData['kolok_kadis'];
        $kojab_kadis = $requestData['kojab_kadis'];
        $nrk_kadis = $requestData['nrk_kadis'];

        if($spmu_pimpinan == 'C030' || $spmu_pimpinan == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_pimpinan == 'C040' || $spmu_pimpinan == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_pimpinan."' ";
        }

        // echo $where;exit();
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%0%'
                    OR JBT.NESELON LIKE '%NON%'
                    OR JBT.ESELON LIKE '%CPNS%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                    JBT.ESELON LIKE '%0%'
                    OR JBT.NESELON LIKE '%NON%'
                    OR JBT.ESELON LIKE '%CPNS%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_pegawai(\''.$nip_kadis.'\',\''.$kolok_kadis.'\',\''.$kojab_kadis.'\',\''.$nrk_kadis.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_pimpinan.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
            
            // // $nestedData[] = $row->TABELID;
            // if($row->TABELID == 1){
            //     $nestedData[] = "<div align='center'>Gaji</div> ";
            // }else if($row->TABELID == 2){
            //     $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>TKD Guru</div> ";
            // }

            // // $nestedData[] = $row->BULANPLAIN;
            // if($row->BULANPLAIN == 13){
            //     $nestedData[] = "<div align='center'>Gaji 13</div> ";
            // }else if($row->BULANPLAIN == 14){
            //     $nestedData[] = "<div align='center'>Gaji 14</div> ";
            // }else{
            //     $nestedData[] = "<div align='center'>Gaji 15</div> ";
            // }
            
           
            
            
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

    public function pilih_pegawai($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff){


        $sql = "INSERT INTO \"kepala_staff_new\" (\"nip_kepala\", \"nip_staff\", \"kolok_kepala\", \"kojab_kepala\", \"nrk_kepala\", \"kolok_staff\", \"kojab_staff\", \"nrk_staff\",\"tglupdate\", \"userid_update\", \"spmu_kepala\", \"spmu_staff\")                

        VALUES ('".$nip_kepala."','".$nip18_staff."','".$kolok_kepala."','".$kojab_kepala."','".$nrk_kepala."',
                '".$kolok_staff."','".$kojab_staff."','".$nrk_staff."',SYSDATE,'".$user_id."'
                ,'".$spmu_kepala."','".$spmu_staff."')"; 

        // echo $sql;
        $this->db->query($sql);

        return true;


    }

    public function hapus_kepala($user_id,$nip_kadis,$nip_kepala){

        #cek data bawahan yang berupa kasi
        $sql_cek_kasi = "SELECT count(*) as JML from \"kadis_kepala_new\" where \"nip_kadis\" ='".$nip_kepala."' ";
        $q_cek_kasi = $this->db->query($sql_cek_kasi)->row();

        if($q_cek_kasi->JML > 0){
            #ambil data kasi
            $sql_kasi = "SELECT \"nip_kadis\",\"nip_kepala\" from \"kadis_kepala_new\" where \"nip_kadis\" ='".$nip_kepala."' ";
            $q_kasi = $this->db->query($sql_kasi)->result();
            foreach ($q_kasi as $kasi) {

                $this->hapus_kasi($kasi->nip_kepala);
                
            }

        }

        #cek bawahan berupa staff
        $sql_cek_staff = "SELECT count(*) as JML from \"kepala_staff_new\" where \"nip_kepala\" ='".$nip_kepala."' ";
        $q_cek_staff = $this->db->query($sql_cek_staff)->row();
        if($q_cek_staff->JML > 0){
            #ambil data staff
            $sql_staff = "SELECT \"nip_kepala\",\"nip_staff\" from \"kepala_staff_new\" where \"nip_kepala\" ='".$nip_kepala."' ";
            $q_staff = $this->db->query($sql_staff)->result();
            foreach ($q_staff as $staff) {

                $this->hapus_staff($user_id,$staff->nip_staff);
                
            }
            
        }

        #pindahkan kabid/kepala
        $sql_insert_history = "INSERT INTO \"kadis_kepala_new_history\" (SELECT * from \"kadis_kepala_new\" WHERE \"nip_kepala\" = '".$nip_kepala."' )";
        $this->db->query($sql_insert_history);

        #hapus kabid/kepala
        $sql_del_kasi = "DELETE from \"kadis_kepala_new\" where \"nip_kepala\" ='".$nip_kepala."' ";
        $this->db->query($sql_del_kasi);

        return true;
    }

    public function hapus_kasi($nip_kasi){
        $sql_cek_kasi_bawahan = "SELECT count(*) as JML from \"kepala_staff_new\" where \"nip_kepala\" = '".$nip_kasi."' " ; 
        $q_cek_kasi_bawahan = $this->db->query($sql_cek_kasi_bawahan)->row();

        if($q_cek_kasi_bawahan->JML > 0){
            #pindah bawahan kasi ke history
            $sql_insert_history_staff_bwh_kasi = "INSERT INTO \"kepala_staff_new_history\" (SELECT * from \"kepala_staff_new\" WHERE \"nip_kepala\" = '".$nip_kasi."' )";
            $this->db->query($sql_insert_history_staff_bwh_kasi);

            #hapus bawahan kasi
            $sql_del_bwh_kasi = "DELETE from \"kepala_staff_new\" where \"nip_kepala\" ='".$nip_kasi."' ";
            $this->db->query($sql_del_bwh_kasi);

        }

        #pindahkan kasi
        $sql_insert_history = "INSERT INTO \"kadis_kepala_new_history\" (SELECT * from \"kadis_kepala_new\" WHERE \"nip_kepala\" = '".$nip_kasi."' )";
        $this->db->query($sql_insert_history);

        #hapus bawahan kasi
        $sql_del_kasi = "DELETE from \"kadis_kepala_new\" where \"nip_kepala\" ='".$nip_kasi."' ";
        $this->db->query($sql_del_kasi);

        return true;
    }

    public function hapus_staff($user_id,$nip){

        $sql_insert_history_staff = "INSERT INTO \"kepala_staff_new_history\" (SELECT * from \"kepala_staff_new\" WHERE \"nip_staff\" ='".$nip."')";
        // echo $sql_insert_history;exit();
        $this->db->query($sql_insert_history_staff);

        $sql1 = "DELETE from \"kepala_staff_new\" where \"nip_staff\" ='".$nip."' ";
        $this->db->query($sql1);

        return true;
    }

    public function get_pegawai1($nip18){
        $sql="SELECT KOLOK, KOJAB, NRK, SPMU, NIP18, NAMA from PERS_PEGAWAI1 where NIP18='".$nip18."' ";

        return $this->db->query($sql)->row();
    }


    public function tabel_kasubag_form_kabid()
    {
        $requestData = $this->input->post(); 

        $nip_kabid = $requestData['nip_kabid'];
        $kolok_kabid = $requestData['kolok_kabid'];
        $kojab_kabid = $requestData['kojab_kabid'];
        $nrk_kabid = $requestData['nrk_kabid'];
        $spmu_kabid = $requestData['spmu_kabid'];
        $spmu_kadis = $requestData['spmu_kadis'];

        if($spmu_kadis == 'C030' || $spmu_kadis == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_kadis == 'C040' || $spmu_kadis == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_kadis."' ";
        }

        // echo $where;exit();
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%3%'
                        OR JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%3%'
                        OR JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_kasi_from_kabid(\''.$nip_kabid.'\',\''.$kolok_kabid.'\',\''.$kojab_kabid.'\',\''.$nrk_kabid.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_kabid.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
                    
            
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

    public function tabel_kasubag_form_kabid_ubah()
    {
        $requestData = $this->input->post(); 

        $spmu_kadis = $requestData['spmu_kadis'];
        $nip_kasubag_old = $requestData['nip_kasubag_old'];
        $spmu_kabid_ubah = $requestData['spmu_kabid_ubah'];
        $kolok_kabid_ubah = $requestData['kolok_kabid_ubah'];
        $nip_kabid = $requestData['nip_kabid_ubah_kasi'];

        if($spmu_kadis == 'C030' || $spmu_kadis == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_kadis == 'C040' || $spmu_kadis == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_kadis."' ";
        }

        // echo $where;exit();
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%3%'
                        OR JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%3%'
                        OR JBT.ESELON LIKE '%4%'
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_kasi_from_kabid_ubah(\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$row->SPMU.'\',\''.$nip_kasubag_old.'\',\''.$spmu_kabid_ubah.'\',\''.$kolok_kabid_ubah.'\',\''.$nip_kabid.'\')"><i class="fa fa-check"></i> Pilih </a>';
                    
            
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

    public function tabel_pegawai_from_kabid()
    {
        $requestData = $this->input->post(); 

        $nip_kabid = $requestData['nip_kabid'];
        $kolok_kabid = $requestData['kolok_kabid'];
        $kojab_kabid = $requestData['kojab_kabid'];
        $nrk_kabid = $requestData['nrk_kabid'];
        $spmu_kabid = $requestData['spmu_kabid'];
        $spmu_kadis = $requestData['spmu_kadis'];

        if($spmu_kadis == 'C030' || $spmu_kadis == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_kadis == 'C040' || $spmu_kadis == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_kadis."' ";
        }


        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JABATAN'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%0%'
                        OR JBT.NESELON LIKE '%NON%'
                        OR JBT.ESELON LIKE '%CPNS%'
                        OR pg.STAPEG = 1
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                    
                )A";
        
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                    ,JBT.NAJABL as JABATAN
                    FROM PERS_PEGAWAI1 pg
                    LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                    ".$where." 
                    AND (
                        JBT.ESELON LIKE '%0%'
                        OR JBT.NESELON LIKE '%NON%'
                        OR JBT.ESELON LIKE '%CPNS%'
                        OR pg.STAPEG = 1
                    )
                    AND pg.KLOGAD NOT LIKE '11111111%'
                    AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NIP18) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
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
            // $nestedData[] = $no;
            $nestedData[] = $row->NIP18;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->JABATAN;
            // $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_wakil('.$nip_kadis.','.$kolok_kadis.','.$kojab_kadis.','.$nrk_kadis.','.$row->NIP18.','.$row->KOLOK_EXIST.','.$row->KOJAB_EXIST.','.$row->NRK.','.$spmu_pimpinan.')"><i class="fa fa-check"></i> Pilih </a>';

            $nestedData[] = ' <a  class="btn btn-info btn-xs black tambah" onclick="pilih_pegawai_from_kabid(\''.$nip_kabid.'\',\''.$kolok_kabid.'\',\''.$kojab_kabid.'\',\''.$nrk_kabid.'\',\''.$row->NIP18.'\',\''.$row->KOLOK_EXIST.'\',\''.$row->KOJAB_EXIST.'\',\''.$row->NRK.'\',\''.$spmu_kabid.'\',\''.$row->SPMU.'\')"><i class="fa fa-check"></i> Pilih </a>';
            
            
            
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


    public function get_pegawai_from_kasi($nip_kasi,$spmu_kasi,$str_cari_pegawai){
        if($spmu_kasi == 'C030' || $spmu_kasi == 'C031'){
            $where = "WHERE (pg.spmu = 'C030' OR pg.spmu = 'C031')";
        }elseif($spmu_kasi == 'C040' || $spmu_kasi == 'C041'){
            $where = "WHERE (pg.spmu = 'C040' OR pg.spmu = 'C041')";
        }else{
            $where = "WHERE pg.spmu = '".$spmu_kasi."' ";
        }

        $sql = "SELECT pg.*,PG.KOLOK as KOLOK_EXIST,PG.KOJAB as KOJAB_EXIST, JBT.ESELON
                ,JBT.NAJABL as JABATAN
                FROM PERS_PEGAWAI1 pg
                LEFT JOIN \"vw_jabatan_terakhir\" JBT on pg.NRK = JBT.NRK
                ".$where." 
                AND (
                    JBT.ESELON LIKE '%0%'
                    OR JBT.NESELON LIKE '%NON%'
                    OR JBT.ESELON LIKE '%CPNS%'
                    OR pg.STAPEG = 1
                )
                AND pg.KLOGAD NOT LIKE '11111111%'
                AND PG.NIP18 NOT IN (SELECT nip_bawahan FROM DN_KEPALA_BAWAHAN) 
                AND (PG.NRK = '".$str_cari_pegawai."' OR PG.NIP18 = '".$str_cari_pegawai."')
                ";

                // echo $sql;exit();

        return $this->db->query($sql)->result();
    }

    public function cek_data_pegawai($nrk_staff){
        $sql = "SELECT count(*) as JML from \"kepala_staff_new\" where \"nrk_staff\" = '".$nrk_staff."' " ; 

        return $this->db->query($sql)->row();
    }

    public function cek_data_kasi_kabid($nrk){
        $sql = "SELECT count(*) as JML from \"kadis_kepala_new\" where \"nrk_kepala\" = '".$nrk."' " ; 

        return $this->db->query($sql)->row();
    }


    public function pilih_pegawai_from_kasi($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff){


        $sql = "INSERT INTO \"kepala_staff_new\" (\"nip_kepala\", \"nip_staff\", \"kolok_kepala\", \"kojab_kepala\", \"nrk_kepala\", \"kolok_staff\", \"kojab_staff\", \"nrk_staff\",\"tglupdate\", \"userid_update\", \"spmu_kepala\", \"spmu_staff\")                

        VALUES ('".$nip_kepala."','".$nip18_staff."','".$kolok_kepala."','".$kojab_kepala."','".$nrk_kepala."',
                '".$kolok_staff."','".$kojab_staff."','".$nrk_staff."',SYSDATE,'".$user_id."'
                ,'".$spmu_kepala."','".$spmu_staff."')"; 

        // echo $sql;
        $this->db->query($sql);

        // echo $sql;
        // exit();


        // $pesan = 'tes';

        return True;


    }



   
    
}

?>
