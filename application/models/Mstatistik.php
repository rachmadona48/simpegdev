<?php 

 class Mstatistik extends CI_Model {

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

    function getThblparam($thbl="")
    {
        $sql = "SELECT DISTINCT(THBL) THBL FROM PERS_DUK_PANGKAT_HISTDUK WHERE THBL LIKE '201%' AND SUBSTR(THBL,5,2) IN ('01','02','03','04','05','06','07','08','09','10','11','12') ORDER BY THBL DESC";

        $query = $this->db->query($sql);        

        $option  = "";
        
        foreach($query->result() as $row){
            if($thbl == $row->THBL)
            {
                $option .= "<option selected value='".$row->THBL."'>".$row->THBL."</option>";
            }
            else
            {          
                $option .= "<option value='".$row->THBL."'>".$row->THBL."</option>";
            }
        }
        
        return $option;   

    }

    public function getSpmuFromThbl($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (
                    SELECT DISTINCT(SPMU) SPMU FROM PERS_DUK_PANGKAT_HISTDUK A WHERE THBL='".$thbl."' ) BKL
                    LEFT JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";
            //die($sql);
        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value='-'>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }   

    public function getUkpdFromThblSpm($thbl,$spmu)
    {
        
        $sql="SELECT BKL.KLOGAD,B.NALOKL FROM 
                (
                    SELECT DISTINCT(KLOGAD) KLOGAD FROM PERS_DUK_PANGKAT_HISTDUK A WHERE THBL='".$thbl."' AND SPMU='".$spmu."') BKL
                    LEFT JOIN PERS_LOKASI_TBL B ON BKL.KLOGAD = B.KOLOK ORDER BY BKL.KLOGAD ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value='-'>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->KLOGAD."'>".$row->KLOGAD." - ".$row->NALOKL."</option>";
            
        }
        
        return $option;       
    } 

    function getAllStatGender()
    {
        $sql = "SELECT jenkel,count(jenkel)jml from pers_pegawai1 where klogad not like '1111111%' AND NRK < 999999
                AND NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412
                )GROUP BY jenkel ORDER BY jenkel asc";

        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatGender($thbl,$spmu,$klogad)
    {
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $sql = "SELECT jenkel,count(jenkel)jml from pers_duk_pangkat_histduk where thbl='".$thbl."'  GROUP BY jenkel ORDER BY jenkel asc";    
        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $sql = "SELECT jenkel,count(jenkel)jml from pers_duk_pangkat_histduk where thbl='".$thbl."' and spmu='".$spmu."' GROUP BY jenkel ORDER BY jenkel asc";
        }
        else
        {
            $sql = "SELECT jenkel,count(jenkel)jml from pers_duk_pangkat_histduk where thbl='".$thbl."' and spmu='".$spmu."' AND KLOGAD='".$klogad."' GROUP BY jenkel ORDER BY jenkel asc";    
        }
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatGenderPNS($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) LAKILAKI,
                        NVL (C.JML, 0) PEREMPUAN,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='L' AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='P' AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatGenderCPNS($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) LAKILAKI,
                        NVL (C.JML, 0) PEREMPUAN,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='L' AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='P' AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql;
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }


    function getStatGenderAll($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) LAKILAKI,
                        NVL (C.JML, 0) PEREMPUAN,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='L'
                        AND (STAPEG = 2 or STAPEG = 1)
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENKEL='P'
                        AND (STAPEG = 2 or STAPEG = 1)
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }



    function getStatEselon($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                SUBSTR (A .kopang, 2, 1) GOL,NVL(B.JML,0)ESELON1A,NVL(C.JML,0)ESELON1B,NVL(D.JML,0)ESELON2A,NVL(E.JML,0)ESELON2B
                ,NVL(F.JML,0)ESELON3A,NVL(G.JML,0)ESELON3B,NVL(H.JML,0)ESELON4A,NVL(I.JML,0)ESELON4B, 
                (NVL(B.JML,0) + NVL(C.JML,0) + NVL(D.JML,0) + NVL(E.JML,0) + NVL(F.JML,0) + NVL(G.JML,0) + NVL(H.JML,0) + NVL(I.JML,0)) JUMLAHTOTAL
            FROM
                PERS_DUK_PANGKAT_HISTDUK A
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '11'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) B ON SUBSTR(A.KOPANG,2,1)=B.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '12'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) C ON SUBSTR(A.KOPANG,2,1)=C.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '21'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) D ON SUBSTR(A.KOPANG,2,1)=D.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '22'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) E ON SUBSTR(A.KOPANG,2,1)=E.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '31'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) F ON SUBSTR(A.KOPANG,2,1)=F.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '32'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) G ON SUBSTR(A.KOPANG,2,1) = G.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '41'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) H ON SUBSTR(A.KOPANG,2,1) = H.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE ESELON = '42'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) I ON SUBSTR(A.KOPANG,2,1) = I.GOL
            WHERE
                A .THBL = '$thbl'
            ORDER BY SUBSTR(A.KOPANG,2,1) ASC";  
        
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatEselon_L($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                SUBSTR (A .kopang, 2, 1) GOL,NVL(B.JML,0)ESELON1A,NVL(C.JML,0)ESELON1B,NVL(D.JML,0)ESELON2A,NVL(E.JML,0)ESELON2B
                ,NVL(F.JML,0)ESELON3A,NVL(G.JML,0)ESELON3B,NVL(H.JML,0)ESELON4A,NVL(I.JML,0)ESELON4B, 
                (NVL(B.JML,0) + NVL(C.JML,0) + NVL(D.JML,0) + NVL(E.JML,0) + NVL(F.JML,0) + NVL(G.JML,0) + NVL(H.JML,0) + NVL(I.JML,0)) JUMLAHTOTAL
            FROM
                PERS_DUK_PANGKAT_HISTDUK A
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '11'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) B ON SUBSTR(A.KOPANG,2,1)=B.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '12'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) C ON SUBSTR(A.KOPANG,2,1)=C.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '21'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) D ON SUBSTR(A.KOPANG,2,1)=D.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '22'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) E ON SUBSTR(A.KOPANG,2,1)=E.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '31'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) F ON SUBSTR(A.KOPANG,2,1)=F.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '32'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) G ON SUBSTR(A.KOPANG,2,1) = G.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '41'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) H ON SUBSTR(A.KOPANG,2,1) = H.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'L' 
                AND ESELON = '42'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) I ON SUBSTR(A.KOPANG,2,1) = I.GOL
            WHERE
                A .THBL = '$thbl'
            ORDER BY SUBSTR(A.KOPANG,2,1) ASC";  
        
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatEselon_P($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                SUBSTR (A .kopang, 2, 1) GOL,NVL(B.JML,0)ESELON1A,NVL(C.JML,0)ESELON1B,NVL(D.JML,0)ESELON2A,NVL(E.JML,0)ESELON2B
                ,NVL(F.JML,0)ESELON3A,NVL(G.JML,0)ESELON3B,NVL(H.JML,0)ESELON4A,NVL(I.JML,0)ESELON4B, 
                (NVL(B.JML,0) + NVL(C.JML,0) + NVL(D.JML,0) + NVL(E.JML,0) + NVL(F.JML,0) + NVL(G.JML,0) + NVL(H.JML,0) + NVL(I.JML,0)) JUMLAHTOTAL
            FROM
                PERS_DUK_PANGKAT_HISTDUK A
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '11'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) B ON SUBSTR(A.KOPANG,2,1)=B.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '12'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) C ON SUBSTR(A.KOPANG,2,1)=C.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '21'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) D ON SUBSTR(A.KOPANG,2,1)=D.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '22'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) E ON SUBSTR(A.KOPANG,2,1)=E.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '31'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) F ON SUBSTR(A.KOPANG,2,1)=F.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '32'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) G ON SUBSTR(A.KOPANG,2,1) = G.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '41'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) H ON SUBSTR(A.KOPANG,2,1) = H.GOL
            LEFT JOIN (
                SELECT
                    SUBSTR (KOPANG, 2, 1) GOL,
                    COUNT (NRK) JML
                FROM
                    PERS_DUK_PANGKAT_HISTDUK
                
                WHERE JENKEL = 'P' 
                AND ESELON = '42'  $where
                GROUP BY
                    SUBSTR (KOPANG, 2, 1)
            ) I ON SUBSTR(A.KOPANG,2,1) = I.GOL
            WHERE
                A .THBL = '$thbl'
            ORDER BY SUBSTR(A.KOPANG,2,1) ASC";  
        
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatNonEselon($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR( A.kopang, 2, 1 ) GOL,
                        NVL( B.JML, 0 )  KD_F,
                        NVL( C.JML, 0 )  KD_S,
                        (NVL( B.JML, 0 ) + NVL( C.JML, 0 )) JUMLAHTOTAL 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A LEFT JOIN (
                    SELECT
                        SUBSTR( KOPANG, 2, 1 ) GOL,
                        COUNT( NRK ) JML 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK 
                    WHERE
                        KD = 'F' AND
                        ( ESELON = '00' OR ESELON = ' ' ) 
                        $where
                    GROUP BY
                        SUBSTR( KOPANG, 2, 1 ) 
                        ) B ON SUBSTR( A.KOPANG, 2, 1 ) = B.GOL 
                    LEFT JOIN (
                    SELECT
                        SUBSTR( KOPANG, 2, 1 ) GOL,
                        COUNT( NRK ) JML 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK 
                    WHERE
                        KD = 'S' AND
                        ( ESELON = '00' OR ESELON = ' ' ) 
                        $where 
                    GROUP BY
                        SUBSTR( KOPANG, 2, 1 ) 
                        ) C ON SUBSTR( A.KOPANG, 2, 1 ) = C.GOL
                    WHERE
                        A.THBL = '201803' 
                    ORDER BY
                        SUBSTR( A.KOPANG, 2, 1 ) ASC";  
        
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    // function getStatNonEselon($thbl,$spmu,$klogad)
    // {
    //     $where='';
    //     if($spmu == '-' && ($klogad == '' || $klogad == '-'))
    //     {
    //         $where = " AND THBL = '$thbl' ";

    //     }
    //     else if($spmu!='-' && $klogad =='-' )
    //     {
    //         $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
    //     }
    //     else
    //     {
    //         $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
    //     }
        
    //         $sql = "SELECT DISTINCT
    //             SUBSTR (A .kopang, 2, 1) GOL, 
    //             NVL(B.JML,0) JUMLAHTOTAL
    //         FROM
    //             PERS_DUK_PANGKAT_HISTDUK A
    //         LEFT JOIN (
    //             SELECT
    //                 SUBSTR (KOPANG, 2, 1) GOL,
    //                 COUNT (NRK) JML
    //             FROM
    //                 PERS_DUK_PANGKAT_HISTDUK
                
    //             WHERE (ESELON = '00' OR ESELON=' ')  $where
    //             GROUP BY
    //                 SUBSTR (KOPANG, 2, 1)
    //         ) B ON SUBSTR(A.KOPANG,2,1)=B.GOL
            
            
    //         WHERE
    //             A .THBL = '$thbl'
    //         ORDER BY SUBSTR(A.KOPANG,2,1) ASC";  
        
    //     // echo $sql;exit();
        
    //     $query = $this->db->query($sql);

    //     $result = $query->result();
    //     return $result;
    // }

    function getStatUsia($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                    SUBSTR (A .kopang, 2, 1) GOL,
                    NVL (B.JML, 0) BWAH25,
                    NVL (C.JML, 0) AN2530,
                    NVL (D .JML, 0) AN3036,
                    NVL (E .JML, 0) AN3642,
                    NVL (F.JML, 0) AN4248,
                    NVL (G .JML, 0) AN4855,
                    NVL (H .JML, 0) DIATAS55,
                    (
                        NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0) + NVL (H .JML, 0)
                    ) JUMLAHTOTAL
                FROM
                    PERS_DUK_PANGKAT_HISTDUK A
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        UMUR < 25 $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        (UMUR >= 25 AND UMUR < 30) $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        (UMUR >= 30 AND UMUR < 36) $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        (UMUR >= 36 AND UMUR < 42) $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        (UMUR >= 42 AND UMUR < 48) $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        (UMUR >= 48 AND UMUR <= 55) $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                LEFT JOIN (
                    SELECT
                        SUBSTR (KOPANG, 2, 1) GOL,
                        COUNT (NRK) JML
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK
                    WHERE
                        UMUR > 55 $where
                    AND thbl = '".$thbl."'
                    GROUP BY
                        SUBSTR (KOPANG, 2, 1)
                ) H ON SUBSTR (A .KOPANG, 2, 1) = H .GOL
                WHERE
                    A .THBL = '".$thbl."'
                ORDER BY
                    SUBSTR (A .KOPANG, 2, 1) ASC";  
        
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatPangkat($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }

             $sql = "SELECT DISTINCT
                        SUBSTR( A.kopang, 2, 1 ) GOL1,
                        CASE SUBSTR( A.kopang, 2, 1 ) 
                        WHEN '1' THEN 'I'
                        WHEN '2' THEN 'II'
                        WHEN '3' THEN 'III'
                        WHEN '4' THEN 'IV'
                        END GOL,
                        COUNT( NRK ) JMLGOL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A

                    WHERE
                        A .THBL = '".$thbl."' $where
                    GROUP BY SUBSTR (A .kopang, 2, 1) 
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
        
            // query lama
            // $sql = "SELECT DISTINCT
            //             SUBSTR (A .kopang, 2, 1) GOL,
            //             COUNT(NRK) JMLGOL
            //         FROM
            //             PERS_DUK_PANGKAT_HISTDUK A

            //         WHERE
            //             A .THBL = '".$thbl."' $where
            //         GROUP BY SUBSTR (A .kopang, 2, 1) 
            //         ORDER BY
            //             SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql; exit(); 
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatPangkatRuang($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }

             $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 2) GOL1,
                        CASE SUBSTR (A .kopang, 2, 2)
                    WHEN '11' THEN
                        'I/A'
                    WHEN '12' THEN
                        'I/B'
                    WHEN '13' THEN
                        'I/C'
                    WHEN '14' THEN
                        'I/D'
                    WHEN '21' THEN
                        'II/A'
                    WHEN '22' THEN
                        'II/B'
                    WHEN '23' THEN
                        'II/C'
                    WHEN '24' THEN
                        'II/D'
                    WHEN '31' THEN
                        'III/A'
                    WHEN '32' THEN
                        'III/B'
                    WHEN '33' THEN
                        'III/C'
                    WHEN '34' THEN
                        'III/D'
                    WHEN '41' THEN
                        'IV/A'
                    WHEN '42' THEN
                        'IV/B'
                    WHEN '43' THEN
                        'IV/C'
                    WHEN '44' THEN
                        'IV/D'
                    WHEN '45' THEN
                        'IV/E'
                    END GOL,
                     COUNT (NRK) JMLGOL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    WHERE
                        A .THBL = '".$thbl."' $where
                    GROUP BY
                        SUBSTR (A .kopang, 2, 2)
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 2) ASC";  
        
            // query lama
            // $sql = "SELECT DISTINCT
            //             SUBSTR (A .kopang, 2, 1) GOL,
            //             COUNT(NRK) JMLGOL
            //         FROM
            //             PERS_DUK_PANGKAT_HISTDUK A

            //         WHERE
            //             A .THBL = '".$thbl."' $where
            //         GROUP BY SUBSTR (A .kopang, 2, 1) 
            //         ORDER BY
            //             SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql; exit(); 
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatPangkatRuang2($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";
            $where1 = " WHERE THBL = '$thbl' ";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
            $where1 = " WHERE THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
            $where1 = " WHERE THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }

             $sql = "SELECT
                        AWAL.THBL,
                        NVL (STA.JML, 0) SATUA,
                        NVL (STB.JML, 0) SATUB,
                        NVL (STC.JML, 0) SATUC,
                        NVL (STD.JML, 0) SATUD,
                        NVL (DUA.JML, 0) DUAA,
                        NVL (DUB.JML, 0) DUAB,
                        NVL (DUC.JML, 0) DUAC,
                        NVL (DUD.JML, 0) DUAD,
                        NVL (TIA.JML, 0) TIGAA,
                        NVL (TIB.JML, 0) TIGAB,
                        NVL (TIC.JML, 0) TIGAC,
                        NVL (TID.JML, 0) TIGAD,
                        NVL (EMA.JML, 0) EMPATA,
                        NVL (EMB.JML, 0) EMPATB,
                        NVL (EMC.JML, 0) EMPATC,
                        NVL (EMD.JML, 0) EMPATD,
                        NVL (EME.JML, 0) EMPATE
                    FROM
                        (
                            SELECT
                                COUNT (NRK) JML,
                                THBL
                            FROM
                                PERS_DUK_PANGKAT_HISTDUK
                            $where1
                            GROUP BY
                                THBL
                        ) AWAL
                    LEFT JOIN
                        (
                            SELECT
                                COUNT (NRK) JML,
                                THBL
                            FROM
                                PERS_DUK_PANGKAT_HISTDUK
                            WHERE
                                SUBSTR (KOPANG, 2, 2) = '11'
                            $where
                            GROUP BY
                                SUBSTR (KOPANG, 2, 1),
                                THBL
                        ) STA ON AWAL.THBL = STA.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '12'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) STB ON AWAL.THBL = STB.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '13'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) STC ON AWAL.THBL = STC.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '14'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) STD ON AWAL.THBL = STD.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '21'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) DUA ON AWAL.THBL = DUA.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '22'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) DUB ON AWAL.THBL = DUB.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '23'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) DUC ON AWAL.THBL = DUC.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '24'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) DUD ON AWAL.THBL = DUD.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '31'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) TIA ON AWAL.THBL = TIA.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '32'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) TIB ON AWAL.THBL = TIB.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '33'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) TIC ON AWAL.THBL = TIC.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '34'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) TID ON AWAL.THBL = TID.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '41'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) EMA ON AWAL.THBL = EMA.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '42'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) EMB ON AWAL.THBL = EMB.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '43'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) EMC ON AWAL.THBL = EMC.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '44'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) EMD ON AWAL.THBL = EMD.THBL
                    LEFT JOIN (
                        SELECT
                            COUNT (NRK) JML,
                            THBL
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (KOPANG, 2, 2) = '45'
                        $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1),
                            THBL
                    ) EME ON AWAL.THBL = EME.THBL";  
        
            // query lama
            // $sql = "SELECT DISTINCT
            //             SUBSTR (A .kopang, 2, 1) GOL,
            //             COUNT(NRK) JMLGOL
            //         FROM
            //             PERS_DUK_PANGKAT_HISTDUK A

            //         WHERE
            //             A .THBL = '".$thbl."' $where
            //         GROUP BY SUBSTR (A .kopang, 2, 1) 
            //         ORDER BY
            //             SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql; exit(); 
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatPendidikan($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) TMI,
                        NVL (C.JML, 0) SD,
                        NVL (D .JML, 0) SMP,
                        NVL (E .JML, 0) SMA,
                        NVL (F.JML, 0) D1,
                        NVL (G .JML, 0) D2,
                        NVL (H .JML, 0) D3,
                        NVL (I.JML, 0) S1,
                        NVL (J.JML, 0) S2,
                        NVL (K .JML, 0) S3,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0) + NVL (H .JML, 0) + NVL (I.JML, 0) + NVL (J.JML, 0) + NVL (K.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK = '0000' --TMI
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '1%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '2%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '3%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '40%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND (
                            KODIK LIKE '45%'
                            OR KODIK LIKE '46%'
                            OR KODIK LIKE '47%'
                        ) 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '5%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) H ON SUBSTR (A .KOPANG, 2, 1) = H .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND (KODIK LIKE '6%' OR KODIK LIKE '7%') --S1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) I ON SUBSTR (A .KOPANG, 2, 1) = I.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '8%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) J ON SUBSTR (A .KOPANG, 2, 1) = J.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '2'
                        AND KODIK LIKE '9%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) K ON SUBSTR (A .KOPANG, 2, 1) = K .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatPendidikanCPNS($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) TMI,
                        NVL (C.JML, 0) SD,
                        NVL (D .JML, 0) SMP,
                        NVL (E .JML, 0) SMA,
                        NVL (F.JML, 0) D1,
                        NVL (G .JML, 0) D2,
                        NVL (H .JML, 0) D3,
                        NVL (I.JML, 0) S1,
                        NVL (J.JML, 0) S2,
                        NVL (K .JML, 0) S3,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0) + NVL (H .JML, 0) + NVL (I.JML, 0) + NVL (J.JML, 0) + NVL (K.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK = '0000' --TMI
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '1%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '2%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '3%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '40%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND (
                            KODIK LIKE '45%'
                            OR KODIK LIKE '46%'
                            OR KODIK LIKE '47%'
                        ) 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '5%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) H ON SUBSTR (A .KOPANG, 2, 1) = H .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND (KODIK LIKE '6%' OR KODIK LIKE '7%') 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) I ON SUBSTR (A .KOPANG, 2, 1) = I.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '8%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) J ON SUBSTR (A .KOPANG, 2, 1) = J.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            JENDIK = '1'
                        AND STAPEG = '1'
                        AND KODIK LIKE '9%' 
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) K ON SUBSTR (A .KOPANG, 2, 1) = K .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatStawin($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) BELUMKAWIN,
                        NVL (C.JML, 0) KAWIN,
                        NVL (D .JML, 0) JANDA,
                        NVL (E .JML, 0) DUDA, (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 0 AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN IN ('1', '2', '3', '4') AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 5 AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 6 AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatStawincpns($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) BELUMKAWIN,
                        NVL (C.JML, 0) KAWIN,
                        NVL (D .JML, 0) JANDA,
                        NVL (E .JML, 0) DUDA, (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 0 AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN IN ('1', '2', '3', '4') AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 5 AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            STAWIN = 6 AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatMasker($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) A15,
                        NVL (C.JML, 0) A610,
                        NVL (D .JML, 0) A1115,
                        NVL (E .JML, 0) A1620,
                        NVL (F.JML, 0) A2125,
                        NVL (G .JML, 0) A2530,
                        NVL (H .JML, 0) A3035,
                        NVL (H .JML, 0) A36,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0) + NVL (H .JML, 0) + NVL (I.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN (
                                '00',
                                '01',
                                '02',
                                '03',
                                '04',
                                '05'
                            )
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('06', '07', '08', '09', '10')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('11', '12', '13', '14', '15')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('16', '17', '18', '19', '20')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('21', '22', '23', '24', '25')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('26', '27', '28', '29', '30')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('31', '32', '33', '34', '35')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) H ON SUBSTR (A .KOPANG, 2, 1) = H .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) > 35
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) I ON SUBSTR (A .KOPANG, 2, 1) = I.GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatMasker10($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) A110,
                        NVL (C.JML, 0) A1120,
                        NVL (D .JML, 0) A2030,
                        NVL (E .JML, 0) A31,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) 
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('00','01','02','03','04','05','06', '07', '08', '09', '10')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('11', '12', '13', '14', '15','16', '17', '18', '19', '20')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('21', '22', '23', '24', '25','26', '27', '28', '29', '30')
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) > 30
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        // echo $sql;exit();
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatMaskercpns($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) A15,
                        NVL (C.JML, 0) A610,
                        NVL (D .JML, 0) A1115,
                        NVL (E .JML, 0) A1620,
                        NVL (F.JML, 0) A2125,
                        NVL (G .JML, 0) A2530,
                        NVL (H .JML, 0) A3035,
                        NVL (H .JML, 0) A36,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0) + NVL (H .JML, 0) + NVL (I.JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN (
                                '00',
                                '01',
                                '02',
                                '03',
                                '04',
                                '05'
                            )
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('06', '07', '08', '09', '10')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('11', '12', '13', '14', '15')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('16', '17', '18', '19', '20')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('21', '22', '23', '24', '25')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('26', '27', '28', '29', '30')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) IN ('31', '32', '33', '34', '35')
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) H ON SUBSTR (A .KOPANG, 2, 1) = H .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            SUBSTR (MASKER, 1, 2) > 35
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) I ON SUBSTR (A .KOPANG, 2, 1) = I.GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatAgama($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) ISLAM,
                        NVL (C.JML, 0) PROTESTAN,
                        NVL (D .JML, 0) KATOLIK,
                        NVL (E .JML, 0) HINDU,
                        NVL (F.JML, 0) BUDDHA,
                        NVL (G .JML, 0) KHONGHUCU,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 1
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 2
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 3
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 4
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 5
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 6
                        AND STAPEG = 2
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    function getStatAgamacpns($thbl,$spmu,$klogad)
    {
        $where='';
        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            $where = " AND THBL = '$thbl' ";

        }
        else if($spmu!='-' && $klogad =='-' )
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' ";
        }
        else
        {
            $where = " AND THBL = '$thbl' AND SPMU = '$spmu' AND KLOGAD = '$klogad' ";
        }
        
            $sql = "SELECT DISTINCT
                        SUBSTR (A .kopang, 2, 1) GOL,
                        NVL (B.JML, 0) ISLAM,
                        NVL (C.JML, 0) PROTESTAN,
                        NVL (D .JML, 0) KATOLIK,
                        NVL (E .JML, 0) HINDU,
                        NVL (F.JML, 0) BUDDHA,
                        NVL (G .JML, 0) KHONGHUCU,
                        (
                            NVL (B.JML, 0) + NVL (C.JML, 0) + NVL (D .JML, 0) + NVL (E .JML, 0) + NVL (F.JML, 0) + NVL (G .JML, 0)
                        ) JUMLAHTOTAL
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 1
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) B ON SUBSTR (A .KOPANG, 2, 1) = B.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 2
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) C ON SUBSTR (A .KOPANG, 2, 1) = C.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 3
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) D ON SUBSTR (A .KOPANG, 2, 1) = D .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 4
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) E ON SUBSTR (A .KOPANG, 2, 1) = E .GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 5
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) F ON SUBSTR (A .KOPANG, 2, 1) = F.GOL
                    LEFT JOIN (
                        SELECT
                            SUBSTR (KOPANG, 2, 1) GOL,
                            COUNT (NRK) JML
                        FROM
                            PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                            AGAMA = 6
                        AND STAPEG = 1
                        AND thbl = '".$thbl."' $where
                        GROUP BY
                            SUBSTR (KOPANG, 2, 1)
                    ) G ON SUBSTR (A .KOPANG, 2, 1) = G .GOL
                    WHERE
                        A .THBL = '".$thbl."'
                    ORDER BY
                        SUBSTR (A .KOPANG, 2, 1) ASC";  
                            
        
        
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    public function getStatTMTPensiunYAD($thbl,$spmu,$klogad)
    {

        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  

            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl."' 
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 5 
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND SPMU = '".$spmu."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  


            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl."'
                        AND SPMU = '".$spmu."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl."' 
                        AND SPMU = '".$spmu."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 5 
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";
                
        }
        else
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND SPMU = '".$spmu."' AND KLOGAD='".$klogad."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  

            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl."'
                        AND SPMU = '".$spmu."'
                        AND KLOGAD='".$klogad."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl."' 
                        AND SPMU = '".$spmu."'
                        AND KLOGAD='".$klogad."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 5 
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";

        }
        
        // echo $sql;exit();
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    public function getStatTMTPensiunYAD_th_before($thbl,$spmu,$klogad)
    {
        $th_before = (substr($thbl,0,4)-1);
        
        $thbl_before = $th_before.'12';
        // echo $thbl_before; exit();

        if($spmu == '-' && ($klogad == '' || $klogad == '-'))
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  

            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl_before."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl_before."' 
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' )-1,
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";

        }
        else if($spmu!='-' && ($klogad == '' || $klogad == '-') )
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND SPMU = '".$spmu."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  


            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl_before."'
                        AND SPMU = '".$spmu."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl_before."' 
                        AND SPMU = '".$spmu."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' )-1,
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";
                
        }
        else
        {
            // $sql = "SELECT TO_CHAR(TMTPENSIUNYAD,'YYYY')TAHUNPENSIUN,COUNT(NRK)JUMLAHTOTAL FROM PERS_DUK_PANGKAT_HISTDUK
            //     WHERE THBL='".$thbl."' AND SPMU = '".$spmu."' AND KLOGAD='".$klogad."' AND TO_CHAR(TMTPENSIUNYAD,'YYYY') IN (TO_CHAR(SYSDATE,'YYYY') , TO_CHAR(SYSDATE,'YYYY')+1, TO_CHAR(SYSDATE,'YYYY')+2, TO_CHAR(SYSDATE,'YYYY') +3, TO_CHAR(SYSDATE,'YYYY') +4, TO_CHAR(SYSDATE,'YYYY')+5)
            //     GROUP BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ORDER BY TO_CHAR(TMTPENSIUNYAD,'YYYY') ASC";  

            $sql = "SELECT
                        A.THBL,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        COUNT( A.NRK ) JUMLAHTOTAL,
                        NVL(B.JML,0) JMLALL,
                        (NVL(B.JML,0) - COUNT( A.NRK )) SISA_PEGAWAI
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A 
                    LEFT JOIN 
                    (
                        SELECT
                        THBL,
                        COUNT( NRK ) JML 
                        FROM
                        PERS_DUK_PANGKAT_HISTDUK
                        WHERE
                        THBL = '".$thbl_before."'
                        AND SPMU = '".$spmu."'
                        AND KLOGAD='".$klogad."'
                        GROUP BY THBL
                    )B ON A.THBL = B.THBL
                    WHERE
                        A.THBL = '".$thbl_before."' 
                        AND SPMU = '".$spmu."'
                        AND KLOGAD='".$klogad."'
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN (
                        TO_CHAR( SYSDATE, 'YYYY' )-1,
                        TO_CHAR( SYSDATE, 'YYYY' ),
                        TO_CHAR( SYSDATE, 'YYYY' ) + 1,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 2,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 3,
                        TO_CHAR( SYSDATE, 'YYYY' ) + 4
                        ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ), A.THBL 
                    ORDER BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) ASC";

        }
        
        // echo $sql;exit();
        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }

    public function get_pensiun_skpd_next()
    {

        $requestData = $this->input->post();    

        $thbl = $requestData['thbl'];
        // var_dump($thbl);exit;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'RN',
            1 => 'NAMA',
            2 => 'JUMLAHTOTAL'

        );

        // if($thbl!=null){
        //     $where = "WHERE THBL = ".$thbl." ";
        // }else{
        //     $where = " ";
        // }
        // var_dump($where);exit;

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS
                        RN,
                        D.* 
                    FROM
                        (
                    SELECT
                        A.THBL,
                        ( TO_CHAR( SYSDATE, 'YYYY' ) + 1 ) TH_NEXT,
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        A.SPMU,
                        C.NAMA,
                        COUNT( A.NRK ) JUMLAHTOTAL 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A LEFT JOIN PERS_TABEL_SPMU C ON A.SPMU = C.KODE_SPM 
                    WHERE
                        A.THBL = '".$thbl."' 
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN ( TO_CHAR( SYSDATE, 'YYYY' ) + 1 ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ),
                        A.THBL,
                        A.SPMU,
                        C.NAMA 
                    ) D 
                )A ";
        
        // echo $sql;exit();
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
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) TAHUNPENSIUN,
                        A.SPMU,
                        C.NAMA,
                        COUNT( A.NRK ) JUMLAHTOTAL 
                    FROM
                        PERS_DUK_PANGKAT_HISTDUK A LEFT JOIN PERS_TABEL_SPMU C ON A.SPMU = C.KODE_SPM 
                    WHERE
                        A.THBL = '".$thbl."' 
                        AND TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ) IN ( TO_CHAR( SYSDATE, 'YYYY' ) + 1 ) 
                    GROUP BY
                        TO_CHAR( A.TMTPENSIUNYAD, 'YYYY' ),
                        A.THBL,
                        A.SPMU,
                        C.NAMA 
                    ) D 
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            // echo $sql;
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND A.RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY ".$columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
        
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
            // $nestedData[] = $row->NAMA;
            $nestedData[] = "<div class='pull-left'><a href='".site_url('detpegawai/pensiun_skpd_next/'.$row->SPMU."/".$row->TH_NEXT."/".$thbl)."' target='_blank'>".$row->NAMA."</a></div>"; 
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
