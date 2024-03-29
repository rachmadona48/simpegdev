<?php 

 class M_batch extends CI_Model {  

    var $today = '';

    private $bt;

    function __construct()   
    {        
        parent::__construct();
        $this->today = date('Y-m-d');

        $this->bt =& get_instance();
        $this->bt->load->database(); 
        $this->prod = $this->bt->load->database('batch', TRUE);
    }   

    /*START SETTING MENU*/
    // function getnextvalMenuPostgre(){
    //     $sql = "SELECT nextval('menu_master_id_menu_seq')";
    //     $query = $this->db->query($sql)->row();
    //     return $query->nextval;
    // } 

    public function get_Tgl_Batch()
    {
        $sql = " SELECT TGL_BATCH,ID
                FROM PERSJP_TGLBATCH ";
        // var_dump($sql);exit;
        return $this->prod->query($sql)->row();
    }

    public function get_hari_kerja()
    {
        $sql = " SELECT HARI_KERJA
                FROM PERSJP_HARI_KERJA
                WHERE ID = 1 ";
        // var_dump($sql);exit;
        return $this->prod->query($sql)->row();
    }

    public function input_nrk($nrk_ssl){
        $select = "SELECT MAX(ID) AS ID_MAX
                    FROM PERSJP_NRK_SSL
                    ";
        $data = $this->prod->query($select)->row();
        $id = ($data->ID_MAX)+1; 

        $insert = "INSERT INTO PERSJP_NRK_SSL(ID,NRK_SSL)
                    VALUES('".$id."','".$nrk_ssl."') ";
        return $this->prod->query($insert);
    }

    public function cek_nrk_ssl_pegawai1($nrk_ssl){
        $sql_cek="SELECT * FROM PERS_PEGAWAI1 WHERE NRK='".$nrk_ssl."'";
        return  $this->prod->query($sql_cek);
    }

    public function jml_nrk_ssl_table($nrk_ssl){
        $select = "SELECT COUNT(*) AS JML_NRK_SSL 
                   FROM PERSJP_NRK_SSL
                     ";
        return $this->prod->query($select)->row();
    }

    public function upload_nrk_ssl($nrk_ssl){
        $select = "SELECT 
                    CASE 
                        WHEN JML IS NULL THEN '0'
                        ELSE JML
                    END JML_MAK
                    FROM
                    (
                        SELECT MAX(ID) AS JML
                        FROM PERSJP_NRK_SSL
                    ) ";
        $data = $this->prod->query($select)->row();
        $id_maks = $data->JML_MAK;
        $id_new = $id_maks+1;

        $sql_insert = "INSERT INTO PERSJP_NRK_SSL(ID,NRK_SSL)VALUES('".$id_new."','".$nrk_ssl."')";
        // echo $sql_insert; exit();                            
        return $this->prod->query($sql_insert);
    }

    public function exc_truncate_nrk_ssl(){
        $sql = "TRUNCATE TABLE PERSJP_NRK_SSL";
        // var_dump($sql);exit;
        return $this->prod->query($sql);
    }

    public function getGaji()
    {
        $requestData = $this->input->post(); 
        $tgl_batch3 = $requestData['tgl_batch3'];
        // $th = substr($tgl_batch, 0,4);
        // $bln= substr($tgl_batch, 5,2);
        // $tgl_batch3 = $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'THBL',
            1 => 'THBL',
            2 => 'THBL', 
            3 => 'THBL',
            4 => 'THBL',
            5 => 'THBL'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$tgl_batch3."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$tgl_batch3."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->GAPOK);
            $nestedData[] = $this->format_uang->rp_format($row->NJUMBERGAJI);
            
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

    public function getGaji_ssl()
    {
        $requestData = $this->input->post(); 
        $thbl = $requestData['thbl_ssl'];
        // echo $thbl_ssl; exit();
        // $th = substr($thbl_ssl, 0,4);
        // $bln= substr($thbl_ssl, 5,2);
        // $thbl= $th.$bln;
        // echo $tgl_batch3; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'THBL',
            2 => 'NRK', 
            3 => 'NAMA',
            4 => 'NJUMBERGAJI',
            5 => 'NALOK'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,a.THBL,a.NRK,a.NAMA,a.GAPOK,a.NJUMBERGAJI,a.KOLOK,a.KOJAB,a.KOJABF,a.KD,a.KLOGAD,B.NALOK
                    FROM
                    (
                        SELECT
                            THBL,
                            NRK,
                            NAMA,
                            GAPOK,
                            NJUMBERGAJI,
                            KOLOK,
                            KOJABF,
                            KOJAB,
                            KD,
                            KLOGAD
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK_TP
                        WHERE
                            THBL = '".$thbl."'
                    )a
                    LEFT JOIN
                    (
                        SELECT KOLOK,NALOK from PERS_KLOGAD3
                    )b on a.KLOGAD = B.KOLOK
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,a.THBL,a.NRK,a.NAMA,a.GAPOK,a.NJUMBERGAJI,a.KOLOK,a.KOJAB,a.KOJABF,a.KD,a.KLOGAD,B.NALOK
                    FROM
                    (
                        SELECT
                            THBL,
                            NRK,
                            NAMA,
                            GAPOK,
                            NJUMBERGAJI,
                            KOLOK,
                            KOJABF,
                            KOJAB,
                            KD,
                            KLOGAD
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK_TP
                        WHERE
                            THBL = '".$thbl."'
                    )a
                    LEFT JOIN
                    (
                        SELECT KOLOK,NALOK from PERS_KLOGAD3
                    )b on a.KLOGAD = B.KOLOK
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NALOK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->NJUMBERGAJI);
            $nestedData[] = $row->NALOK;
            
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

    public function getPPH(){
        $requestData = $this->input->post(); 
        $tgl_batch2 = $requestData['tgl_batch2'];
        // echo $tgl_batch2;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'THBL',
            1 => 'THBL',
            2 => 'THBL', 
            3 => 'THBL',
            4 => 'THBL',

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,PPH_BULAN
                FROM PERSJP_DUK_PANGKAT_PPH
                WHERE THBL = '".$tgl_batch2."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,PPH_BULAN
                FROM PERSJP_DUK_PANGKAT_PPH
                WHERE THBL = '".$tgl_batch2."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->PPH_BULAN);
            
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

    public function getDataPTTbyNPTT($nptt)
    {
        $sql = "SELECT NPTT,NAMA,TO_CHAR(TGLLAHIR,'DD-MM-YYYY')TGLLAHIR,KODEL,JABAT FROM PERS_MASTER_PTT_JAN16 WHERE NPTT ='".$nptt."'";
        
        $query = $this->prod->query($sql);


        return $query->row();
    }

    public function getPTT(){
        $requestData = $this->input->post(); 
        
        // echo $tgl_batch2;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NPTT',
            2 => 'NAMA', 
            3 => 'TGLLAHIR',
            4 => 'KODEL',
            5 => 'JABAT',
            //6 => 'THBL',
        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,NPTT,NAMA,TO_CHAR(TGLLAHIR,'DD-MM-YYYY')TGLLAHIR,KODEL, JABAT
                FROM PERS_MASTER_PTT_JAN16
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,NPTT,NAMA,TO_CHAR(TGLLAHIR,'DD-MM-YYYY')TGLLAHIR,KODEL, JABAT
                FROM PERS_MASTER_PTT_JAN16
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NPTT LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  KODEL LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  JABAT LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NPTT;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->TGLLAHIR;
            $nestedData[] = $row->KODEL;
            $nestedData[] = $row->JABAT;
            $nestedData[] = "<button type='button' class='btn btn-outline btn-xs btn-success' title='Edit' onClick='getForm(\"update\",\"".$row->NPTT."\");'><i class='fa fa-pencil-square'></i></button> &nbsp;";
            
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

    public function getPTT13(){
        $requestData = $this->input->post(); 
        $th13 = $requestData['th13'];
        $thbl13 = $th13.'13';
        
        // echo $thbl13; die();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'THBL',
            2 => 'NPTT', 
            3 => 'NAMA',
            4 => 'NALOKS',
            5 => 'NAMA_SPMU',
            6 => 'GAJIBERSIH',
            //6 => 'THBL',
        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NPTT,A.NAMA,TO_CHAR(A.TGLLAHIR,'DD-MM-YYYY')TGLLAHIR,A.KLOGAD,A.KEAHLIAN,A.SPMU,A.GAJIBERSIH,
                    B.NAMA NAMA_SPMU,C.NALOKS
                    FROM PERS_GAJI_PTT A
                    LEFT JOIN (
                        SELECT * FROM PERS_TABEL_SPMU
                    )B ON A.SPMU = B.KODE_SPM
                    LEFT JOIN (
                        SELECT * FROM PERS_LOKASI_TBL
                    )C ON A.KLOGAD = C.KOLOK
                    WHERE A.THBL = '".$thbl13."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NPTT,A.NAMA,TO_CHAR(A.TGLLAHIR,'DD-MM-YYYY')TGLLAHIR,A.KLOGAD,A.KEAHLIAN,A.SPMU,A.GAJIBERSIH,
                    B.NAMA NAMA_SPMU,C.NALOKS
                    FROM PERS_GAJI_PTT A
                    LEFT JOIN (
                        SELECT * FROM PERS_TABEL_SPMU
                    )B ON A.SPMU = B.KODE_SPM
                    LEFT JOIN (
                        SELECT * FROM PERS_LOKASI_TBL
                    )C ON A.KLOGAD = C.KOLOK
                    WHERE A.THBL = '".$thbl13."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( THBL LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NPTT LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA_SPMU LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKS LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $row->RN;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NPTT;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->NALOKS;
            $nestedData[] = $row->NAMA_SPMU;
            $nestedData[] = $this->format_uang->rp_format($row->GAJIBERSIH);
            
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

    public function getPTTRes(){
        $requestData = $this->input->post(); 
        
        // echo $tgl_batch2;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NPTT',
            2 => 'NAMA', 
            3 => 'TGLLAHIR',
            4 => 'KODEL',
            5 => 'JABAT',
        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,NPTT,THBL,NAMA,KLOGAD, KEAHLIAN
                FROM PERS_GAJI_PTT WHERE THBL = TO_CHAR(jpgetthbl (), 'YYYYMM')
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,NPTT,THBL,NAMA,KLOGAD, KEAHLIAN
                FROM PERS_GAJI_PTT WHERE THBL = TO_CHAR(jpgetthbl (), 'YYYYMM')
                )A WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NPTT LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  KLOGAD LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  KEAHLIAN LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NPTT;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KLOGAD;
            $nestedData[] = $row->KEAHLIAN;
            
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

    public function getTPP(){
        $requestData = $this->input->post(); 
        
        $thbltpp = $requestData['thbltpp'];

        $columns = array( 
        // datatable column index  => database column name
            0 => 'THBL',
            1 => 'THBL',
            2 => 'NPTT', 
            3 => 'NAMA',
            4 => 'KINERJA',
            5 => 'TPPBERSIH',
            6 => 'NALOKL',
        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT C.RN,C.THBL,C.NPTT,C.NAMA,C.KLOGAD,C.KEAHLIAN,C.KINERJA,C.TPP,C.POTKINERJA,C.JMLSTLPOT,C.TPPBERSIH,C.SPMU,
                        C.POTABSENSI,C.JMLSTLABS,B.NALOKL
                    FROM
                    (
                        SELECT ROWNUM AS RN,THBL,NPTT,NAMA,KLOGAD,KEAHLIAN,KINERJA,TPP,POTKINERJA,JMLSTLPOT,TPPBERSIH,SPMU,
                        POTABSENSI,JMLSTLABS
                        FROM PERSJP_TPP_PTT
                        WHERE THBL = '".$thbltpp."'
                    )C
                    LEFT JOIN(
                        SELECT KOLOK,NALOKL 
                        FROM PERS_LOKASI_TBL
                    )B ON C.KLOGAD = B.KOLOK
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT C.RN,C.THBL,C.NPTT,C.NAMA,C.KLOGAD,C.KEAHLIAN,C.KINERJA,C.TPP,C.POTKINERJA,C.JMLSTLPOT,C.TPPBERSIH,C.SPMU,
                        C.POTABSENSI,C.JMLSTLABS,B.NALOKL
                    FROM
                    (
                        SELECT ROWNUM AS RN,THBL,NPTT,NAMA,KLOGAD,KEAHLIAN,KINERJA,TPP,POTKINERJA,JMLSTLPOT,TPPBERSIH,SPMU,
                        POTABSENSI,JMLSTLABS
                        FROM PERSJP_TPP_PTT
                        WHERE THBL = '".$thbltpp."'
                    )C
                    LEFT JOIN(
                        SELECT KOLOK,NALOKL 
                        FROM PERS_LOKASI_TBL
                    )B ON C.KLOGAD = B.KOLOK
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( THBL LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NPTT LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  KINERJA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  TPPBERSIH LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKL LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NPTT;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->KINERJA;
            $nestedData[] = $this->format_uang->rp_format($row->TPPBERSIH);
            $nestedData[] = $row->NALOKL;
            // $nestedData[] = "<button type='button' class='btn btn-outline btn-xs btn-success' title='Edit' onClick='getForm(\"update\",\"".$row->NPTT."\");'><i class='fa fa-pencil-square'></i></button> &nbsp;";
            
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

    public function getGaji13(){
        $requestData = $this->input->post(); 

        $tahun = $requestData['tahun'];
        $bln = '13';
        $thbl = $tahun.$bln;
        /*echo $thbl; exit();*/
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'THBL',
            1 => 'THBL',
            2 => 'THBL', 
            3 => 'THBL',
            4 => 'THBL',
            5 => 'THBL'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl."'
                )A";
        
        /*echo $sql; exit();*/
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->GAPOK);
            $nestedData[] = $this->format_uang->rp_format($row->NJUMBERGAJI);
            
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

    public function getGaji14(){
        $requestData = $this->input->post(); 

        $tahun = $requestData['tahun'];
        $bln = '14';
        $thbl = $tahun.$bln;
        /*echo $thbl; exit();*/
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'THBL',
            2 => 'NRK', 
            3 => 'NAMA',
            4 => 'GAPOK',
            5 => 'NJUMBERGAJI'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl."'
                )A";
        
        // echo $sql; exit();
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,THBL,NRK,NAMA,GAPOK,NJUMBERGAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->GAPOK);
            $nestedData[] = $this->format_uang->rp_format($row->NJUMBERGAJI);
            
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

    public function getKrimi(){
        $requestData = $this->input->post(); 

        $tgl_batch = $requestData['thbl'];
        $th = substr($tgl_batch, 0,4);
        $bln= substr($tgl_batch, 5,2);
        $thbl = $th.$bln;
        // echo $thbl; exit();
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NRK',
            2 => 'NAMA', 
            3 => 'KOLOK',
            4 => 'KLOGAD',
            // 5 => 'KOJAB',
            5 => 'KOPANG',
        );

        // getting total number records without any search
        $sql = "SELECT ROWNUM,A.* FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD
                    FROM PERSJP_TKD_TRANS A
                    LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                    LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                    LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                    WHERE THBL='".$thbl."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT ROWNUM,A.* FROM (
                 SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD
                FROM PERSJP_TKD_TRANS A
                LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                WHERE THBL='".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NRK LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKL LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAKLOGAD LIKE UPPER('%".$requestData['search']['value']."%') OR";

            $sql.="  NAPANG LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        //ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->NALOKL;
            $nestedData[] = $row->NAKLOGAD;
            $kolok = $row->KOLOK;
            $kojab = $row->KOJAB;
            // $najabl='';
            // if($row->KD == 'S')
            // {
            //     $getkojab = "SELECT NAJABL FROM PERS_KOJAB_TBL WHERE KOLOK = '".$kolok."' AND KOJAB='".$kojab."'";
            //     $Qgetkojab = $this->db->query($getkojab)->row();
            //     $najabl = $Qgetkojab->NAJABL;
            // }
            // else 
            // {
            //     $getkojab = "SELECT NAJABL FROM PERS_KOJABF_TBL WHERE KOJAB='".$kojab."'";
            //     $Qgetkojab = $this->db->query($getkojab)->row();
            //     $najabl = $Qgetkojab->NAJABL;
            // }

            // $nestedData[] = $najabl;
            $nestedData[] = $row->NAPANG;
            
        
            
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

    public function getTKD2(){
        $requestData = $this->input->post(); 

        $thbl = $requestData['thbl'];
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NRK',
            2 => 'NAMA', 
            3 => 'KOLOK',
            4 => 'KLOGAD',
            // 5 => 'KOJAB',
            5 => 'KOPANG',
            6 => 'THBL',
            7 => 'NJTUNDABERSIH',
        );

        // getting total number records without any search
        $sql = "SELECT ROWNUM,A.* FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,A.NJTUNDABERSIH
                    FROM PERSJP_TKD_TAHAP2 A
                    LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                    LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                    LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                    WHERE THBL='".$thbl."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT ROWNUM,A.* FROM (
                SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,A.NJTUNDABERSIH
                FROM PERSJP_TKD_TAHAP2 A
                LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                WHERE THBL='".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NRK LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKL LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAKLOGAD LIKE UPPER('%".$requestData['search']['value']."%') OR";

            $sql.="  NAPANG LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->NALOKL;
            $nestedData[] = $row->NAKLOGAD;
            $kolok = $row->KOLOK;
            $kojab = $row->KOJAB;
            // $najabl='ssss';
            // if($row->KD == 'S')
            // {
            //     $getkojab = "SELECT NAJABL FROM PERS_KOJAB_TBL WHERE KOLOK = '".$kolok."' AND KOJAB='".$kojab."'";
            //     $Qgetkojab = $this->db->query($getkojab)->row();
            //     $najabl = $Qgetkojab->NAJABL;
            // }
            // else 
            // {
            //     $getkojab = "SELECT NAJABL FROM PERS_KOJABF_TBL WHERE KOJAB='".$kojab."'";
            //     $Qgetkojab = $this->db->query($getkojab)->row();
            //     $najabl = $Qgetkojab->NAJABL;
            // }

            // $nestedData[] = $najabl;
            $nestedData[] = $row->NAPANG;
            // $nestedData[] = $row->NJTUNDABERSIH;
            $nestedData[] = $this->format_uang->rp_format($row->NJTUNDABERSIH);
            
        
            
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

    public function getTKDGuru(){
        $requestData = $this->input->post(); 

        $thbl = $requestData['thbl'];
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NRK',
            2 => 'NAMA', 
            3 => 'KOLOK',
            4 => 'KLOGAD',
            5 => 'KOJAB',
            6 => 'KOPANG',
            7 => 'THBL',
            7 => 'NJTUNDABERSIH',
        );

        // getting total number records without any search
        $sql = "SELECT ROWNUM,A.* FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,A.NJTUNDABERSIH
                    FROM PERSJP_TKD_GURU A
                    LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                    LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                    LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                    WHERE THBL='".$thbl."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT ROWNUM,A.* FROM (
                 SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,A.NJTUNDABERSIH
                FROM PERSJP_TKD_GURU A
                LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                WHERE THBL='".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NRK LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKL LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAKLOGAD LIKE UPPER('%".$requestData['search']['value']."%') OR";

            $sql.="  NAPANG LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->NALOKL;
            $nestedData[] = $row->NAKLOGAD;
            $kolok = $row->KOLOK;
            $kojab = $row->KOJAB;
            $najabl='';
            if($row->KD == 'S')
            {
                $getkojab = "SELECT NAJABL FROM PERS_KOJAB_TBL WHERE KOLOK = '".$kolok."' AND KOJAB='".$kojab."'";
                $Qgetkojab = $this->db->query($getkojab)->row();
                $najabl = $Qgetkojab->NAJABL;
            }
            else 
            {
                $getkojab = "SELECT NAJABL FROM PERS_KOJABF_TBL WHERE KOJAB='".$kojab."'";
                $Qgetkojab = $this->db->query($getkojab)->row();
                $najabl = $Qgetkojab->NAJABL;
            }

            $nestedData[] = $najabl;
            $nestedData[] = $row->NAPANG;
            $nestedData[] = $this->format_uang->rp_format($row->NJTUNDABERSIH);
            
        
            
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

    

    public function getTKDTransp(){
        $requestData = $this->input->post(); 

        $thbl = $requestData['thbl'];
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NRK',
            2 => 'NAMA', 
            3 => 'KOLOK',
            4 => 'KLOGAD',
            5 => 'KOJAB',
            6 => 'KOPANG',
            7 => 'THBL',
            8 => 'JUMBER',
        );

        // getting total number records without any search
        $sql = "SELECT ROWNUM,A.* FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,
                    E.NAJABL AS JABATAN_S ,F.NAJABL AS JABATAN_F,A.JUMBER
                    FROM PERSJP_DUK_PANGKAT_TRANSPORT A
                    LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                    LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                    LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                    LEFT JOIN(
                        SELECT KOLOK,KOJAB,NAJABL
                        FROM PERS_KOJAB_TBL
                    )E ON A.KOLOK = E.KOLOK AND A.KOJAB = E.KOJAB
                    LEFT JOIN(
                        SELECT KOJAB,NAJABL
                        FROM PERS_KOJABF_TBL
                    )F ON A.KOJAB = F.KOJAB
                    WHERE A.THBL='".$thbl."'
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT ROWNUM,A.* FROM (
                    SELECT ROWNUM AS RN,A.THBL,A.NRK,A.NAMA,A.KOLOK,B.NALOKL,A.KLOGAD,C.NALOKL AS NAKLOGAD,A.KOJAB,A.KOPANG,D.NAPANG,A.KD,
                    E.NAJABL AS JABATAN_S ,F.NAJABL AS JABATAN_F,A.JUMBER
                    FROM PERSJP_DUK_PANGKAT_TRANSPORT A
                    LEFT JOIN PERS_LOKASI_TBL B ON A.KOLOK = B.KOLOK
                    LEFT JOIN PERS_LOKASI_TBL_SEPT16 C ON A.KLOGAD = C.KOLOK
                    LEFT JOIN PERS_PANGKAT_TBL_NOW D ON A.KOPANG = D.KOPANG
                    LEFT JOIN(
                        SELECT KOLOK,KOJAB,NAJABL
                        FROM PERS_KOJAB_TBL
                    )E ON A.KOLOK = E.KOLOK AND A.KOJAB = E.KOJAB
                    LEFT JOIN(
                        SELECT KOJAB,NAJABL
                        FROM PERS_KOJABF_TBL
                    )F ON A.KOJAB = F.KOJAB
                    WHERE A.THBL='".$thbl."'
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND ( NRK LIKE lower('%".$requestData['search']['value']."%') OR";
            $sql.="  NAMA LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NALOKL LIKE UPPER('%".$requestData['search']['value']."%') OR";
            $sql.="  NAKLOGAD LIKE UPPER('%".$requestData['search']['value']."%') OR";

            $sql.="  NAPANG LIKE UPPER('%".$requestData['search']['value']."%') )";
            
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->NALOKL;
            $nestedData[] = $row->NAKLOGAD;

            // $kolok = $row->KOLOK;
            // $kojab = $row->KOJAB;
            $najabl='';
            if($row->KD == 'S')
            {
                
                $najabl = $row->JABATAN_S;
            }
            else 
            {
                $najabl = $row->JABATAN_F;
            }
            // ECHO $najabl;exit();

            $nestedData[] = $najabl;
            $nestedData[] = $row->NAPANG;
            $nestedData[] = $this->format_uang->rp_format($row->JUMBER);
        
            
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

    function updatePTT($data)
    {
        

        $nptt = $data['nptt'];
        $kodel = $data['kodel'];

        $sql = "UPDATE PERS_MASTER_PTT_JAN16 SET KODEL='".$kodel."' WHERE NPTT='".$nptt."'";
        $query = $this->prod->query($sql);

        return $query;
    }

    public function getPlain ()
    {

    $requestData = $this->input->post();    

        $columns = array( 
        // datatable column index  => database column name
            0 => 'TABELID',
            1 => 'TABELID',
            2 => 'TABELID', 
            3 => 'TABELID',
            4 => 'TABELID',

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN, \"NO\",THBL,BULANPLAIN,TABELID
                    FROM PERSJP_TGL_PLAIN
                )A ";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN, \"NO\",THBL,BULANPLAIN,TABELID
                    FROM PERSJP_TGL_PLAIN
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(BULANPLAIN) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            
            // $nestedData[] = $row->TABELID;
            if($row->TABELID == 1){
                $nestedData[] = "<div align='center'>Gaji</div> ";
                // $nestedData[] = $row->BULANPLAIN;
                if($row->BULANPLAIN == 13){
                    $nestedData[] = "<div align='center'>Gaji 13</div> ";
                }else if($row->BULANPLAIN == 14){
                    $nestedData[] = "<div align='center'>Gaji 14</div> ";
                }else{
                    $nestedData[] = "<div align='center'>Gaji 15</div> ";
                }
            }else if($row->TABELID == 2){
                $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
                // $nestedData[] = $row->BULANPLAIN;
                if($row->BULANPLAIN == 13){
                    $nestedData[] = "<div align='center'>TKD 13</div> ";
                }else if($row->BULANPLAIN == 14){
                    $nestedData[] = "<div align='center'>TKD 14</div> ";
                }else{
                    $nestedData[] = "<div align='center'>TKD 15</div> ";
                }
            }else{
                $nestedData[] = "<div align='center'>TKD Guru</div> ";
                // $nestedData[] = $row->BULANPLAIN;
                if($row->BULANPLAIN == 13){
                    $nestedData[] = "<div align='center'>TKD Guru 13</div> ";
                }else if($row->BULANPLAIN == 14){
                    $nestedData[] = "<div align='center'>TKD Guru 14</div> ";
                }else{
                    $nestedData[] = "<div align='center'>TKD Guru 15</div> ";
                }
                
            }

            
            
            $nestedData[] = "   <div align='center'>
                                    <button class='btn btn-danger btn-circle btn-outline' 
                                    onClick=deletePlain('".$row->THBL."') ><i class='fa fa-trash-o'></i></button> 
                                </div>
                            ";
            
            
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

    public function getGaji_Lain()
    {

        $requestData = $this->input->post();    

        $thbl = $requestData['tgl_batch'];
        // var_dump($thbl);exit;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'NRK',
            1 => 'NAMA',
            2 => 'NRK', 
            3 => 'NRK',
            4 => 'NRK',
            5 => 'NRK',
            6 => 'NRK'

        );

        if($thbl!=null){
            $where = "WHERE THBL = ".$thbl." ";
        }else{
            $where = " ";
        }
        // var_dump($where);exit;

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,THBL,NRK,NAMA,NJTUNDABERSIH,JNS_PENGHASILAN,TABELID
                    FROM PERSJP_PENGHASILAN_LAIN
                    ".$where."
                )A ";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,THBL,NRK,NAMA,NJTUNDABERSIH,JNS_PENGHASILAN,TABELID
                    FROM PERSJP_PENGHASILAN_LAIN
                    ".$where."
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND A.RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY ".$columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->THBL;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = $this->format_uang->rp_format($row->NJTUNDABERSIH);
            
            $nestedData[] = "<div align='center'>".$row->JNS_PENGHASILAN."</div> ";
            // $nestedData[] = $row->JNS_PENGHASILAN;
            // $nestedData[] = $row->TABELID;

            if($row->TABELID==1){
                $nestedData[] = "<div align='center'>Gaji</div> ";
            }elseif ($row->TABELID==2) {
                $nestedData[] = "<div align='center'>TKD Pegawai</div> ";
            }else{
                $nestedData[] = "<div align='center'>TKD Guru</div> ";
            }

            
            
            
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

    public function get_data_nrk_ssl()
    {
        $requestData = $this->input->post(); 
        
        

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NRK_SSL'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,ID,NRK_SSL
                FROM PERSJP_NRK_SSL
                )A";
        
        
        $query = $this->prod->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RN,ID,NRK_SSL
                FROM PERSJP_NRK_SSL
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NRK_SSL) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->prod->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->prod->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK_SSL;
            
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


    public function cekLain($thbl,$bulanplain,$tabelid){
        $sql = "SELECT COUNT(\"NO\") AS JML FROM PERSJP_TGL_PLAIN
                WHERE THBL ='".$thbl."'
                AND BULANPLAIN ='".$bulanplain."'
                AND TABELID = '".$tabelid."' ";

        $query= $this->prod->query($sql)->row();
        return $query;

    }

    public function cek_gaji13($thbl13){
        $sql = "SELECT COUNT(*) AS JML_GAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl13."' ";

        $query= $this->prod->query($sql)->row();
        return $query;
    }

    public function cek_gaji14($thbl14){
        $sql = "SELECT COUNT(*) AS JML_GAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$thbl14."' ";

        $query= $this->prod->query($sql)->row();
        return $query;
    }

    public function CekPPH($tgl_batch2){
        $sql = "SELECT COUNT(*) AS JML_PPH
                FROM PERSJP_DUK_PANGKAT_PPH
                WHERE THBL = '".$tgl_batch2."' ";
        return $this->prod->query($sql)->row();
    }

    public function CekGajiToPPH($tgl_batch2){
        $sql = "SELECT COUNT(*) AS JML_GAJI
                FROM PERS_DUK_PANGKAT_HISTDUK
                WHERE THBL = '".$tgl_batch2."' ";
        // echo $sql;exit;
        return $this->prod->query($sql)->row();
    }

    public function CekTKD2($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML_TKD2
                FROM (
                SELECT NRK,THBL FROM PROSES_TKD_TAHAP2 WHERE THBL = '".$tgl_batch."'
                UNION ALL
                SELECT NRK,THBL FROM PROSES_TKD_GURU WHERE THBL = '".$tgl_batch."'
                )";
        //echo $sql;exit;
        return $this->prod->query($sql)->row();
    }

    public function CekTransport($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML_TRANS
                FROM PERS_DUK_PANGKAT_TRANSPORT
                WHERE THBL = '".$tgl_batch."'";
        //echo $sql;exit;
        return $this->prod->query($sql)->row();
    }

    public function cekGaji_ptt($thbl_ptt){
        $sql = "SELECT COUNT(*) AS JML_GAJI
                FROM pers_GAJI_ptt
                WHERE THBL = '".$thbl_ptt."' ";
        //echo $sql;exit;
        return $this->prod->query($sql)->row();
    }

    public function cek_TPP_ptt($thbltpp){
        $sql = "SELECT COUNT(*) AS JML_GAJI
                FROM pers_tpp_ptt
                WHERE THBL = '".$thbltpp."' ";
        //echo $sql;exit;
        return $this->prod->query($sql)->row();
    }

    public function updateBatch($tgl_batch2,$idt2){
        $tahun = substr($tgl_batch2, 0,4);
        $bulan = substr($tgl_batch2, 4,2);
        $tglSave = $tahun.'-'.$bulan.'-01';
        // echo $tglSave;exit;
        $sql = " UPDATE PERSJP_TGLBATCH SET TGL_BATCH = '".$tglSave."' WHERE \"ID\" = '".$idt2."' ";
         
        return $this->prod->query($sql);

    }

    public function updateBatchprint($thbl){
        $tahun = substr($thbl, 0,4);
        $bulan = substr($thbl, 4,2);
        $tglSave = $tahun.'-'.$bulan.'-01';
        // echo $tglSave;exit;
        $sql = " UPDATE PERSJP_TGLBATCH SET TGL_BATCH = '".$tglSave."' WHERE \"ID\" = '1' ";
         
        return $this->prod->query($sql);

    }

    public function updateBatchprint_tkd($thbl){
        
        // echo $tglSave;exit;
        $sql = " UPDATE PERSJP_TGLBATCH SET TGL_BATCH = '".$thbl."' WHERE \"ID\" = '1' ";
         
        return $this->prod->query($sql);

    }

    public function updateBatchprint_gj($thbl){
        $tahun = substr($thbl, 0,4);
        $bulan = substr($thbl, 4,2);
        $tglSave = $tahun.'-'.$bulan.'-01';
        // echo $tglSave;exit;
        $sql = " UPDATE PERSJP_TGLBATCH SET TGL_BATCH = '".$tglSave."' WHERE \"ID\" = '1' ";
        // echo $sql; exit();
        return $this->prod->query($sql);

    }

    public function updateHariKerja($hr_krja){
        $sql = "UPDATE PERSJP_HARI_KERJA
                SET HARI_KERJA = ".$hr_krja." WHERE \"ID\" = '1' ";
         
        return $this->prod->query($sql);

    }

    public function saveLain($thbl,$bulanplain,$tabelid){
        $sql = "SELECT COUNT(\"NO\")+1 AS NOB FROM PERSJP_TGL_PLAIN";
        $query = $this->prod->query($sql)->row();

        $nob = $query->NOB;
        // var_dump($nob);exit;
        $insert = " INSERT INTO PERSJP_TGL_PLAIN (THBL,BULANPLAIN,TABELID,\"NO\")
                    VALUES ('".$thbl."','".$bulanplain."','".$tabelid."','".$nob."') ";
        return $this->prod->query($insert);
    }

    public function hapus_tgl($thbl){
        $sql = "CALL HAPUS_PLAIN('".$thbl."') ";

        return $this->prod->query($sql);
    }

    // public function hapus_Lain($thbl){
    //     $sql = "DELETE FROM PERSJP_PENGHASILAN_LAIN WHERE THBL = '".$thbl."' ";

    //     return $this->prod->query($sql);
    // }

    public function pengLain($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERSJP_PENGHASILAN_LAIN
                WHERE THBL = '".$tgl_batch."' ";
        return $this->prod->query($sql)->row();
    }

    public function tbl_plain($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML_PLAIN
                FROM PERSJP_TGL_PLAIN
                WHERE THBL = '".$tgl_batch."' ";

        return $this->prod->query($sql)->row();
    }

    public function krimiTKD($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERSJP_TKD_TRANS
                WHERE THBL = '".$tgl_batch."' ";
        return $this->prod->query($sql)->row();
    }

    public function TKD2($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML
                FROM (
                    SELECT NRK,THBL FROM PERSJP_TKD_GURU
                    WHERE THBL = '".$tgl_batch."'
                    UNION ALL
                    SELECT NRK,THBL FROM PERSJP_TKD_TAHAP2
                    WHERE THBL = '".$tgl_batch."'
                ) ";
        return $this->prod->query($sql)->row();
    }

    public function Transport($tgl_batch){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERSJP_DUK_PANGKAT_TRANSPORT
                WHERE THBL = '".$tgl_batch."' ";
        return $this->prod->query($sql)->row();
    }

    public function ubahDate_format(){
        $sql = "alter session set nls_date_format = 'DD-MM-YYYY' ";
        echo $sql;
        return $this->prod->query($sql);
    }

    public function execute_gaji(){
        $sql1 = "alter session set nls_date_format = 'DD-MM-YYYY' ";
        $this->prod->query($sql1);

        $sql = " CALL JPGAJIPEGAWAI_CURSOR.main() ";
        
        //echo $sql1;echo $sql;
        return $this->prod->query($sql);
    }

    public function execute_gaji_ssl(){
        $sql1 = "alter session set nls_date_format = 'DD-MM-YYYY'";
        $this->prod->query($sql1);

        $sql = "CALL JPGAJIPEGAWAI_CURSOR_SSL.main()";
        $data = $this->prod->query($sql);
       
        $err = $this->prod->error();
        
        // echo 'hsl : '.console.log($data); die();
        return $data;
    }

    public function execute_pph(){
        $sql = "CALL JPGAJI_PPH_BULAN_CURSOR.main() ";
        return $this->prod->query($sql);
    }

    public function execute_ptt(){

        $cek ="SELECT count(*) JUMLAH from pers_gaji_ptt where thbl=TO_CHAR (jpgetthbl (), 'YYYYMM')";
        $quecek = $this->prod->query($cek);
        $numcek = $quecek->row();
        $res_numcek = $numcek->JUMLAH;

        $res_return;
        if($res_numcek >0)
        {
            $res_return = -1;
        }
        else
        {
            $sql = "CALL GAJI_PTT_JAN16_NOPARAM() ";
            $this->prod->query($sql);

            $query_res="SELECT COUNT(*) JML from pers_gaji_ptt where thbl=TO_CHAR (jpgetthbl (), 'YYYYMM')";
            $numres= $this->prod->query($query_res)->row();
            $res_numres = $numres->JML;

            if($res_numres>0)
            {
                $res_return = 1;
            }
            else
            {
                $res_return =0;
            }

        }


        
        return $res_return;
    }

    public function execute_ptt_13($th13){
        $sql = "call DN_GAJI_PTT_13('".$th13."') ";
        $exc = $this->prod->query($sql);

        return true;
    }

    public function cek_gaji_ptt($thblptt13){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERS_GAJI_PTT
                WHERE THBL = '".$thblptt13."' ";
        // echo $sql; exit();
        return $this->prod->query($sql)->row();
    }

    public function cek_gaji_13($th13){
        $thbl_13 = $th13.'13';
        $sql = "SELECT COUNT(*) AS JML
                FROM PERS_GAJI_PTT
                WHERE THBL = '".$thbl_13."' ";
        // echo $sql; exit();
        return $this->prod->query($sql)->row();
    }

    public function cek_data_tpp1($thbl){
        $sql = "SELECT COUNT(*) AS JML
                FROM PERSJP_TPP_PTT
                WHERE THBL = '".$thbl."' ";
        // echo $sql; exit();
        return $this->prod->query($sql)->row();
    }

    public function exc_tpp1(){
        $sql = "CALL DN_TPP_PTT()";
        return $this->prod->query($sql);
    }

    public function exc_tpp2(){
        // untuk rutin
        $sql = "CALL DN_TPP_TAHAP2()"; 

        // untuk jka ada kondisi lain
        // $sql = "CALL DN_TPP_TAHAP2_SEL_DES()"; 
        return $this->prod->query($sql);
    }

    public function exc_penghasilanLain(){
        $sql = "CALL JPGAJI_131415_CURSOR.main() ";
        return $this->prod->query($sql);
    }

    public function exc_gaji13($tahun){
        $sql = "CALL DN_GAJI_13('".$tahun."') ";
        return $this->prod->query($sql);
    }

    public function exc_gaji14($tahun){
        $sql = "CALL DN_GAJI_14('".$tahun."') ";
        return $this->prod->query($sql);
    }

    public function exc_krimi_TKD(){
        $sql = "CALL DNA_TKD_TRANS.main() ";
        return $this->prod->query($sql);
    }

    public function exc_TKD_Tahap2(){
        $sql = "CALL DNA_TKDTAHAP2_GURU.main() ";
        return $this->prod->query($sql);
    }

    public function excTransport(){
        $sql = "CALL DNA_TRANSPORT.main() ";
        return $this->prod->query($sql);
    }

    public function get_gaji(){
        $sql = "SELECT * FROM DN_VW_GAJI ";
        $query = $this->prod->query($sql);

        $option  = "";
        
        foreach($query->result() as $row){
            
                $option .= "<option value='".$row->THBLA."'>Gaji ".$row->THBLA."</option>";
        }
        
        return $option;
    }

    public function get_tkd(){
        $sql = "SELECT * FROM DN_VW_TKD2 ";
        $query = $this->prod->query($sql);

        $option  = "";
        
        foreach($query->result() as $row){
            
                $option .= "<option value='".$row->THBLA."'>TKD ".$row->THBLA."</option>";
        }
        
        return $option;
    }

    public function get_tkd_guru(){
        $sql = "SELECT * FROM DN_VW_TKD_GURU_SHOW ";
        $query = $this->prod->query($sql);

        $option  = "";
        
        foreach($query->result() as $row){
            
                $option .= "<option value='".$row->THBLA."'>TKD Guru ".$row->THBLA."</option>";
        }
        
        return $option;
    }

    public function printGaji(){
        $sql = "SELECT NRK,NIP,NIP18,NAMA,GOL,SPMU,KLOGAD,NALOKS,NJUMBERGAJI,THBL FROM DN_GAJI_TXT";
        return $this->prod->query($sql)->result();
    }

    public function printGaji_TKD2(){
        $sql = "SELECT NRK,NIP18,NAMA,SPMU,KLOGAD,NALOKL,NJTUNDABERSIH,THBL,KDESEL
                FROM DN_TKD_TXT";
        return $this->prod->query($sql)->result();
    }

    public function print_Transport(){
        $sql = "SELECT NRK,NIP18,NAMA,SPMU,KLOGAD,NALOKL,JUMBER,THBL,KDESEL FROM DN_TRANSPORT_TXT";
        return $this->prod->query($sql)->result();
    }

    public function printGAJI_ptt($tglBatch){
        $sql = "SELECT THBL,a.NAMA,a.NPTT,a.TGLLAHIR,a.KLOGAD,b.NALOKS
                ,a.GAJIBERSIH
                from pers_GAJI_ptt A  
                left join pers_lokasi_tbl b on a.klogad = b.kolok
                where a.thbl='".$tglBatch."' and a.GAJIBERSIH > 0 
                order by a.klogad,a.NPTT";
        // echo $sql;exit();
        return $this->prod->query($sql)->result();
    }

    public function print_TPP_PTT($tglBatch){
        $sql = "SELECT
                    A.THBL,
                    A.NPTT,
                    A.NAMA,
                    A.KLOGAD,
                    b.NALOKS,
                    A.TPPBERSIH
                FROM
                    pers_tpp_ptt A
                LEFT JOIN pers_lokasi_tbl b ON A .klogad = b.kolok
                WHERE
                    A .thbl = '".$tglBatch."'
                AND A .TPPBERSIH > 0
                ORDER BY
                    A .spmu,
                    A .NPTT";
        // echo $sql;exit();
        return $this->prod->query($sql)->result();
    }

}

?>