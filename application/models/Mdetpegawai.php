<?php 

 class Mdetpegawai extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';
    private $bt;
  

    function __construct()
    {        
        parent::__construct();

        $this->bt =& get_instance();
        $this->bt->load->database(); 
       // $this->db = $this->bt->load->database('29', TRUE);
        
    }

    function get_datahistduk($nrk,$thbl)
    {
        $sql = "SELECT 
                    NRK,
                    NIP,
                    NIP18,
                    NAMA,
                    PATHIR,
                    TO_CHAR (TALHIR, 'DD-MM-YYYY') TALHIR,
                    KLOGAD,
                    F_GET_NALOK (KLOGAD) NAKLOGAD,
                    KOLOK,
                    F_GET_NALOK (KOLOK) NALOKL,
                    KOJAB,
                    F_GET_NAJAB (KOLOK, KOJAB, KD) NAJABL,
                    JENKEL,
                    CASE
                        JENKEL WHEN 'L' THEN 'LAKI-LAKI'
                    ELSE 'PEREMPUAN'
                    END KET_JENKEL,
                    AGAMA,
                    F_GET_KETAGAMA(AGAMA) KET_AGAMA,
                    SPMU,
                    F_GET_NAMASPM(SPMU) NAMA_SPMU,
                    ESELON,
                    F_GET_NESELON(ESELON)NESELON,
                    MASKER,
                    STAPEG,
                    F_GET_STAPEG(STAPEG) KET_STAPEG,
                    UMUR,
                    STAWIN,
                    F_GET_STAWIN(STAWIN) KET_STAWIN,
                    KOPANG,
                    F_GET_GOL_BYKOPANG(KOPANG)GOLKOPANG,
                    F_GET_NAPANG(KOPANG)NAPANG 
                FROM PERS_DUK_PANGKAT_HISTDUK WHERE NRK ='$nrk' AND THBL = '$thbl'";
        $query = $this->db->query($sql);

        return $query;
    }

    public function get_pensiun_skpd_next()
    {

        $requestData = $this->input->post();    

        $spmu = $requestData['spmu'];
        $th_next = $requestData['th_next'];
        $thbl = $requestData['thbl'];
        // var_dump($thbl);exit;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'THBLPENSIUN',
            3 => 'JUMLAHTOTAL'

        );

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS
                        RN,
                        D.* 
                    FROM
                        (
                    SELECT
                        A.THBL,
                        ( TO_CHAR( SYSDATE, 'YYYY' ) + 1 ) TH_NEXT,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) THBLPENSIUN,
                        A.SPMU,
                        C.NAMA,
                        COUNT( A.NRK ) JUMLAHTOTAL 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A LEFT JOIN PERS_TABEL_SPMU C ON A.SPMU = C.KODE_SPM 
                    WHERE
                        A.THBL = '".$thbl."'
                        AND A.SPMU = '".$spmu."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) IN ( '".$th_next."01', '".$th_next."02', '".$th_next."03', '".$th_next."04', '".$th_next."05', '".$th_next."06', '".$th_next."07', '".$th_next."08', '".$th_next."09', '".$th_next."10', '".$th_next."11', '".$th_next."12' ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ),
                        A.THBL,
                        A.SPMU,
                        C.NAMA
                    ORDER BY TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) asc
                    ) D
                )A ";
        
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS
                        RN,
                        D.* 
                    FROM
                        (
                    SELECT
                        A.THBL,
                        ( TO_CHAR( SYSDATE, 'YYYY' ) + 1 ) TH_NEXT,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) THBLPENSIUN,
                        A.SPMU,
                        C.NAMA,
                        COUNT( A.NRK ) JUMLAHTOTAL 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A LEFT JOIN PERS_TABEL_SPMU C ON A.SPMU = C.KODE_SPM 
                    WHERE
                        A.THBL = '".$thbl."'
                        AND A.SPMU = '".$spmu."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) IN ( '".$th_next."01', '".$th_next."02', '".$th_next."03', '".$th_next."04', '".$th_next."05', '".$th_next."06', '".$th_next."07', '".$th_next."08', '".$th_next."09', '".$th_next."10', '".$th_next."11', '".$th_next."12' ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ),
                        A.THBL,
                        A.SPMU,
                        C.NAMA
                    ORDER BY TO_CHAR( A.TMTPENSIUNYAD, 'YYYYMM' ) asc
                    ) D
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(THBLPENSIUN) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        // echo $sql;
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND A.RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY A.RN ";  // adding length
        
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
            $nestedData[] = $row->NAMA;
            $nestedData[] = $row->THBLPENSIUN;
            $nestedData[] = $row->JUMLAHTOTAL;

            
            
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
}

?>
