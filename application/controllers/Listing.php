<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller {  

    private $user=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));      
        $this->load->library('session');
        
        $this->load->model('mlisting','listing');
        
        $this->load->library('infopegawai');
        $this->load->library('convert');

        if ($this->session->userdata('logged_in')) {            

            $session_data       = $this->session->userdata('logged_in');
            $this->user['id']       = $session_data['id'];
            $this->user['username']     = $session_data['username'];
            $this->user['user_group']     = $session_data['user_group'];
        }else{
            // redirect(base_url().'index.php/login', 'refresh');
            redirect(base_url().'login', 'refresh');
        }       
    }

    public function index()
    {  
            
	    // START GET NRK                
	        if(isset($_POST['nrk'])){
	            $nrk = $_POST['nrk'];
	        }elseif(isset($_POST['nrkP'])){ //Pencarian NRK Untuk Admin/BKD
	            $nrk = $_POST['nrkP'];                    
	        }else{
	            $nrk = $this->user['id'];
	            
	            if($this->user['user_group'] > 1){
	                $nrk = "";

	            }

	        }                                            
	    
	        $datam['activeMenu'] = "16247";
	        $datam['activemn']=$this->infopegawai->initialMenu($this->user['user_group'],'listing',0);
	        

	    $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
	   
	   
	    $datam['nrk'] = $nrk;
	   


	    $this->load->view('head/header',$this->user);
	    $this->load->view('head/menu',$datam);
	    $this->load->view('v_index_listing',$data);
	    //$this->load->view('admin/pegawai_list',$data);
	    $this->load->view('head/footer');

    }

    public function indexgaji()
    {  
    	//jumlah thbl diskes dan disdik sama jadi menggunakan 1 saja
        $data['thbldiskesdik'] = $this->listing->getTahunBerkalaDiskes();
        //$data['thbldisdik'] = $this->listing->getTahunBerkalaDisdik();

        //untuk rekap gaji,rptgajiSPM
        $data['thblrekgaji'] = $this->listing->getTahunBerkalaHistduk();
        $thblp="";
        $spmp="";
        $data['spmrekgaji'] = $this->listing->getSpmuFromHistduk($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_gaji',$data);
    }

    public function indextkdguru108()
    {  
        $data['thbltkdguru108'] = $this->listing->getTHBLProsesTKDGuru();
        $thblp="";
        $spmp="";
        $data['spmtkdguru'] = $this->listing->getSpmuFromTKDGuru($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_tkdguru108',$data);
    }

    public function indextkdguru22()
    {  
        $data['thbltkdguru22'] = $this->listing->getTHBLProsesTKDGuru22();
        $thblp="";
        $spmp="";
        $data['spmtkdguru'] = $this->listing->getSpmuFromTKDGuru($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_tkdguru22',$data);
    }

    public function indextkdnonguru108()
    {  
        $data['thbltkdnonguru108'] = $this->listing->getTHBLProsesTKDNonGuru108();
        $thblp="";
        $spmp="";
        $data['spmtkdnonguru108'] = $this->listing->getSpmuFromTKDNonGuru108($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_tkdnonguru108',$data);
    }

    public function indexlistingpph()
    {  
        $data['thbllistingpph'] = $this->listing->getTHBLListingPPH();
        $thblp="";
        $spmp="";
        $data['spmlistingpph'] = $this->listing->getSpmuFromListingPPH($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_pph',$data);
    }

    public function indexlistingtransport()
    {  
        $data['thbllistingtransport'] = $this->listing->getTHBLListingTransport();
        $thblp="";
        $spmp="";
        $data['spmlistingtransport'] = $this->listing->getSpmuFromListingTransport($thblp,$spmp);

        $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
       
 
        $this->load->view('v_listing_transport',$data);
    }

    public function getSpmuFromHistdukRekGaji()
    {

        $thbl = $this->input->post('thbl');


        $list = $this->listing->getSpmuFromHistduk($thbl);
        
        $arr = array('response' => 'SUKSES', 'list' => $list);
        echo json_encode($arr);
    }

    public function getSpmuFromTKDGuru108()
    {

        $thbl = $this->input->post('thbl');


        $list = $this->listing->getSpmuFromTKDGuru($thbl);
        
        $arr = array('response' => 'SUKSES', 'list' => $list);
        echo json_encode($arr);
    }

    public function getSpmuFromTKDNonGuru108()
    {

        $thbl = $this->input->post('thbl');


        $list = $this->listing->getSpmuFromTKDNonGuru108($thbl);
        
        $arr = array('response' => 'SUKSES', 'list' => $list);
        echo json_encode($arr);
    }

    public function getSpmuFromPPH()
    {

        $thbl = $this->input->post('thbl');


        $list = $this->listing->getSpmuFromListingPPH($thbl);
        
        $arr = array('response' => 'SUKSES', 'list' => $list);
        echo json_encode($arr);
    }

    public function getSpmuFromTransport()
    {

        $thbl = $this->input->post('thbl');


        $list = $this->listing->getSpmuFromListingTransport($thbl);
        
        $arr = array('response' => 'SUKSES', 'list' => $list);
        echo json_encode($arr);
    }

    function cetakDiskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://localhost:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "GajiSPMDiskes.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "GAJI_DINAS_KESEHATAN.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakDisdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "GajiSPMDikdas.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "GAJI_DINAS_PENDIDIKAN.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakRekapGaji($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapgaji.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pTahun", substr($thbl,0,4));
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pSPMU", $spmu);
        
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "GAJI_DINAS_PENDIDIKAN.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    public function cetak_rptgaji_spmu($thbl){
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

       	/*echo $bln; die();*/
        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
        // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");

        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath . "rptGajiSPM.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
      
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pSPMU", $spmu);

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);
        
        $filename = "rptGajiSPM.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;
        
            
        

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP 1.1
            header("Pragma: no-cache"); //HTTP 1.0
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            
            // }

        } else {
            echo "Create PDF gagal.";
        }

        /*"http://pegawai.jakarta.go.id/validasi/cetak_rptgaji_spmu/201703/c030"*/
    }

    public function cetak_rptGajiSPMGab($thbl){
    	$hasilbulan = $this->convertBulan($thbl);

       	/*echo "lDl"; die();*/
        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
        // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");

        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath . "rptGajiSPMGab.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);
        
        $filename = "rptGajiSPMGab.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;
        
            
        

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP 1.1
            header("Pragma: no-cache"); //HTTP 1.0
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            
            // }

        } else {
            echo "Create PDF gagal.";
        }

        /*http://pegawai.jakarta.go.id/validasi/cetak_rptGajiSPMGab/201703*/
    }

    public function convertThbl($param){
        $tahun = substr($param, 0,4);
        $bulan = substr($param, 4,2);

        if($bulan=='01'){
            $blnT="Jan ".$tahun;
        }elseif ($bulan=='02') {
            $blnT="Feb ".$tahun;
        }elseif ($bulan=='03') {
            $blnT="Mar ".$tahun;
        }elseif ($bulan=='04') {
            $blnT="Apr ".$tahun;
        }elseif ($bulan=='05') {
            $blnT="May ".$tahun;
        }elseif ($bulan=='06') {
            $blnT="Jun ".$tahun;
        }elseif ($bulan=='07') {
            $blnT="Jul ".$tahun;
        }elseif ($bulan=='08') {
            $blnT="Aug ".$tahun;
        }elseif ($bulan=='09') {
            $blnT="Sep ".$tahun;
        }elseif ($bulan=='10') {
            $blnT="Oct ".$tahun;
        }elseif ($bulan=='11') {
            $blnT="Nov ".$tahun;
        }elseif ($bulan=='12') {
            $blnT="Dec ".$tahun;
        }else{
            $blnT = "";
        }

        return $blnT;
    }

    public function convertBulan($param){
        
        $bulan = substr($param, 4,2);

        if($bulan=='01'){
            $blnT="JANUARI";
        }elseif ($bulan=='02') {
            $blnT="FEBRUARI";
        }elseif ($bulan=='03') {
            $blnT="MARET";
        }elseif ($bulan=='04') {
            $blnT="APRIL";
        }elseif ($bulan=='05') {
            $blnT="MEI";
        }elseif ($bulan=='06') {
            $blnT="JUNI";
        }elseif ($bulan=='07') {
            $blnT="JULI";
        }elseif ($bulan=='08') {
            $blnT="AGUSTUS";
        }elseif ($bulan=='09') {
            $blnT="SEPTEMBER";
        }elseif ($bulan=='10') {
            $blnT="OKTOBER";
        }elseif ($bulan=='11') {
            $blnT="NOVEMBER";
        }elseif ($bulan=='12') {
            $blnT="DESEMBER";
        }elseif ($bulan=='13') {
            $blnT="TKD KE 13";
        }elseif ($bulan=='14') {
            $blnT="TKD KE 14";
        }else{
            $blnT = "";
        }

        return $blnT;
    }

    function cetaklistingtkdguru108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        $http =  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        echo $http."---- ";
        $http2 = $http."://10.15.34.34:8080/JavaBridge/java/Java.inc";
        echo $http2;exit();


        // require "10.15.34.34:8080/JavaBridge/java/Java.inc";

        require "http://10.15.34.31:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "http://10.15.34.34/public/report/";
        // echo $folderPath; exit();
        // $folderPath = base_url()."/public/report/";
        // echo $folderPath. "LISTING_TKD_GURU_DISDIK 108.jrxml";exit();

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_DISDIK_108.jrxml");
        // echo $report;exit();

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdgurugab108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:http://10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_GAB 108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU GAB 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdguruspmu108($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_SPMU 108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU SPMU 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }
 	
 	function cetakrekaptkdgurudisdik108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_DISDIK 108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pBulannama", $hasilbulan);
        $params->put("pTHBL", $thbl);
        

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU DISDIK 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdgurugab108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_GAB 108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pBulannama", $hasilbulan);
        $params->put("pTHBL", $thbl);
        

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU GAB 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdguruspmu108($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_SPMU 108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU SPMU 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdguru22($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        // require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";
        require "http://10.15.34.32:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        // echo $folderPath;exit();

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_22_DISDIK.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdgurugab22($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_22_GAB.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU GAB 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdguruspmu22($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_GURU_22_SPMU.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD GURU SPMU 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdgurudisdik22($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_22_DISDIK.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pBulannama", $hasilbulan);
        $params->put("pTHBL", $thbl);
        

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU DISDIK 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdgurugab22($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_22_GAB.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pBulannama", $hasilbulan);
        $params->put("pTHBL", $thbl);
        

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU GAB 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdguruspmu22($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_GURU_22_SPMU.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD GURU SPMU 22.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdtahap2diskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        // require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";
        require "http://localhost:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_TAHAP2_DINKES_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD TAHAP2 DINKES 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdtahap2diskes_new($thbl) {
        $hasilbulan = $this->convertBulan($thbl);
        require "http://localhost:8080/JavaBridge/java/Java.inc";
        // require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');
        $class = new JavaClass("java.lang.Class");
        $class->forName("oracle.jdbc.driver.OracleDriver");
        $driverManager = new JavaClass("java.sql.DriverManager");
        //DB Dev
        // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.60:1521/asetdev", "aset", "aset");
        // DB Prods
        //$conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.27:1521/ASET", "aset", "asetaset");
        // DB COBA
        // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.60:1521/asetdev", "asetcoba", "123456");
         //DB Asetedev2
        // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.60:1521/asetdev", "asetdev2", "asetdev2");
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");

        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";
        // $report = $compileManager->compileReport($folderPath . "laporanKIBA.jrxml");
        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_TAHAP2_DINKES_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);

        

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
            $pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
        }

        else if ($thbl>='201605'  && $thbl !='201613')
        {
            $pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
        }

        else if ($thbl >='201701')
        {
            $pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
        }

        else if ($thbl >='201702')
        {
            $pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
        }
        
        else if ($thbl >='201703')
        {
            $pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
        }

        $params->put("pPERGUB", $pPERGUB);

        // print_r($params);die;

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

		$runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

		$jasperPrint = $fillManager->fillReport($report, $params, $conn);

		$filename = "LISTING TKD TAHAP2 DINKES 108.pdf";
		// die($filename);
		$outputPath = realpath(".") . "/assets/pdf/" . $filename;

		$exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

		$exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
		$exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

		$exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

		$exporter->exportReport();


		if (file_exists($outputPath)) {
			header('Content-Type: application/pdf');
			header('Content-Disposition: inline; filename=' . $filename);
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');

			readfile($outputPath);
			//unlink($outputPath);
			// }

		} else {
			echo "Create PDF gagal.";
		}

    }


    function cetaklistingtkdtahap2disdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_TAHAP2_DISDIK_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD TAHAP2 DISDIK 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdtahap2($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_TAHAP2_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD TAHAP2 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaklistingtkdtahap2gab($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "LISTING_TKD_TAHAP2_GAB_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "LISTING TKD TAHAP2 GAB 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdtahap2diskes108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_TAHAP2_DINKES_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD TAHAP2 DINKES 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdtahap2disdik108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_TAHAP2_DISDIK_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD TAHAP2 DISDIK 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdtahap2108($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_TAHAP2_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD TAHAP2 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptkdtahap2gab108($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "REKAP_TKD_TAHAP2_GAB_108.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        
        $params->put("pBulannama", $hasilbulan);

        $pPERGUB="";
        if ($thbl>='201310' && $thbl !='201313')
        {
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 207 / 2014";
    	}

		else if ($thbl>='201605'  && $thbl !='201613')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 108 TAHUN 2016";
    	}

		else if ($thbl >='201701')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN INSTRUKSI GUBERNUR NO. 171 TAHUN 2016";
		}

		else if ($thbl >='201702')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 409 TAHUN 2016";
    	}
		
		else if ($thbl >='201703')
		{
        	$pPERGUB="DAFTAR PEMBAYARAN TUNJANGAN KINERJA DAERAH BERDASARKAN PERATURAN GUBERNUR NO. 22 TAHUN 2017";
    	}

        $params->put("pPERGUB", $pPERGUB);
        
       
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TKD TAHAP2 GAB 108.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }


    function cetakpphdiskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "dkis1mp3gn3w");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptSPMDinkes_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");

        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "Dinkes pph15.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakpphdisdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptSPMDisdik_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");

        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "Disdik PPH15.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakpphspm($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptSPM_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");
        
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "SPM PPH15.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakpphgab($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptSPMGab_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");

        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "GAB PPH15.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekappphdiskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapSPMDinkes_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");


        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP PPH15 DINKES.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekappphdisdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapSPMDisdik_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP PPH15 DISDIK.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekappphspm($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapSPM_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP PPH SPM.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekappphgab($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapSPMGab_pph15.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        $params->put("pKETERANGAN", "");


        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP PPH15 GAB.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }
   

   function cetaktransportdiskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptTransportDINKES.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        

        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "Dinkes transport.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaktransportdisdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptTransportDISDIK.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        

        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "Disdik Transport.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaktransportspm($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptTransportSPM.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);
        
        
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "SPM Transport.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetaktransportgab($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rptTransportSPMGab.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
       

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "Gab Transport.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptransportdiskes($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapTransportDinkes.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        


        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TRANSPORT DINKES.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptransportdisdik($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapTransportDISDIK.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TRANSPORT DISDIK.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptransportspm($thbl) {
        $spmu = $this->uri->segment(4, 0);
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapTransportSPM.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pSPMU", $spmu);
        $params->put("pBulannama", $hasilbulan);
        

        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TRANSPORT SPM.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    function cetakrekaptransportgab($thbl) {
        
        $hasilbulan = $this->convertBulan($thbl);

        
        require "http://10.15.34.34:8080/JavaBridge/java/Java.inc";

        $system = new Java('java.lang.System');

        $class = new JavaClass("java.lang.Class");

        $class->forName("oracle.jdbc.driver.OracleDriver");

        $driverManager = new JavaClass("java.sql.DriverManager");

        
        $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.29:1521/SIMPEG", "simpeg", "p102simp");
       // $conn = $driverManager->getConnection("jdbc:oracle:thin:@//10.15.34.61:1521/simpegdev", "simpegnew", "simpegnew");
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");

        // <*untuk menghilangkan Undefined property: java_Client::$cancelProxyCreationTag
        $compileManager->__client->cancelProxyCreationTag = 0;
        // *>
        $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        $folderPath = realpath(".") . "/public/report/";

        $report = $compileManager->compileReport($folderPath. "rekapTransportgab.jrxml");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $params = new Java("java.util.HashMap");
        $params->put("pBarcode", "");
        $params->put("pTHBL", $thbl);
        $params->put("pBulannama", $hasilbulan);
        


        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $runmanager = new Java("net.sf.jasperreports.engine.JasperRunManager");

        
        $jasperPrint = $fillManager->fillReport($report, $params,$conn);
        
        $filename = "REKAP TRANSPORT GAB.pdf";
        $outputPath = realpath(".") . "/assets/pdf/" . $filename;

        $exporter = new Java("net.sf.jasperreports.engine.export.JRPdfExporter");

        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        $exporter->exportReport();

        // $path = './path/to/file.pdf';

        if (file_exists($outputPath)) {
            // echo "Create PDF berhasil." . $outputPath;
            // if ($dwl == 1) {
            //  $this->load->helper('download');
            //  force_download($outputPath, NULL);
            // } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            readfile($outputPath);
            //unlink($outputPath);
            // }

        } else {
            echo "Create PDF gagal.";
        }

    }

    public function cetakSlipGaji($thbl,$nrk)
    {

            $this->toPdf($nrk,$thbl);
    }

    public function toPdf($nrkparam,$thbl)
    {
       
        $this->load->library('pdf_gaji');
        

            if(isset($_POST['nrk'])){
                    $nrk = $_POST['nrk'];
                }elseif(isset($_POST['nrkP'])){ //Pencarian NRK Untuk Admin/BKD
                    $nrk = $_POST['nrkP'];                    
                }else{
                    $nrk = $this->user['id'];
                    
                    if($this->user['user_group'] > 1){
                        $nrk = "";
                    }
                }

            /*if(isset($_POST['nrk']))
            {
                $nrkparam = $_POST['nrk'];
            }
            else
            {
                $nrkparam="";
            }

            if(isset($_POST['res']))
            {
                $thbl = $_POST['res'];
            }
            else
            {
                $thbl="";
            }
*/

          
        
            $data['nrk'] = $nrk;
            $datam['nrk'] = $nrk;
            $datam['user_group'] = $this->user['user_group'];
            $data['user_id'] = $this->user['id'];
            $data['user_group'] = $this->user['user_group'];
            

            $infoGaji = $this->listing->queryBatchingGajiPerPegawai($nrkparam,$thbl);

            $data['infoGaji'] = $infoGaji;
                
            ob_start();

          
           $this->pdf_gaji->SetTitle(''.$infoGaji->NRK.' '.$infoGaji->BULAN.' '.$infoGaji->TAHUN); 
           // definisikan judul dokumen


            $this->pdf_gaji->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
            // set header and footer fonts
            $this->pdf_gaji->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->pdf_gaji->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $this->pdf_gaji->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $this->pdf_gaji->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $this->pdf_gaji->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->pdf_gaji->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $this->pdf_gaji->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $this->pdf_gaji->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf_gaji->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $this->pdf_gaji->SetFont('helvetica', '', 8);

            // add a page
            $this->pdf_gaji->AddPage();

           $this->pdf_gaji->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);
           
           

            $html = '<html>
    <head>
        <title></title>
    </head>
    <body>
        <h3 align="center">DAFTAR GAJI DSB UNTUK PARA PEGAWAI (PNS DAERAH)</h3>
        <table border="0" cellpadding="1" cellspacing="1" width="40%">
            <tbody>
                <tr>
                    <td width="20%"><strong>BULAN:</strong></td>
                    <td width="30%"><strong>'.$infoGaji->BULAN.'</strong></td>
                    <td width="20%"><strong>TAHUN:</strong></td>
                    <td width="30%"><strong>'.$infoGaji->TAHUN.'</strong></td>
                </tr>
                <tr>
                    <td><strong>SKPD:</strong></td>
                    <td colspan="3" rowspan="1"><strong>'.$infoGaji->NAMASPM.'</strong></td>
                </tr>
                <tr>
                    <td><strong>UKPD:</strong></td>
                    <td colspan="3" rowspan="1"><strong>'.$infoGaji->NAKLOGAD.'</strong></td>
                </tr>
            </tbody>
        </table>
        <table border="1" cellpadding="1" cellspacing="1" width="100%">
            <tbody>
                <tr>
                    <td colspan="1" rowspan="4" width="3%">
                        <p style="text-align: center;"><strong>No</strong></p>
                    </td>
                    <td colspan="1" rowspan="4" width="20%">
                        
                        <strong> &nbsp; NAMA PEGAWAI</strong><br/>
                        <strong> &nbsp; TANGGAL LAHIR</strong><br/>
                        <strong> &nbsp; NIP / NRK</strong><br/>
                        <strong> &nbsp; STAPEG / KOJAB / GOL</strong>
                        
                        
                    </td>
                    <td colspan="1" rowspan="4" width="7%" align="center">
                        
                            <strong> STAWIN</strong><br/>
                            <strong> JIWA</strong><br/>
                            <strong> JUAN</strong>
                        
                        
                    </td>
                    <td colspan="4" rowspan="1" style="text-align: center;"><strong>PENGHASILAN</strong></td>
                    <td colspan="2" rowspan="1" style="text-align: center;"><strong>POTONGAN</strong></td>
                    <td colspan="1" rowspan="4" style="text-align: center;"><strong>HASBER</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center;"><strong>GAPOK<br/>TUNRI<br/>TUNAK</strong></td>
                    <td rowspan="3" style="text-align: center;"><strong>T.J.U<br/>TPP<br/>JUMLAH</strong></td>
                    <td rowspan="3" style="text-align: center;"><strong>TUNJAB<br/>TUNFUNG<br/>BULAT</strong></td>
                    <td rowspan="3" style="text-align: center;"><strong>TUNRAS<br/>TUNPPH<br/>JUMKOT</strong></td>
                    <td rowspan="3" style="text-align: center;"><strong>POTRAS<br/>IURAN WAJIB<br/>POTPPH</strong></td>
                    <td rowspan="3" style="text-align: center;"><strong>POTLAIN<br/>TABPERUM<br/>JUMPOT</strong></td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td rowspan="4" align="center">1</td>
                    <td rowspan="4">&nbsp;'.$infoGaji->NAMA_PEG.'<br/>&nbsp;'.$infoGaji->TALHIR.'<br/>&nbsp;'.$infoGaji->NIP18.' / '.$infoGaji->NRK.'<br/>&nbsp;'.$infoGaji->STAPEG.' / '.$infoGaji->KOJAB.' / '.$infoGaji->GOL.'</td>
                    <td rowspan="4" align="center">&nbsp;<br/>&nbsp;'.$infoGaji->STAWIN.'<br/>&nbsp;'.$infoGaji->JIWA.'<br/>&nbsp;'.$infoGaji->JUAN.'</td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;'.number_format($infoGaji->GAPOK, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTISTRI, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTANAK, 0, ',', '.').'</td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;'.number_format($infoGaji->NTUNLAI, 0, ',', '.').'<br/>&nbsp;0<br/>&nbsp;'.number_format($infoGaji->NTUNLAI, 0, ',', '.').'</td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;'.number_format($infoGaji->TUNJAB, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->TUNFUNG, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NPBULAT, 0, ',', '.').'</td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;'.number_format($infoGaji->NTBERAS, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTPPHGAJI, 0, ',', '.').'<br/>&nbsp;<strong>'.number_format($infoGaji->NJUMKOT, 0, ',', '.').'</strong></td>
                   <td rowspan="4" align="right">&nbsp;<br/>&nbsp;'.number_format($infoGaji->NPBERAS, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->IURANWJB, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NPPHGAJI, 0, ',', '.').'</td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;0<br/>&nbsp;'.number_format($infoGaji->NPTLAIN, 0, ',', '.').'<br/>&nbsp;<strong>'.number_format($infoGaji->NJUMPOTGAJI, 0, ',', '.').'</strong></td>
                    <td rowspan="4" align="right">&nbsp;<br/>&nbsp;<br/>&nbsp;<strong>'.number_format($infoGaji->NJUMBERGAJI, 0, ',', '.').'</strong></td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr rowspan="3">
                    <td colspan="3"  style="text-align: center;">
                        TOTAL</td>
                    <td  align="right">&nbsp; <strong>'.number_format($infoGaji->GAPOK, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTISTRI, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTANAK, 0, ',', '.').' </strong></td>
                    <td  align="right">&nbsp; <strong>'.number_format($infoGaji->NTUNLAI, 0, ',', '.').'<br/>&nbsp;0<br/>&nbsp;'.number_format($infoGaji->NTUNLAI, 0, ',', '.').' </strong></td>
                    <td  align="right">&nbsp; <strong>'.number_format($infoGaji->TUNJAB, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->TUNFUNG, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->npbulat, 0, ',', '.').' </strong></td>
                    <td  align="right">&nbsp; <strong>'.number_format($infoGaji->NTBERAS, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NTPPHGAJI, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NJUMKOT, 0, ',', '.').' </strong></td>
                   <td  align="right">&nbsp; <strong>'.number_format($infoGaji->NPBERAS, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->IURANWJB, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NPPHGAJI, 0, ',', '.').' </strong></td>
                   <td  align="right">&nbsp; <strong>0<br/>&nbsp;'.number_format($infoGaji->NPTLAIN, 0, ',', '.').'<br/>&nbsp;'.number_format($infoGaji->NJUMPOTGAJI, 0, ',', '.').' </strong></td>
                    
                   
                  
                    <td   align="right">&nbsp;<br/>&nbsp;<strong> '.number_format($infoGaji->NJUMBERGAJI, 0, ',', '.').'</strong></td>
                </tr>
                
            </tbody>
        </table>
        <br/>
        <br/>
        <table width="100%" >
            <tr>
                <td width="60%"></td>
                <td>
                     <table  cellpadding="1" cellspacing="1" style="width: 50%; margin-left:50%; align:right; ">
            <tbody>
                <tr>
                    <td style="text-align: center;"><strong>JAKARTA, ___________________</strong></td>
                    
                </tr>
                <tr>
                    <td style="text-align: center;">PEMBUAT DAFTAR GAJI</td>
                </tr>
                <tr>
                    <td >&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;</td>
                </tr>
                <tr>
                    <td  style="text-align: center;">
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
                </tr>
            </tbody>
        </table>
                </td>
            </tr>
        </table>
       
        
        <p>
            &nbsp;</p>
    </body>
</html>
';
            $url = 'https://pegawai.jakarta.go.id/validasi/qr_gajipegawai?nrk='.$nrkparam.'&thbl='.$thbl;
            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
          
                        
            $this->pdf_gaji->writeHTML($html, true, false, true, false, '');
              $this->pdf_gaji->write2DBarcode($url, 'QRCODE,H', 20, 110, 20, 20, $style, 'N');
           // $this->pdf_gaji->Text(20, 205, 'QRCODE H');
             ob_clean();          
            
            $this->pdf_gaji->Output('gaji.pdf', 'I');

    }

/*START UPLOAD PHOTO*/
    public function upload_file(){

        if(isset($_POST['nrk'])){
            $nrk = $_POST['nrk'];
        }else{
            $nrk = "empty";
        }

        $config = array(
            'upload_path' => 'assets/img/photo/',
            'allowed_types' => 'jpeg|jpg|png',
            'file_name' => ''.$nrk.'.jpg',
            'file_ext_tolower' => TRUE,
            'overwrite' => TRUE,
            'max_size' => 1024,
            // 'max_width' => 1024,
            // 'max_height' => 768,           
            // 'min_width' => 10,
            // 'min_height' => 7,     
            'max_filename' => 0,
            'remove_spaces' => TRUE
        );
 
        $this->load->library('upload', $config);        
 
        if ( ! $this->upload->do_upload())
        {
            $hasil = $this->upload->display_errors();            
        }
        else
        {
            $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 85; //40
            $config['height'] = 85; //40

            $this->load->library('image_lib', $config);

            if ( ! $this->image_lib->resize()){                
                $result = $this->image_lib->display_errors('', '');
            }else{
                $result = 'SUKSES';
            }

            // $hasil = $this->upload->data();
            $hasil = array('result' => $result);
        }

        echo json_encode($hasil);
    }
/*END UPLOAD PHOTO*/

    public function gantiPassword()
    {
         
        $insert = $this->home->save_userData($this->user['id']);
        
        if($insert){
            echo json_encode(array("response" => 'SUKSES', 'act' => "add"));
        }else{
            echo json_encode(array("response" => 'GAGAL', 'act' => "add"));
        }
    }


    public function updateKolokJab()
    {
        $this->home->updateKolokKojab();
    }

    function tampilPhoto($nrk=''){
        // Now query back the uploaded BLOB and display it
        $rs=$this->mdl->get_data($nrk)->row();
        $result = $rs->X_PHOTO->load();

        header("Content-type: image/JPEG");
        echo $result;
    }

}
