<?php 

 class Mlisting extends CI_Model {

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
        //$this->prod = $this->ci->load->database('ORP1', TRUE);
        //$this->db = $this->ci->load->database('29', TRUE);
    } 

    public function getTahunBerkalaDiskes($thbl="")
    {
        $sql="SELECT DISTINCT(THBL) THBL FROM PERS_DUK_PANGKAT_HISTDUK WHERE SPMU IN('C030','C031') AND SUBSTR(THBL,0,2)='20' AND SUBSTR(THBL,5,2) IN('01','02','03','04','05','06','07','08','09','10','11','12') ORDER BY THBL DESC";

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

    public function getTahunBerkalaDisdik($thbl="")
    {
        $sql="SELECT DISTINCT(THBL) THBL FROM PERS_DUK_PANGKAT_HISTDUK WHERE SPMU IN('C040','C041') AND SUBSTR(THBL,0,2)='20' AND SUBSTR(THBL,5,2) IN('01','02','03','04','05','06','07','08','09','10','11','12') ORDER BY THBL DESC";

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

    //untuk rekap gaji
    public function getTahunBerkalaHistduk($thbl="")
    {
        $sql="SELECT DISTINCT(THBL) THBL FROM PERS_DUK_PANGKAT_HISTDUK WHERE SUBSTR(THBL,0,2)='20' AND SUBSTR(THBL,5,2) IN('01','02','03','04','05','06','07','08','09','10','11','12') ORDER BY THBL DESC";

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
    //untuk rekap gaji
    public function getSpmuFromHistduk($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (SELECT DISTINCT(SPMU) SPMU FROM PERS_DUK_PANGKAT_HISTDUK A WHERE THBL='".$thbl."' ORDER BY SPMU ASC) BKL
            INNER JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value=''>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }


    //untuk tkd guru 108
    public function getTHBLProsesTKDGuru($thbl="")
    {
        /*$sql="SELECT DISTINCT (THBL) THBL FROM PROSES_TKD_GURU
                WHERE SUBSTR (THBL, 0, 2) = '20' AND SUBSTR (THBL, 5, 2) IN ('01','02','03','04','05','06','07','08','09','10','11','12','13','14')
                ORDER BY THBL DESC";*/
        $sql = "SELECT DISTINCT (THBL) THBL FROM PROSES_TKD_GURU
                WHERE THBL IN ('201605','201606','201607','201608','201609','201610','201611','201612')ORDER BY THBL DESC";

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

    //untuk tkdguru108 dan tkd22
    public function getSpmuFromTKDGuru($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (SELECT DISTINCT(SPMU) SPMU FROM PROSES_TKD_GURU A WHERE THBL='".$thbl."' ORDER BY SPMU ASC) BKL
            INNER JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value=''>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }

    //untuk tkd guru 22
    public function getTHBLProsesTKDGuru22($thbl="")
    {
        
        $sql = "SELECT DISTINCT (THBL) THBL FROM PROSES_TKD_GURU
                WHERE THBL >= '201703' AND  SUBSTR(THBL,5,2) NOT IN ('15') ORDER BY THBL DESC";

        $query = $this->db ->query($sql);        

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

    //untuk tkd nonguru108
    public function getTHBLProsesTKDNonGuru108($thbl="")
    {
        
        $sql = "SELECT DISTINCT (THBL) THBL FROM PROSES_TKD_TAHAP2
                WHERE THBL >= '201603' AND  SUBSTR(THBL,5,2) IN ('01','02','03','04','05','06','07','08','09','10','11','12','13') ORDER BY THBL DESC";

        $query = $this->db ->query($sql);        

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

    //untuk tkdnonguru108
    public function getSpmuFromTKDNonGuru108($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (SELECT DISTINCT(SPMU) SPMU FROM PROSES_TKD_TAHAP2 A WHERE THBL='".$thbl."' ORDER BY SPMU ASC) BKL
            INNER JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value=''>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }

    //untuk listing pph
    public function getTHBLListingPPH($thbl="")
    {
        
        $sql = "SELECT DISTINCT (THBL) THBL FROM PERS_DUK_PANGKAT_HIST_PPH ORDER BY THBL DESC";

        $query = $this->db ->query($sql);        

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

    //untuk listing pph
    public function getSpmuFromListingPPH($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (SELECT DISTINCT(SPMU) SPMU FROM PERS_DUK_PANGKAT_HIST_PPH A WHERE THBL='".$thbl."' ORDER BY SPMU ASC) BKL
            INNER JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value=''>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }

    //untuk listing transport
    public function getTHBLListingTransport($thbl="")
    {
        
        $sql = "SELECT DISTINCT (THBL) THBL FROM PERS_DUK_PANGKAT_TRANSPORT 
                WHERE SUBSTR(THBL,5,2) IN ('01','02','03','04','05','06','07','08','09','10','11','12','13') and UPLOAD IN('1')
                ORDER BY THBL DESC";

        $query = $this->db ->query($sql);        

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

    //untuk listing transport
    public function getSpmuFromListingTransport($thbl)
    {
        
        $sql="SELECT BKL.SPMU,B.NAMA FROM 
                (SELECT DISTINCT(SPMU) SPMU FROM PERS_DUK_PANGKAT_TRANSPORT A WHERE THBL='".$thbl."' ORDER BY SPMU ASC) BKL
            INNER JOIN PERS_TABEL_SPMU B ON BKL.SPMU = B.KODE_SPM ORDER BY BKL.SPMU ASC
            ";

        $query = $this->db->query($sql);        

        $option  = "";
        $option .= "<option selected value=''>-</option>"; 
        foreach($query->result() as $row){
                     
                $option .= "<option value='".$row->SPMU."'>".$row->SPMU." - ".$row->NAMA."</option>";
            
        }
        
        return $option;       
    }

    function queryBatchingGajiPerPegawai($nrk,$thbl)
    {
        $sql=   "SELECT
                (   CASE SUBSTR (A.THBL, 5, 2)
                    WHEN '01' THEN
                        'JANUARI'
                    WHEN '02' THEN
                        'FEBRUARI'
                    WHEN '03' THEN
                        'MARET'
                    WHEN '04' THEN
                        'APRIL'
                    WHEN '05' THEN
                        'MEI'
                    WHEN '06' THEN
                        'JUNI'
                    WHEN '07' THEN
                        'JULI'
                    WHEN '08' THEN
                        'AGUSTUS'
                    WHEN '09' THEN
                        'SEPTEMBER'
                    WHEN '10' THEN
                        'OKTOBER'
                    WHEN '11' THEN
                        'NOVEMBER'
                    WHEN '12' THEN
                        'DESEMBER'
                    END
                ) AS BULAN,A.THBL,
                SUBSTR (A.THBL, 1, 4) AS TAHUN,A.KLOGAD,C.NALOKL AS NAKLOGAD,A .SPMU AS SPMU,B.NAMA NAMASPM,A .NAMA AS NAMA_PEG,TO_CHAR (A.TALHIR, 'DD-MM-YYYY') AS TALHIR,A.NIP18,A.NRK,
                CASE WHEN STAPEG = 1 THEN 'CPNS' ELSE 'PNS' END AS STAPEG,
                A.KOJAB,E.GOL,E.NAPANG,
                CASE WHEN STAWIN IN (1, 2, 3, 4) THEN 1 ELSE 0 END AS STAWIN,
                JUAN, JIWA, GAPOK, NTISTRI, NTANAK, NTUNLAI, TUNJAB, TUNFUNG, NPBULAT, NTBERAS, NTPPHGAJI, NJUMKOT, NPBERAS, NTASPEN, NTHT, NASKES,
                NVL (NTASPEN, 0) + NVL (NTHT, 0) + NVL (NASKES, 0) AS IURANWJB,
                    NPPHGAJI, NPTLAIN, NJUMPOTGAJI, NJUMBERGAJI
                FROM
                    PERS_DUK_PANGKAT_HISTDUK A
                LEFT JOIN pers_tabel_spmu B ON A .SPMU = B.KODE_SPM
                LEFT JOIN pers_lokasi_tbl C ON A .KLOGAD = C.KOLOK AND A .KOLOK = C.KOLOK
                LEFT JOIN PERS_ESELON_TBL D ON NVL (A .ESELON, '  ') = D .ESELON
                LEFT JOIN PERS_PANGKAT_TBL_NOW E ON A .GOL = E .KOPANG
                --LEFT JOIN pers_lokasi_tbl F ON A .KOLOK = C.KOLOK
                WHERE
                    THBL = '".$thbl."' AND NRK = '".$nrk."'
                ORDER BY spmu, klogad ASC, stapeg DESC, D .CETAKAN, gol DESC, A .KODIKF, nrk ASC";

        $result = $this->db->query($sql)->row();
        return $result;
    }
}

?>
