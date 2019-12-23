<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper(array('form', 'url'));    	
    	$this->load->library('session');
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','vpeg');
        $this->load->model('Model_public');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->db2 = $this->load->database('DBfile', TRUE);

        if ($this->session->userdata('logged_in')) {            

            $session_data       = $this->session->userdata('logged_in');
            $this->user['id']     	= $session_data['id'];
            $this->user['username']  	= $session_data['username'];
            $this->user['user_group']     = $session_data['user_group'];
        }else{
			// redirect(base_url().'login/logout', 'refresh');
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
                                                       
            // END GET NRK
		// START Inisial Active Menu
            // $datam['li']=$this->home->showMenu();                
            // $datam['activeMenu'] = "270";
            $datam['activemn']=$this->infopegawai->initialMenu($this->user['user_group'],'profile',0);
        // END Inisial Active Menu

            $data['nrk']        = $nrk;
            $datam['nrk']       = $nrk;
            $datam['user_group'] = $this->user['user_group'];
            $data['user_id'] = $this->user['id'];
            $data['user_group'] = $this->user['user_group'];
            
            $infoUser = $this->home->getUserInfo2($nrk);
            $data['infoUser'] = $infoUser;

            $infoUser3 = $this->home->getuserInfo3($nrk);
            $data['infoUser3'] = $infoUser3;

            $infoPenForm = $this->home->getUserInfoPendFormal($nrk);
            $data['infoPenForm'] = $infoPenForm;

            $infoPenNForm = $this->home->getUserInfoPendNonFormal($nrk);
            $data['infoPenNForm'] = $infoPenNForm;

            $infoAlamat = $this->home->getUserInfoAlamat($nrk);
            $data['infoAlamat'] = $infoAlamat;  

            $infoHargaan = $this->home->getUserHargaan($nrk);
            $data['infoHargaan'] = $infoHargaan;

           

            $infoHubkel = $this->home->getUserHubkel($nrk);
            $data['infoHubkel'] = $infoHubkel;

            $infoPangkat = $this->home->getUserPangkat($nrk);
            $data['infoPangkat'] = $infoPangkat; 

            $infoGapokUser = $this->home->getUserGapok($nrk);

            $data['infoGapokUser'] = $infoGapokUser;

            $infoJabatanS = $this->home->getUserJabatanS($nrk);
            $data['infoJabatanS'] = $infoJabatanS;

            $infoJabatanF = $this->home->getUserJabatanF($nrk);
            $data['infoJabatanF'] = $infoJabatanF;  

            $infoCuti = $this->home->getUserCuti($nrk);
            $data['infoCuti'] = $infoCuti;

            $infoDisiplin = $this->home->getUserDisiplin($nrk);
            $data['infoDisiplin'] = $infoDisiplin;  

            $infoSKPUser = $this->home->getUserSKP($nrk);
            $data['infoSKPUser'] = $infoSKPUser;
             $datasek = $this->vpeg->getDataSekunderPegawai($nrk); 
            
            
            if(isset($datasek))
            {
                
                $data['peg2'] = $datasek;    

                $data['listAgama'] = $this->vpeg->getListAgama($datasek->AGAMA);

                if($datasek->KODIKCPS == null || $datasek->KODIKCPS =='')
                {
                    $data['listKodikcps'] = $this->vpeg->getListKodikcps();    
                }
                else
                {
                    $data['listKodikcps'] = $this->vpeg->getListKodikcps($datasek->KODIKCPS);       
                } 
            }
            else
            {
                $data['listAgama'] = $this->vpeg->getListAgama();
                $data['listKodikcps'] = $this->vpeg->getListKodikcps();    
                 
            }
                   
        $menuid='271';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        if($cekaksesmenu == '1')
        {
    		$this->load->view('head/header',$this->user);
    		$this->load->view('head/menu',$datam);
    		$this->load->view('profile',$data);
    		$this->load->view('head/footer');	        
        }
        else
        {
            $this->load->view('403');
        } 
	}
    
    public function toPdf()
    {
        $this->load->library('pdf_cv');


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
            // END GET NRK
        // START Inisial Active Menu
            $datam['activeProfile'] = "active";
        // END Inisial Active Menu

            $data['nrk'] = $nrk;
            $datam['nrk'] = $nrk;
            $datam['user_group'] = $this->user['user_group'];
            $data['user_id'] = $this->user['id'];
            $data['user_group'] = $this->user['user_group'];
            

            // ---------------------------------------------------

            //            untuk develop 74
            $infoUser = $this->home->getUserInfo2($nrk);
            $data['infoUser'] = $infoUser;


            //untuk orp 1
            /*          $infoUser = $this->home->getUserInfoORP($nrk);
            $data['infoUser'] = $infoUser;*/

            // -----------------------------------------------

            // bisa dev74 dan orp1
            $infoPenForm = $this->home->getUserInfoPendFormal($nrk);
            $data['infoPenForm'] = $infoPenForm;

            // bisa dev74 dan orp1
            $infoPenNForm = $this->home->getUserInfoPendNonFormal($nrk);
            $data['infoPenNForm'] = $infoPenNForm;

            // bisa dev74 dan orp1
            $infoAlamat = $this->home->getUserInfoAlamat2($nrk);
            // print_r($infoAlamat);exit;
            $data['infoAlamat'] = $infoAlamat;  

            // bisa dev74 dan orp1
            $infoHargaan = $this->home->getUserHargaan($nrk);
            $data['infoHargaan'] = $infoHargaan;

            // bisa dev74 dan orp1 <tidak digunakan di pdf>
            $infoOrgan = $this->home->getUserOrgan($nrk);
            $data['infoOrgan'] = $infoOrgan; 

            //dev 74 <untuk orp 1 aktifkan query lihat model>
            $infoHubkel = $this->home->getUserHubkel($nrk);
            $data['infoHubkel'] = $infoHubkel;

            // bisa dev74 dan orp1
            $infoPangkat = $this->home->getUserPangkat($nrk);
            $data['infoPangkat'] = $infoPangkat; 

            // bisa dev74 dan orp1
            $infoJabatanS = $this->home->getUserJabatanS($nrk);
            $data['infoJabatanS'] = $infoJabatanS;

            // bisa dev74 dan orp1
            $infoJabatanF = $this->home->getUserJabatanF($nrk);
            $data['infoJabatanF'] = $infoJabatanF;

            // bisa dev74 dan orp1
            $infoGapokUser = $this->home->getUserGapok($nrk);
            $data['infoGapokUser'] = $infoGapokUser;
            
           // $this->load->view('cv_pdf',$data);
            ob_start();


            $this->pdf_cv->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE,'DAFTAR RIWAYAT HIDUP', PDF_HEADER_STRING);

            // set header and footer fonts
            $this->pdf_cv->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->pdf_cv->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $this->pdf_cv->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $this->pdf_cv->SetMargins(PDF_MARGIN_LEFT, 38, PDF_MARGIN_RIGHT);
            //$this->pdf->SetMargins(15, 15, 15);
            //$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->pdf_cv->SetHeaderMargin(25);
            //$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $this->pdf_cv->SetFooterMargin(25);

            // set auto page breaks
            $this->pdf_cv->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $this->pdf_cv->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf_cv->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $this->pdf_cv->SetFont('helvetica', 'B', 20);

            // add a page
            $this->pdf_cv->AddPage();

            $this->pdf_cv->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

            $this->pdf_cv->SetFont('helvetica', '', 8);

            // -----------------------------------------------------------------------------

            $tbl = '<table width="100%" cellpadding="3">
                        <tr>
                            <td colspan="3" style="background-color:#1AB394; color:white;"><h3>DATA DIRI</h3></td>
                        </tr>
                        <tr>
                            <td width="15%"><b>Nama </b></td>
                            <td width="5%"><b>: </b></td>';


            //untuk data dari develop 74
            // --------------------------------------------------------------------
            if($infoUser->TITELDEPAN == null && $infoUser->TITEL==null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->NAMA_ABS.'</td>';
            }
            else if($infoUser->TITELDEPAN!=null && $infoUser->TITEL == null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->TITELDEPAN.''.$infoUser->NAMA_ABS.'</td>';
            }
            else if($infoUser->TITELDEPAN == null && $infoUser->TITEL != null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->NAMA_ABS.' '.$infoUser->TITEL.'</td>';
            }
            else
            {
                $tbl.=          '<td width="55%">'.$infoUser->TITELDEPAN.''.$infoUser->NAMA_ABS.''.$infoUser->TITEL.'</td>';    
            }

            //-----------------------------------------------------------------------


            //untuk data dari orp 1
            // ------------------------------------------------------------------------
                    //  $tbl.=          '<td width="55%">'.$infoUser->NAMA.' '.$infoUser->TITEL.'</td>';
            //----------------------------------------------------------------------

            $tbl.=          '<td></td>
                            
                        </tr>

                        <tr>
                            <td><b>NRK</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NRK.'</td>
                            <td width="25%" rowspan="6" align="center">';
                                $linkImg = 'assets/img/photo/'.$infoUser->NRK.'.jpg';
                                    if(file_exists($linkImg))
                                    {
                                      $img = base_url().'assets/img/photo/'.$infoUser->NRK.'.jpg';                                    
                                    }
                                    else
                                    {
                                      $img = base_url().'assets/img/photo/profile_small.jpg';                                    
                                    }

            $tbl.=         '<img alt="image" class="img-box m-t-xs img-responsive" src="'.$img.'" width="68px" height="68px" style="border-radius:10px;">';
            $tbl.=         '</td>

                        </tr>
                          
                        <tr>
                            <td><b>NIP18</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NIP18.'</td>
                        </tr>

                        <tr>
                            <td><b>Tempat/Tgl Lahir</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->PATHIR.', '.$infoUser->TLHR.'</td>
                        </tr>

                        <tr>
                            <td><b>Jabatan</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NAJABL.'</td>
                        </tr>

                        <tr>
                            <td><b>Lokasi</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NAKLOGAD.'</td>
                        </tr>
                          
                        <tr>
                            <td><b>Alamat</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoAlamat->ALAMAT.' RT '.$infoAlamat->RT.' RW '.$infoAlamat->RW.
                                ' KEL. '.$infoAlamat->NAKEL.' KEC. '.$infoAlamat->NACAM.' '.$infoAlamat->NAWIL.' - '.strtoupper($infoAlamat->PROP).'</td>           
                        </tr>   
                        </table><br/><br/>';


        if($infoPenForm !=null){
            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pendidikan Formal</h3></td>
                            </tr>
                        </table>
                        
                        <table width="100%" border="1" cellpadding= "3">
                          
                          <tr>
                            <td align="center" width="5%" ><b>No</b></td>
                            
                            <td align="center" width="35%"><b>Nama Sekolah</b></td>
                            <td align="center" width="20%"><b>Kota Sekolah</b></td>
                            <td align="center" width="20%"><b>Tg Ijazah</b></td>
                            <td align="center" width="20%"><b>Tg Ijazah</b></td>
                          </tr>';
                            
                             $i=1;
                            foreach($infoPenForm as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';

                                   
                                
                                if($row->UNIVER!='00000' AND $row->NASEK==" ")
                                {
                                    
            $tbl.=                        '<td >'.$row->NAUNIVER.'</td>';                        
                                }
                                else{
            $tbl.=                        '<td >'.$row->NASEK.'</td>';
                                    
                                }

            $tbl.=                        '<td>'.$row->KOTSEK.'</td>';
            $tbl.=                        '<td>'.$row->NOIJAZAH.'</td>';
                    $tglijazah = date("d-m-Y", strtotime($row->TGIJAZAH));
            $tbl.=                 '<td align="center" >'.$tglijazah.'</td>
                                </tr>';
                                 $i++;
                            }
            $tbl.=      '</table><br/><br/>';

        }


        if($infoPenNForm != null){

            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pendidikan Non Formal</h3></td>
                            </tr>
                        </table>

                        <table border="1" width="100%" cellpadding= "3">
                          
                          <tr>
                            <td width="5%" align="center"><b>No</b></td>
                            
                            <td width="35%" align="center"><b>Nama Sekolah</b></td>
                            <td width="20%" align="center"><b>Kota Sekolah</b></td>
                            <td width="20%" align="center"><b>No Ijazah</b></td>
                            <td width="20%" align="center"><b>Tg Ijazah</b></td>

                          </tr>';

                           $i=1;
                            foreach($infoPenNForm as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    
            $tbl.=                  '<td>'.$row->NASEK.'</td> 
                                     <td>'.$row->KOTSEK.'</td>
                                     <td>'.$row->NOIJAZAH.'</td>';
            $tglijazah = date("d-m-Y", strtotime($row->TGIJAZAH));
            $tbl.=                  '<td align="center">'.$tglijazah.'</td>
                                </tr>';
                                $i++;
                            } 
            $tbl.=      '</table><br/><br/>';
        }

         if($infoHubkel !=null)
        {    
            $tbl.=     '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Keluarga</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="15%" align="center"><b>Hubungan</b></td>
                                    <td width="20%" align="center"><b>Nama</b></td>
                                    <td width="13%" align="center"><b>TTL</b></td>
                                    <td width="12%" align="center"><b>Jenis Kelamin</b></td>
                                    <td width="15%" align="center"><b>Tunjangan</b></td>
                                    <td width="20%" align="center"><b>Pekerjaan</b></td>
                              </tr>';

                            $i=1;
                            foreach($infoHubkel as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>
                                    <td>'.$row->NAHUBKEL.'</td>
                                    <td>'.$row->NAMA.'</td>';
                                    $talhir = date("d-m-Y", strtotime($row->TALHIR));
            $tbl.=                  '<td>'.$row->TEMHIR.', <br/>'.$talhir.'</td>
                                    <td align="center">'.($row->JENKEL == "P" ? "Perempuan" : "Laki-laki").'</td>';
                                if($row->TUNJANGAN == 'MENDAPAT TUNJANGAN')
                                {
            $tbl.=                  '<td>DAPAT</td>';
                                }
                                else if($row->TUNJANGAN == 'TIDAK MENDAPAT TUNJANGAN')
                                {
            $tbl.=                         '<td>TIDAK</td>';
                                }
                                else
                                {
            $tbl.=                         '<td>PERPANJANGAN</td>';
                                }
                                   
             $tbl.=             '<td>'.$row->KERJAAN.'</td>';

             $tbl.=             '</tr>';
                                $i++;
                            }
            $tbl.=          '</table>';
        }  
        
        //$this->pdf_cv->writeHTML($tbl, true, false, false, false, '');
         $this->pdf_cv->AddPage();
         $tblJ="";
        if($infoJabatanS !=null){

            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Jabatan Struktural</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                                <td width="5%" align="center"><b>No</b></td>
                                <td width="10%" align="center"><b>TMT</b></td>
                                <td width="23%" align="center"><b>Lokasi</b></td>
                                <td width="15%" align="center"><b>Jabatan</b></td>
                                <td width="15%" align="center"><b>Pangkat (Gol)</b></td>
                                <td width="7%" align="center"><b>Eselon</b></td>
                                <td width="15%" align="center"><b>No. SK</b></td>
                                <td width="10%" align="center"><b>Tgl SK</b></td>
                            </tr>';

                            $i=1;
                            foreach($infoJabatanS as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date("d-m-Y", strtotime($row->TMT));
            $tbl.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NALOKL.'</td>    
                                    <td>'.$row->NAJABL.'</td>
                                    <td>'.$row->NAPANG.' ('.$row->GOL.' )</td>
                                    <td align="center">'.$row->ESELON.'</td>
                                    <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl.=                  '<td align="center">'.$tgsk.'</td>
                                </tr>';
                                $i++;
                            }
            $tbl.=          '</table><br/><br/>';

        }

        if($infoJabatanF !=null){

            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Jabatan Fungsional</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                                <td width="5%" align="center"><b>No</b></td>
                                <td width="10%"align="center"><b>TMT</b></td>
                                <td width="30%" align="center"><b>Lokasi</b></td>
                                <td width="15%" align="center"><b>Jabatan</b></td>
                                <td width="20%" align="center"><b>Pangkat (Gol)</b></td>
                                <td width="10%"align="center"><b>No SK</b></td>
                                <td width="10%"align="center"><b>Tgl SK</b></td>
                            </tr>';
                            
                            $i=1;
                            foreach($infoJabatanF as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tbl.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NALOKL.'</td>
                                    <td>'.$row->NAJABL.'</td>
                                    <td>'.$row->NAPANG.' ( '.$row->GOL.' )</td>
                                    <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl.=                  '<td align="center">'.$tgsk.'</td>
                                </tr>';
                              $i++;
                            }
            $tbl.=          '</table><br/><br/>';
            
        }
        
       // $this->pdf_cv->writeHTML($tblJ, true, false, false, false, '');
         $this->pdf_cv->AddPage();
        
        $tbl2="";

        if($infoGapokUser !=null){        

            $tbl.= '    <table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Gaji</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="15%" align="center"><b>TMT</b></td>
                                    <td width="20%" align="center"><b>Pangkat (Gol)</b></td>
                                    <td width="20%" align="center"><b>Gaji</b></td>
                                    <td width="20%" align="center"><b>No. SK</b></td>
                                    <td width="20%" align="center"><b>Tg. SK</b></td>
                                    
                              </tr>';

                              $i=1;
                              foreach($infoGapokUser as $row)
                              {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tbl.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NAPANG.'( '.$row->GOL.' )</td>
                                    <td align="center">'.number_format($row->GAPOK).'</td>
                                     <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl.=                  '<td align="center">'.$tgsk.'</td>
                                    
                                </tr>';
                                $i++;
                              }
            $tbl.=          '</table><br/><br/>';
           
        }       

        
        

        if($infoPangkat !=null){        

            $tbl.= '    <table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pangkat</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="12%" align="center"><b>TMT</b></td>
                                    <td width="23%" align="center"><b>Pangkat (Gol)</b></td>
                                    <td width="30%" align="center"><b>Lokasi</b></td>
                                    <td width="15%" align="center"><b>No. SK</b></td>
                                    <td width="15%" align="center"><b>Tg. SK</b></td>
                                    
                              </tr>';

                              $i=1;
                              foreach($infoPangkat as $row)
                              {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tbl.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NAPANG.'( '.$row->GOL.' )</td>
                                    <td>'.$row->NALOKL.'</td>
                                     <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl.=                  '<td align="center">'.$tgsk.'</td>
                                    
                                </tr>';
                                $i++;
                              }
            $tbl.=          '</table><br/><br/>';
           
        }

        
        if($infoHargaan !=null)
        {

            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Penghargaan</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                              <td width="5%" align="center"><b>No</b></td>
                              
                              <td width="40%" align="center"><b>Nama Penghargaan</b></td>
                              <td width="25%" align="center"><b>Asal Penghargaan</b></td>
                              <td width="15%" align="center"><b>No. SK</b></td>
                              <td width="15%" align="center"><b>Tg. SK</b></td>
                            </tr>';

                            $i=1;
                            foreach($infoHargaan as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>
                                    <td>'.$row->NAHARGA.'</td>   
                                    <td>'.$row->ASAL_HRG.'</td>
                                    <td> '.$row->NOSK.'</td> 
                                    <td> '.$row->TGSK.'</td> </tr>';
                                $i++;
                            }                 
            $tbl.=      '</table><br/><br/>';
           
        }


         
            
            $this->pdf_cv->writeHTML($tbl, true, false, false, false, '');
            //$this->pdf_cv->IncludeJS("print();");
              
              
         ob_clean(); 
            
            $this->pdf_cv->Output('cv.pdf', 'I');

    }

    public function toPdf2()
    {
        $this->load->library('pdf');
        $nrk = $this->input->post('nrkpr');

            // if(isset($_POST['nrk'])){
            //         $nrk = $_POST['nrk'];
            //     }elseif(isset($_POST['nrkP'])){ //Pencarian NRK Untuk Admin/BKD
            //         $nrk = $_POST['nrkP'];                    
            //     }else{
            //         $nrk = $this->user['id'];
                    
            //         if($this->user['user_group'] > 1){
            //             $nrk = "";
            //         }
            //     }                                            
            // END GET NRK
        // START Inisial Active Menu
            $datam['activeProfile'] = "active";
        // END Inisial Active Menu

            $data['nrk'] = $nrk;
            $datam['nrk'] = $nrk;
            $datam['user_group'] = $this->user['user_group'];
            $data['user_id'] = $this->user['id'];
            $data['user_group'] = $this->user['user_group'];
            

            // ---------------------------------------------------

            //            untuk develop 74
            $infoUser = $this->home->getUserInfo2($nrk);
            $data['infoUser'] = $infoUser;


            //untuk orp 1
            /*          $infoUser = $this->home->getUserInfoORP($nrk);
            $data['infoUser'] = $infoUser;*/

            // -----------------------------------------------

            // bisa dev74 dan orp1
            $infoPenForm = $this->home->getUserInfoPendFormal($nrk);
            $data['infoPenForm'] = $infoPenForm;

            // bisa dev74 dan orp1
            $infoPenNForm = $this->home->getUserInfoPendNonFormal($nrk);
            $data['infoPenNForm'] = $infoPenNForm;

            // bisa dev74 dan orp1
            $infoAlamat = $this->home->getUserInfoAlamat2($nrk);
            // print_r($infoAlamat);exit;
            $data['infoAlamat'] = $infoAlamat;  

            // bisa dev74 dan orp1
            $infoHargaan = $this->home->getUserHargaan($nrk);
            $data['infoHargaan'] = $infoHargaan;

            // bisa dev74 dan orp1 <tidak digunakan di pdf>
            $infoOrgan = $this->home->getUserOrgan($nrk);
            $data['infoOrgan'] = $infoOrgan; 

            //dev 74 <untuk orp 1 aktifkan query lihat model>
            $infoHubkel = $this->home->getUserHubkel($nrk);
            $data['infoHubkel'] = $infoHubkel;

            // bisa dev74 dan orp1
            $infoPangkat = $this->home->getUserPangkat($nrk);
            $data['infoPangkat'] = $infoPangkat; 

            // bisa dev74 dan orp1
            $infoJabatanS = $this->home->getUserJabatanS($nrk);
            $data['infoJabatanS'] = $infoJabatanS;

            // bisa dev74 dan orp1
            $infoJabatanF = $this->home->getUserJabatanF($nrk);
            $data['infoJabatanF'] = $infoJabatanF;

            // bisa dev74 dan orp1
            $infoGapokUser = $this->home->getUserGapok($nrk);
            $data['infoGapokUser'] = $infoGapokUser;
            
           // $this->load->view('cv_pdf',$data);
            ob_start();


            $this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE,'DAFTAR RIWAYAT HIDUP', PDF_HEADER_STRING);

            // set header and footer fonts
            $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $this->pdf->SetMargins(PDF_MARGIN_LEFT, 38, PDF_MARGIN_RIGHT);
            //$this->pdf->SetMargins(15, 15, 15);
            //$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->pdf->SetHeaderMargin(25);
            //$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $this->pdf->SetFooterMargin(25);

            // set auto page breaks
            $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $this->pdf->SetFont('helvetica', 'B', 20);

            // add a page
            $this->pdf->AddPage();

            //$this->pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

            $this->pdf->SetFont('helvetica', '', 8);

            // -----------------------------------------------------------------------------

            $tbl = '<table width="100%" cellpadding="3">
                        <tr>
                            <td colspan="3" style="background-color:#1AB394; color:white;"><h3>DATA DIRI</h3></td>
                        </tr>
                        <tr>
                            <td width="15%"><b>Nama </b></td>
                            <td width="5%"><b>: </b></td>';


            //untuk data dari develop 74
            // --------------------------------------------------------------------
            if($infoUser->TITELDEPAN == null && $infoUser->TITEL==null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->NAMA_ABS.'</td>';
            }
            else if($infoUser->TITELDEPAN!=null && $infoUser->TITEL == null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->TITELDEPAN.''.$infoUser->NAMA_ABS.'</td>';
            }
            else if($infoUser->TITELDEPAN == null && $infoUser->TITEL != null)
            {
                $tbl.=          '<td width="55%">'.$infoUser->NAMA_ABS.' '.$infoUser->TITEL.'</td>';
            }
            else
            {
                $tbl.=          '<td width="55%">'.$infoUser->TITELDEPAN.''.$infoUser->NAMA_ABS.''.$infoUser->TITEL.'</td>';    
            }

            //-----------------------------------------------------------------------


            //untuk data dari orp 1
            // ------------------------------------------------------------------------
                    //  $tbl.=          '<td width="55%">'.$infoUser->NAMA.' '.$infoUser->TITEL.'</td>';
            //----------------------------------------------------------------------

            $tbl.=          '<td></td>
                            
                        </tr>

                        <tr>
                            <td><b>NRK</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NRK.'</td>
                            <td width="25%" rowspan="6" align="center">';
                                $linkImg = 'assets/img/photo/'.$infoUser->NRK.'.jpg';
                                    if(file_exists($linkImg))
                                    {
                                      $img = base_url().'assets/img/photo/'.$infoUser->NRK.'.jpg';                                    
                                    }
                                    else
                                    {
                                      $img = base_url().'assets/img/photo/profile_small.jpg';                                    
                                    }

            $tbl.=         '<img alt="image" class="img-box m-t-xs img-responsive" src="'.$img.'" width="68px" height="68px" style="border-radius:10px;">';
            $tbl.=         '</td>

                        </tr>
                          
                        <tr>
                            <td><b>NIP18</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NIP18.'</td>
                        </tr>

                        <tr>
                            <td><b>Tempat/Tgl Lahir</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->PATHIR.', '.$infoUser->TLHR.'</td>
                        </tr>

                        <tr>
                            <td><b>Jabatan</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NAJABL.'</td>
                        </tr>

                        <tr>
                            <td><b>Lokasi</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoUser->NALOKL.'</td>
                        </tr>
                          
                        <tr>
                            <td><b>Alamat</b></td>
                            <td><b>:</b></td>
                            <td>'.$infoAlamat->ALAMAT.' RT '.$infoAlamat->RT.' RW '.$infoAlamat->RW.
                                ' KEL. '.$infoAlamat->NAKEL.' KEC. '.$infoAlamat->NACAM.' '.$infoAlamat->NAWIL.' - '.strtoupper($infoAlamat->PROP).'</td>           
                        </tr>   
                        </table><br/><br/>';


        if($infoPenForm !=null){
            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pendidikan Formal</h3></td>
                            </tr>
                        </table>
                        
                        <table width="100%" border="1" cellpadding= "3">
                          
                          <tr>
                            <td align="center" width="5%" ><b>No</b></td>
                            
                            <td align="center" width="35%"><b>Nama Sekolah</b></td>
                            <td align="center" width="20%"><b>Kota Sekolah</b></td>
                            <td align="center" width="20%"><b>Tg Ijazah</b></td>
                            <td align="center" width="20%"><b>Tg Ijazah</b></td>
                          </tr>';
                            
                             $i=1;
                            foreach($infoPenForm as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';

                                   
                                
                                if($row->UNIVER!='00000' AND $row->NASEK==" ")
                                {
                                    
            $tbl.=                        '<td >'.$row->NAUNIVER.'</td>';                        
                                }
                                else{
            $tbl.=                        '<td >'.$row->NASEK.'</td>';
                                    
                                }

            $tbl.=                        '<td>'.$row->KOTSEK.'</td>';
            $tbl.=                        '<td>'.$row->NOIJAZAH.'</td>';
                    $tglijazah = date("d-m-Y", strtotime($row->TGIJAZAH));
            $tbl.=                 '<td align="center" >'.$tglijazah.'</td>
                                </tr>';
                                 $i++;
                            }
            $tbl.=      '</table><br/><br/>';

        }


        if($infoPenNForm != null){

            $tbl.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pendidikan Non Formal</h3></td>
                            </tr>
                        </table>

                        <table border="1" width="100%" cellpadding= "3">
                          
                          <tr>
                            <td width="5%" align="center"><b>No</b></td>
                            
                            <td width="35%" align="center"><b>Nama Sekolah</b></td>
                            <td width="20%" align="center"><b>Kota Sekolah</b></td>
                            <td width="20%" align="center"><b>No Ijazah</b></td>
                            <td width="20%" align="center"><b>Tg Ijazah</b></td>

                          </tr>';

                           $i=1;
                            foreach($infoPenNForm as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    
            $tbl.=                  '<td>'.$row->NASEK.'</td> 
                                     <td>'.$row->KOTSEK.'</td>
                                     <td>'.$row->NOIJAZAH.'</td>';
            $tglijazah = date("d-m-Y", strtotime($row->TGIJAZAH));
            $tbl.=                  '<td align="center">'.$tglijazah.'</td>
                                </tr>';
                                $i++;
                            } 
            $tbl.=      '</table><br/><br/>';
        }

        if($infoHubkel !=null)
        {    
            $tbl.=     '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Keluarga</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="15%" align="center"><b>Hubungan</b></td>
                                    <td width="20%" align="center"><b>Nama</b></td>
                                    <td width="13%" align="center"><b>TTL</b></td>
                                    <td width="12%" align="center"><b>Jenis Kelamin</b></td>
                                    <td width="15%" align="center"><b>Tunjangan</b></td>
                                    <td width="20%" align="center"><b>Pekerjaan</b></td>
                              </tr>';

                            $i=1;
                            foreach($infoHubkel as $row)
                            {
            $tbl.=              '<tr>
                                    <td align="center">'.$i.'</td>
                                    <td>'.$row->NAHUBKEL.'</td>
                                    <td>'.$row->NAMA.'</td>';
                                    $talhir = date("d-m-Y", strtotime($row->TALHIR));
            $tbl.=                  '<td>'.$row->TEMHIR.', <br/>'.$talhir.'</td>
                                    <td align="center">'.($row->JENKEL == "P" ? "Perempuan" : "Laki-laki").'</td>';
                                if($row->TUNJANGAN == 'MENDAPAT TUNJANGAN')
                                {
            $tbl.=                  '<td>DAPAT</td>';
                                }
                                else if($row->TUNJANGAN == 'TIDAK MENDAPAT TUNJANGAN')
                                {
            $tbl.=                         '<td>TIDAK</td>';
                                }
                                else
                                {
            $tbl.=                         '<td>PERPANJANGAN</td>';
                                }
                                   
             $tbl.=             '<td>'.$row->KERJAAN.'</td>';

             $tbl.=             '</tr>';
                                $i++;
                            }
            $tbl.=          '</table>';
        }   

        $this->pdf->writeHTML($tbl,  true, false, true, false, '');
        
        
         $this->pdf->AddPage();
         $tblJ="";

        if($infoJabatanS !=null){

            $tblJ.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Jabatan Struktural</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                                <td width="5%" align="center"><b>No</b></td>
                                <td width="10%" align="center"><b>TMT</b></td>
                                <td width="23%" align="center"><b>Lokasi</b></td>
                                <td width="15%" align="center"><b>Jabatan</b></td>
                                <td width="15%" align="center"><b>Pangkat (Gol)</b></td>
                                <td width="7%" align="center"><b>Eselon</b></td>
                                <td width="15%" align="center"><b>No. SK</b></td>
                                <td width="10%" align="center"><b>Tgl SK</b></td>
                            </tr>';

                            $i=1;
                            foreach($infoJabatanS as $row)
                            {
            $tblJ.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date("d-m-Y", strtotime($row->TMT));
            $tblJ.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NALOKL.'</td>    
                                    <td>'.$row->NAJABL.'</td>
                                    <td>'.$row->NAPANG.' ('.$row->GOL.' )</td>
                                    <td align="center">'.$row->ESELON.'</td>
                                    <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tblJ.=                  '<td align="center">'.$tgsk.'</td>
                                </tr>';
                                $i++;
                            }
            $tblJ.=          '</table><br/><br/>';

        }

        if($infoJabatanF !=null){

            $tblJ.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Jabatan Fungsional</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                                <td width="5%" align="center"><b>No</b></td>
                                <td width="10%"align="center"><b>TMT</b></td>
                                <td width="30%" align="center"><b>Lokasi</b></td>
                                <td width="15%" align="center"><b>Jabatan</b></td>
                                <td width="20%" align="center"><b>Pangkat (Gol)</b></td>
                                <td width="10%"align="center"><b>No SK</b></td>
                                <td width="10%"align="center"><b>Tgl SK</b></td>
                            </tr>';
                            
                            $i=1;
                            foreach($infoJabatanF as $row)
                            {
            $tblJ.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tblJ.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NALOKL.'</td>
                                    <td>'.$row->NAJABL.'</td>
                                    <td>'.$row->NAPANG.' ( '.$row->GOL.' )</td>
                                    <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tblJ.=                  '<td align="center">'.$tgsk.'</td>
                                </tr>';
                              $i++;
                            }
            $tblJ.=          '</table><br/><br/>';
            
        }

        $this->pdf->writeHTML($tblJ,  true, false, true, false, '');
        

        $this->pdf->AddPage();
        
        $tbl2="";

        if($infoGapokUser !=null){        

            $tbl2.= '    <table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Gaji</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="15%" align="center"><b>TMT</b></td>
                                    <td width="20%" align="center"><b>Pangkat (Gol)</b></td>
                                    <td width="20%" align="center"><b>Gaji</b></td>
                                    <td width="20%" align="center"><b>No. SK</b></td>
                                    <td width="20%" align="center"><b>Tg. SK</b></td>
                                    
                              </tr>';

                              $i=1;
                              foreach($infoGapokUser as $row)
                              {
            $tbl2.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tbl2.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NAPANG.'( '.$row->GOL.' )</td>
                                    <td align="center">'.number_format($row->GAPOK).'</td>
                                     <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl2.=                  '<td align="center">'.$tgsk.'</td>
                                    
                                </tr>';
                                $i++;
                              }
            $tbl2.=          '</table><br/><br/>';
           
        }       

        
        

        if($infoPangkat !=null){        

            $tbl2.= '    <table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Pangkat</h3></td>
                            </tr>
                        </table>
                            <table border="1" width="100%" cellpadding= "3">
                                <tr>
                                    <td width="5%" align="center"><b>No</b></td>
                                    <td width="12%" align="center"><b>TMT</b></td>
                                    <td width="23%" align="center"><b>Pangkat (Gol)</b></td>
                                    <td width="30%" align="center"><b>Lokasi</b></td>
                                    <td width="15%" align="center"><b>No. SK</b></td>
                                    <td width="15%" align="center"><b>Tg. SK</b></td>
                                    
                              </tr>';

                              $i=1;
                              foreach($infoPangkat as $row)
                              {
            $tbl2.=              '<tr>
                                    <td align="center">'.$i.'</td>';
                                    $tmt = date('d-m-Y', strtotime($row->TMT));
            $tbl2.=                  '<td align="center">'.$tmt.'</td>
                                    <td>'.$row->NAPANG.'( '.$row->GOL.' )</td>
                                    <td>'.$row->NALOKL.'</td>
                                     <td>'.$row->NOSK.'</td>';
                                    $tgsk = date("d-m-Y", strtotime($row->TGSK));
            $tbl2.=                  '<td align="center">'.$tgsk.'</td>
                                    
                                </tr>';
                                $i++;
                              }
            $tbl2.=          '</table><br/><br/>';
           
        }

        
        if($infoHargaan !=null)
        {

            $tbl2.=      '<table width="100%" cellpadding= "3">
                            <tr>
                                <td style="background-color:#1AB394; color:white;"><h3>Riwayat Penghargaan</h3></td>
                            </tr>
                        </table>
                        <table border="1" width="100%" cellpadding= "3">
                            <tr>
                              <td width="5%" align="center"><b>No</b></td>
                              
                              <td width="40%" align="center"><b>Nama Penghargaan</b></td>
                              <td width="25%" align="center"><b>Asal Penghargaan</b></td>
                              <td width="15%" align="center"><b>No. SK</b></td>
                              <td width="15%" align="center"><b>Tg. SK</b></td>
                            </tr>';

                            $i=1;
                            foreach($infoHargaan as $row)
                            {
            $tbl2.=              '<tr>
                                    <td align="center">'.$i.'</td>
                                    <td>'.$row->NAHARGA.'</td>   
                                    <td>'.$row->ASAL_HRG.'</td>
                                    <td> '.$row->NOSK.'</td> 
                                    <td> '.$row->TGSK.'</td> </tr>';
                                $i++;
                            }                 
            $tbl2.=      '</table><br/><br/>';
           
        }

            $this->pdf->writeHTML($tbl2, true, false, true, false, '');
            
              ob_clean();          
            
            $this->pdf->Output('cv.pdf', 'I');

    }

    public function CV()
    {
        $this->load->library('fpdf_cv');
        $nrk = $this->input->post('nrkpr');
        
        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;


        // bisa dev74 dan orp1
        $infoPenForm = $this->home->getUserInfoPendFormal($nrk);
        $data['infoPenForm'] = $infoPenForm;

        // bisa dev74 dan orp1
        $infoPenNForm = $this->home->getUserInfoPendNonFormal($nrk);
        $data['infoPenNForm'] = $infoPenNForm;

        // bisa dev74 dan orp1
        $infoAlamat = $this->home->getUserInfoAlamat2($nrk);
        // print_r($infoAlamat);exit;

        $data['infoAlamat'] = $infoAlamat;  

        // bisa dev74 dan orp1
        $infoHargaan = $this->home->getUserHargaan($nrk);
        $data['infoHargaan'] = $infoHargaan;

        // bisa dev74 dan orp1 <tidak digunakan di pdf>
        $infoOrgan = $this->home->getUserOrgan($nrk);
        $data['infoOrgan'] = $infoOrgan; 

        //dev 74 <untuk orp 1 aktifkan query lihat model>
        $infoHubkel = $this->home->getUserHubkel($nrk);
        $data['infoHubkel'] = $infoHubkel;

        // bisa dev74 dan orp1
        $infoPangkat = $this->home->getUserPangkat($nrk);
        $data['infoPangkat'] = $infoPangkat; 

        // bisa dev74 dan orp1
        $infoJabatanS = $this->home->getUserJabatanS($nrk);
        $data['infoJabatanS'] = $infoJabatanS;

        // bisa dev74 dan orp1
        $infoJabatanF = $this->home->getUserJabatanF($nrk);
        $data['infoJabatanF'] = $infoJabatanF;

        // bisa dev74 dan orp1
        $infoGapokUser = $this->home->getUserGapok($nrk);
        $data['infoGapokUser'] = $infoGapokUser;

        $infoDisiplin = $this->home->getUserDisiplin($nrk);
        $data['infoDisiplin'] = $infoDisiplin;     

        $infoSKPUser = $this->home->getUserSKP($nrk);
        $data['infoSKPUser'] = $infoSKPUser;  
            
           // $this->load->view('cv_pdf',$data);
        $this->fpdf_cv->SetFont('helvetica', 'B', 20);
        // add a page
        $this->fpdf_cv->AddPage();

        $this->fpdf_cv->SetFont('helvetica', '', 8);

        $this->fpdf_cv->isiData($data,$nrk);    
        
        $this->fpdf_cv->Output();

    }

    public function DRH()
    {
        $this->load->library('fpdf_cv');
        

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

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;


        // bisa dev74 dan orp1
        $infoPenForm = $this->home->getUserInfoPendFormal($nrk);
        $data['infoPenForm'] = $infoPenForm;

        // bisa dev74 dan orp1
        $infoPenNForm = $this->home->getUserInfoPendNonFormal($nrk);
        $data['infoPenNForm'] = $infoPenNForm;

        // bisa dev74 dan orp1
        $infoAlamat = $this->home->getUserInfoAlamat2($nrk);
        
        $data['infoAlamat'] = $infoAlamat;  

        // bisa dev74 dan orp1
        $infoHargaan = $this->home->getUserHargaan($nrk);
        $data['infoHargaan'] = $infoHargaan;

        // bisa dev74 dan orp1 <tidak digunakan di pdf>
        $infoOrgan = $this->home->getUserOrgan($nrk);
        $data['infoOrgan'] = $infoOrgan; 

        //dev 74 <untuk orp 1 aktifkan query lihat model>
        $infoHubkel = $this->home->getUserHubkel($nrk);
        $data['infoHubkel'] = $infoHubkel;

        // bisa dev74 dan orp1
        $infoPangkat = $this->home->getUserPangkat($nrk);
        $data['infoPangkat'] = $infoPangkat; 

        // bisa dev74 dan orp1
        $infoJabatanS = $this->home->getUserJabatanS($nrk);
        $data['infoJabatanS'] = $infoJabatanS;

        // bisa dev74 dan orp1
        $infoJabatanF = $this->home->getUserJabatanF($nrk);
        $data['infoJabatanF'] = $infoJabatanF;

        // bisa dev74 dan orp1
        $infoGapokUser = $this->home->getUserGapok($nrk);
        $data['infoGapokUser'] = $infoGapokUser;

        $infoDisiplin = $this->home->getUserDisiplin($nrk);
        $data['infoDisiplin'] = $infoDisiplin; 

        
        $infoSKPUser = $this->home->getUserSKP($nrk);
        $data['infoSKPUser'] = $infoSKPUser;   
            
           // $this->load->view('cv_pdf',$data);
        $this->fpdf_cv->SetFont('helvetica', 'B', 20);
        // add a page
        $this->fpdf_cv->AddPage();

        $this->fpdf_cv->SetFont('helvetica', '', 8);

        $this->fpdf_cv->isiData($data,$nrk);    
        
        $this->fpdf_cv->Output();

    }	

    function UpdateDasek(){
        $nrk = $this->input->post('NRK');
        

        $agama = $this->input->post('agama');
        $jenkel = $this->input->post('jenkel');
        $taspen = $this->input->post('taspen');
        if($taspen=='')
        {
            $taspen='-';
        }
        $noppen = $this->input->post('noppen');
        $nokk = $this->input->post('nokk');
        $simpeda = $this->input->post('simpeda');
        $npwp = $this->input->post('npwp');
        $darah = $this->input->post('darah');
        $notelp = $this->input->post('notelp');
        $nohp = $this->input->post('nohp');
        $jendikcps = $this->input->post('jendikcps');
        $kodikcps = $this->input->post('kodikcps');
        $karpeg = $this->input->post('karpeg');
        $bpjs = $this->input->post('bpjs');
        $email = $this->input->post('email');
        $karsu = $this->input->post('karsu');
        $email = $this->input->post('email');
        if($jendikcps == null)
        {
            $jendikcps = 1;
        }
        
            $query  = $this->vpeg->updateDasekPegawai($nrk,$agama,$jenkel,$taspen,$noppen,$nokk,$simpeda,$npwp,$darah,$notelp,$nohp,$jendikcps,$kodikcps,$karpeg,$bpjs,$email,$karsu);
            
            if($query == 2)
            {
                $respon = "2";
            }
            else if($query == -2)
            {
                $respon = "-2";
            }
            else if($query == 1)
            {
                $respon = "1";
            }
            else if($query == -1)
            {
                $respon = "-1";
            }
            else
            {
                $respon = "0";
            }
        
        
        $return = array('responupd' => $respon);

        echo json_encode($return);
    }
	
	function teskikin(){
		phpinfo();
    }     

    
    public function TESTupload_file_jabatan()
    {

        $nrk        = $this->input->post('nrk',TRUE);
        $tmt        = $this->input->post('tmt',TRUE);
        $kolok      = $this->input->post('kolok',TRUE);
        $kojab      = $this->input->post('kojab',TRUE);
        $gambar     = $this->input->post('gambar',TRUE);
        echo " NRK :".$nrk;
        echo "<br>";
        echo " gambar :".$gambar;
        exit();

    }


    public function upload_file_riwayat()
    {
        $db2            = $this->load->database('DBfile', TRUE);
        date_default_timezone_set('Asia/Jakarta');
        $date           = date('Y-m-d');
        $time           = date('H-i-s');

        $ftp_server     = "10.15.34.186";
        $ftp_conn       = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login          = ftp_login($ftp_conn, "donna", "jayaraya21");

        $nrk                = $this->input->post('nrk',TRUE);
        $jenis_riwayat      = $this->input->post('jenis_riwayat',TRUE);
        $gambar             = $this->input->post('gambar',TRUE);
      
        if($jenis_riwayat == 'gapok')
        {
            $tmt            = $this->input->post('tmt',TRUE);
            $teemte         = $tmt.'  00:00:00';
            $gapok          = $this->input->post('gapok',TRUE);
            $nama_folder    = 'gapok';
        }
        elseif($jenis_riwayat == 'jabatan')
        {
            $tmt            = $this->input->post('tmt',TRUE);
            $kolok          = $this->input->post('kolok',TRUE);
            $kojab          = $this->input->post('kojab',TRUE);
            $nama_folder    = 'jabatan';
        }
        elseif($jenis_riwayat == 'pendidikan_formal')
        {
            $kodik          = $this->input->post('kodik',TRUE);
            $jendik         = $this->input->post('jendik',TRUE);
            $tglijazah      = $this->input->post('tgl_ijazah',TRUE);
            $nama_folder    = 'pendidikan_formal';
        }
        elseif($jenis_riwayat == 'pendidikan_non_formal')
        {
            $kodik          = $this->input->post('kodik',TRUE);
            $jendik         = $this->input->post('jendik',TRUE);
            $tglijazah      = $this->input->post('tgl_ijazah',TRUE);
            $nama_folder    = 'pendidikan_non_formal';
        }
        elseif($jenis_riwayat == 'pangkat')
        {
            $kopang         = $this->input->post('kopang',TRUE);
            $gapok          = $this->input->post('gapok',TRUE);
            $tmt            = $this->input->post('tmt',TRUE);
            $nama_folder    = 'pangkat';
        }
        elseif($jenis_riwayat == 'skp')
        {
            $thn            = $this->input->post('thn',TRUE);
            $nama_folder    = 'skp';
        }
        elseif($jenis_riwayat == 'cuti')
        {
            $jencuti            = $this->input->post('jencuti',TRUE);
            $tmt                = $this->input->post('tmt',TRUE);
            $tgakhir            = $this->input->post('tgakhir',TRUE);
            $tgupd              = $this->input->post('tgupd',TRUE);
            $nosk               = $this->input->post('nosk',TRUE);
            $teemte             = date('Y-m-d', strtotime($tmt));

            $nama_folder        = 'cuti';
        }
        elseif($jenis_riwayat == 'jbf')
        {
            $kojab              = $this->input->post('kojab',TRUE);
            $kolok              = $this->input->post('kolok',TRUE);
            $tmt                = $this->input->post('tmt',TRUE);
            $nama_folder        = 'jabatan_fungsional';
        }
        elseif($jenis_riwayat == 'penghargaan')
        {
            $kdharga            = $this->input->post('kdharga',TRUE);
            $nama_folder        = 'penghargaan';
        }
        elseif($jenis_riwayat == 'hukdis')
        {
            $tgsk               = $this->input->post('tgsk',TRUE);
            $jenhukdis          = $this->input->post('jenhukdis',TRUE);
            $TSK                = date('Y-m-d', strtotime($tgsk));
            $nama_folder        = 'hukdis';
        }
        elseif($jenis_riwayat == 'hubkel')
        {
            $hubklg             = $this->input->post('hubklg',TRUE);
            $nama_folder        = 'hubkel';
        }
        elseif($jenis_riwayat == 'jabatan')
        {
            $tmt                = $this->input->post('tmt',TRUE);
            $kolok              = $this->input->post('kolok',TRUE);
            $kojab              = $this->input->post('kojab',TRUE);

            $nama_folder        = 'jabatan';
        }
            
            $config = array(
                    'allowed_types' => '*',
                    'upload_path'   => realpath('./file/upload/'.$nama_folder.'/'),
                    'max_size'      => 5000000000000,
                );

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $file = $this->upload->file_name;

            if ($this->upload->do_upload('gambar')) {
                $file1  = $this->upload->data();
                $file2  = $file1['file_name'];
                $gambar = $file2;
            }

            $from           = site_url().'/file/upload/'.$nama_folder.'/'.$gambar;
            $to             = '/'.$nrk.'/'.$nama_folder.'/'.$gambar;
            $dir            = $nrk.'/'.$nama_folder.'/';

            if($ftp_conn)
            {
                if(!file_exists("http://pusdatin.jakarta.go.id/upload_file_pegawai/" . $nrk . "/".$nama_folder."/")) 
                {
                    if(ftp_mkdir($ftp_conn, $dir))
                    {
                        echo "Berhasil Membuat Direktori : $dir";
                    }
                    else
                    {
                        echo "Gagal Membuat Direktori (Direktori Telah aDA) : $dir";
                    }
                }
                else
                {
                    echo "Direktori Telah Ada";
                }

                if($login)
                {
                    if (ftp_put($ftp_conn, $to, $from, FTP_ASCII)) 
                    { 
                        echo "<br>Berhasil Upload $gambar."; 
                    } 
                    else 
                    { 
                        echo "<br>Gagal Upload ( : File $gambar)"; 
                    } 
                }
                else
                {
                    echo "<br>Gagal Login Akun FTP"; 
                }
            }
            else
            {
                echo "Gagal Login FTP";
            }

            if($jenis_riwayat == 'gapok')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_gapok\" WHERE \"nrk\" = '".$nrk."' 
                    AND \"tmt\" = '".$tmt."' AND \"gapok\" = '".$gapok."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_gapok\"(\"id_hist\",\"nrk\",\"tmt\",\"gapok\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_gapok_seq'),'".$nrk."','".$tmt."',".$gapok.",'".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_gapok\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = '".$tmt."' AND \"gapok\" = ".$gapok."
                        ";
                    $this->db2->query($sql);
                }

                $this->db->query("UPDATE PERS_RB_GAPOK_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND GAPOK = '$gapok'");

                $pesan = "File Riwayat Gapok Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'pendidikan_formal')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_pend_formal\" WHERE \"nrk\" = '".$nrk."' 
                AND \"jendik\" = '".$jendik."' AND \"kodik\" = '".$kodik."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_pend_formal\"(\"id_hist\",\"nrk\",\"jendik\",\"kodik\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_pend_formal_seq'),'".$nrk."',".$jendik.",'".$kodik."','".$gambar."','".$nrk."','".$date."')";
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_pend_formal\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"jendik\" = ".$jendik." AND \"kodik\" = '".$kodik."'
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_PENDIDIKAN set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND JENDIK = '$jendik' AND KODIK = '$kodik' AND TGIJAZAH = TO_DATE('".$tglijazah."', 'DD-MM-YYYY')";

                $this->db->query($Quer);

                $pesan = "File Riwayat Pendidikan Formal Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'pendidikan_non_formal')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_pend_non_formal\" WHERE \"nrk\" = '".$nrk."' 
                AND \"jendik\" = '".$jendik."' AND \"kodik\" = '".$kodik."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_pend_non_formal\"(\"id_hist\",\"nrk\",\"jendik\",\"kodik\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_pend_non_formal_seq'),'".$nrk."',".$jendik.",'".$kodik."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_pend_non_formal\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"jendik\" = ".$jendik." AND \"kodik\" = '".$kodik."'
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_PENDIDIKAN set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND JENDIK = '$jendik' AND KODIK = '$kodik' AND TGIJAZAH = TO_DATE('".$tglijazah."', 'DD-MM-YYYY')";

                $this->db->query($Quer);

                $pesan = "File Riwayat Pendidikan Non Formal Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'pangkat')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_pangkat\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tmt\" = '".$tmt."' AND \"kopang\" = '".$kopang."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_pangkat\"(\"id_hist\",\"nrk\",\"tmt\",\"kopang\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_pangkat_seq'),'".$nrk."','".$tmt."','".$kopang."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_pangkat\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = '".$tmt."' AND \"kopang\" = '".$kopang."'
                        ";
                    $this->db2->query($sql);
                }

                $this->db->query("UPDATE PERS_PANGKAT_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND KOPANG = '$kopang'  AND GAPOK = '$gapok'");

                $pesan = "File Riwayat Pangkat Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'skp')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_skp\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tahun\" = '".$thn."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_skp\"(\"id_hist\",\"nrk\",\"tahun\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_skp_seq'),'".$nrk."','".$thn."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_skp\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tahun\" = '".$thn."' 
                        ";
                    $this->db2->query($sql);
                }

                $this->db->query("UPDATE PERS_skp set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND TAHUN = '$thn' ");

                $pesan = "File Riwayat SKP Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'cuti')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_cuti\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tmt\" = '".$teemte."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_cuti\"(\"id_hist\",\"nrk\",\"tmt\",\"nosk\",\"jencuti\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_cuti_seq'),'".$nrk."','".$teemte."','".$nosk."',".$jencuti.",'".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_cuti\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = '".$teemte."'
                        ";
                    $this->db2->query($sql);
                }
                
                $Quer = "UPDATE PERS_CUTI_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TGAKHIR = TO_DATE('".$tgakhir."', 'DD-MM-YYYY') AND TMT = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND JENCUTI = '".$jencuti."' ";
                $this->db->query($Quer);

                $pesan = "File Riwayat CUTI Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'jbf')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_jabatanf\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tmt\" = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_jabatanf\"(\"id_hist\",\"nrk\",\"tmt\",\"kolok\",\"kojab\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_jabatanf_seq'),'".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),'".$kolok."','".$kojab."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_jabatanf\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_JABATANF_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TMT = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND KOLOK = '".$kolok."'  AND KOJAB = '".$kojab."' ";
                $this->db->query($Quer);

                $pesan = "File Riwayat Jabatan Fungsional Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'penghargaan')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_penghargaan\" WHERE \"nrk\" = '".$nrk."' 
                AND \"kdharga\" = '".$kdharga."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_penghargaan\"(\"id_hist\",\"nrk\",\"kdharga\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_penghargaan_seq'),'".$nrk."','".$kdharga."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_penghargaan\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"kdharga\" = '".$kdharga."' 
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_PENGHARGAAN set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND KDHARGA = '".$kdharga."' ";

                $this->db->query($Quer);

                $pesan = "File Riwayat Penghargaan Berhasil Di Upload--";
            }
            elseif($jenis_riwayat == 'hukdis')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_hukdis\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tgsk\" = '".$TSK."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_hukdis\"(\"id_hist\",\"nrk\",\"tgsk\",\"nosk\",\"jenhukdis\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_hukdis_seq'),'".$nrk."','".$TSK."','".$nosk."',".$jenhukdis.",'".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_hukdis\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tgsk\" = '".$TSK."'
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_DISIPLIN_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TGSK =  TO_DATE('".$tgsk."', 'DD-MM-YYYY')";

                $this->db->query($Quer);

                $pesan = "File Riwayat Hukuman Disiplin Berhasil Di Upload--";
            }
            elseif($jenis_riwayat == 'hubkel')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_keluarga\" WHERE \"nrk\" = '".$nrk."' 
                AND \"hubkel\" = '".$hubklg."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_keluarga\"(\"id_hist\",\"nrk\",\"hubkel\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_keluarga_seq'),'".$nrk."','".$hubklg."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_keluarga\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"hubkel\" = '".$hubklg."' 
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_KELUARGA set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND HUBKEL = '".$hubklg."'";

                $this->db->query($Quer);

                $pesan = "File Riwayat Hubungan Keluarga Berhasil Di Upload ";
            }
            elseif($jenis_riwayat == 'jabatan')
            {
                $sql_cek = "SELECT COUNT(*) as jml FROM \"tbl_hist_pegawai_jabatan\" WHERE \"nrk\" = '".$nrk."' 
                AND \"tmt\" = '".$tmt."' AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'  ";
                $cek = $this->db2->query($sql_cek)->row();

                if($cek->jml<=0){
                    $sql = "INSERT INTO \"tbl_hist_pegawai_jabatan\"(\"id_hist\",\"nrk\",\"tmt\",\"kolok\",\"kojab\",\"file\",\"insert_by\",\"insert_date\") 
                        VALUES (NEXTVAL('tbl_hist_pegawai_jabatan_seq'),'".$nrk."','".$tmt."','".$kolok."','".$kojab."','".$gambar."','".$nrk."','".$date."')";
                    // echo $sql;exit();
                    $this->db2->query($sql);
                }else{
                    $sql = "UPDATE \"tbl_hist_pegawai_jabatan\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = '".$tmt."' AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'
                        ";
                    $this->db2->query($sql);
                }

                $Quer = "UPDATE PERS_JABATAN_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND TMT = '$tmt' AND KOLOK = '$kolok'  AND KOJAB = '$kojab'";

                $this->db->query($Quer);

                $pesan = "File Riwayat Jabatan Struktural Berhasil Di Upload ";

            }

            $status_property['parameter']       = 'pesan';
            $status_property['message']         = $pesan;
            $status_property['error_message']   = 'alert-success';
            $status_property['status_message']  = 'delete';
            $status_property['url_process']     = '';
            $status_property['error_icon']      = 'fa fa-info';
            $status_property['error_type']      = 'Sukses.'; 
            $this->Model_public->message_status($status_property);
            redirect('profile');

        ftp_close($ftp_conn);
        exit();
    }


    public function upload_file_revisi_riwayat()
    {
        $db2            = $this->load->database('DBfile', TRUE);
        date_default_timezone_set('Asia/Jakarta');
        $date           = date('Y-m-d');
        $time           = date('H-i-s');

        $ftp_server     = "10.15.34.186";
        $ftp_conn       = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login          = ftp_login($ftp_conn, "donna", "jayaraya21");

        $nrk            = $this->input->post('nrk',TRUE);
        $jenis_riwayat  = $this->input->post('jenis_riwayat',TRUE);
        $filelama       = $this->input->post('filelama',TRUE);
        $gambar         = $this->input->post('gambar',TRUE);
        // $filep          = $_FILES['gambar']['tmp_name']; 
        // $gambars        = basename($_FILES['gambar']['name']);
        if($jenis_riwayat == 'gapok')
        {
            $tmt            = $this->input->post('tmt',TRUE);
            $gapok          = $this->input->post('gapok',TRUE);
            $nama_folder    = 'gapok';
        }
        elseif($jenis_riwayat == 'jabatan')
        {
            $tmt            = $this->input->post('tmt',TRUE);
            $kolok          = $this->input->post('kolok',TRUE);
            $kojab          = $this->input->post('kojab',TRUE);
            $nama_folder    = 'jabatan';
        }
        elseif($jenis_riwayat == 'pendidikan_formal')
        {
            $kodik          = $this->input->post('kodik',TRUE);
            $jendik         = $this->input->post('jendik',TRUE);
            $tglijazah      = $this->input->post('tgl_ijazah',TRUE);
            $nama_folder    = 'pendidikan_formal';
        }
        elseif($jenis_riwayat == 'pendidikan_non_formal')
        {
            $kodik          = $this->input->post('kodik',TRUE);
            $jendik         = $this->input->post('jendik',TRUE);
            $tglijazah      = $this->input->post('tglijazah',TRUE);
            $no_ijazah      = $this->input->post('no_ijazah',TRUE);
            $nama_folder    = 'pendidikan_non_formal';
        }
        elseif($jenis_riwayat == 'pangkat')
        {
            $kopang         = $this->input->post('kopang',TRUE);
            $gapok          = $this->input->post('gapok',TRUE);
            $tmt            = $this->input->post('tmt',TRUE);
            $nama_folder    = 'pangkat';
        }
        elseif($jenis_riwayat == 'skp')
        {
            $thn            = $this->input->post('thn',TRUE);
            $nama_folder    = 'skp';
        }
        elseif($jenis_riwayat == 'cuti')
        {
            $jencuti            = $this->input->post('jencuti',TRUE);
            $tmt                = $this->input->post('tmt',TRUE);
            $tgakhir            = $this->input->post('tgakhir',TRUE);
            $tgupd              = $this->input->post('tgupd',TRUE);
            $nosk               = $this->input->post('nosk',TRUE);
            $teemte             = date('Y-m-d', strtotime($tmt));

            $nama_folder        = 'cuti';
        }
        elseif($jenis_riwayat == 'jbf')
        {
            $kojab              = $this->input->post('kojab',TRUE);
            $kolok              = $this->input->post('kolok',TRUE);
            $tmt                = $this->input->post('tmt',TRUE);
            $nama_folder        = 'jabatan_fungsional';
        }
        elseif($jenis_riwayat == 'penghargaan')
        {
            $kdharga            = $this->input->post('kdharga',TRUE);
            $nama_folder        = 'penghargaan';
        }
        elseif($jenis_riwayat == 'hukdis')
        {
            $tgsk               = $this->input->post('tgsk',TRUE);
            $jenhukdis          = $this->input->post('jenhukdis',TRUE);
            $TSK                = date('Y-m-d', strtotime($tgsk));
            $nama_folder        = 'hukdis';
        }
        elseif($jenis_riwayat == 'hubkel')
        {
            $hubklg             = $this->input->post('hubklg',TRUE);
            $nama_folder        = 'hubkel';
        }
        elseif($jenis_riwayat == 'jabatan')
        {
            $tmt                = $this->input->post('tmt',TRUE);
            $kolok              = $this->input->post('kolok',TRUE);
            $kojab              = $this->input->post('kojab',TRUE);

            $nama_folder        = 'jabatan';
        }




        // hapus File Lama Diserver Simpeg
        $do = unlink('./file/upload/'.$nama_folder.'/'. $filelama); 

        // UPLOAD FILE BARU DISERVER SIMPEG
        $config = array(
                'allowed_types' => '*',
                'upload_path'   => realpath('./file/upload/'.$nama_folder.'/'),
                'max_size'      => 5000000000000,
                // 'file_name'     => $gambars . '_' . $date . '_' . $time
            );

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $file = $this->upload->file_name;

            if ($this->upload->do_upload('gambar')) {
                $file1  = $this->upload->data();
                $file2  = $file1['file_name'];
                $gambar = $file2;
            }

            $from           = site_url().'/file/upload/'.$nama_folder.'/'.$gambar;
            $data_lama     = '/'.$nrk.'/'.$nama_folder.'/'.$filelama;
            $to             = '/'.$nrk.'/'.$nama_folder.'/'.$gambar;
            $dir            = '/'.$nrk.'/'.$nama_folder.'/';

            if($ftp_conn)
            {
                if($login)
                {

                    // HAPUS FILE LAMA DISERVER DOK ASN
                    ftp_delete($ftp_conn,$data_lama);

                    // UPLOAD FILE DISEVER DOK ASN
                    if (ftp_put($ftp_conn, $to, $from, FTP_ASCII)) 
                    { 
                        echo "<br>Berhasil Upload $gambar."; 
                    } 
                    else 
                    { 
                        echo "<br>Gagal Upload ($gambar : File $gambar)"; 
                        echo "<br>Gagal Upload ($gambar : File - $gambar)"; 
                        // echo "<br>Gagal Upload ($kojab : File $gambars123)"; 
                    } 
                }
                else
                {
                    echo "<br>Gagal Login Akun FTP"; 
                }
            }
            else
            {
                echo "Gagal Login FTP";
            }

            if($jenis_riwayat == 'gapok')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_gapok\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' AND \"gapok\" = '".$gapok."'
                    ";
                $this->db2->query($sql);

                $this->db->query("UPDATE PERS_RB_GAPOK_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND GAPOK = '$gapok'");
            }
            elseif($jenis_riwayat == 'pendidikan_formal')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_pend_formal\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' AND \"jendik\" = ".$jendik." AND \"kodik\" = '".$kodik."'
                    ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_PENDIDIKAN set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND JENDIK = '$jendik' AND KODIK = '$kodik' AND TGIJAZAH = TO_DATE('".$tglijazah."', 'DD-MM-YYYY')";

                $this->db->query($Quer);

                $pesan = "File Riwayat Pendidikan Formal Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'pendidikan_non_formal')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_pend_non_formal\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                AND \"jendik\" = ".$jendik." AND \"kodik\" = '".$kodik."'
                ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_PENDIDIKAN set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND JENDIK = '$jendik' AND KODIK = '$kodik'";

                $this->db->query($Quer);

                $pesan = "File Riwayat Pendidikan Non Formal Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'pangkat')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_pangkat\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                    AND \"tmt\" = '".$tmt."' AND \"kopang\" = '".$kopang."'
                    ";
                $this->db2->query($sql);

                $this->db->query("UPDATE PERS_PANGKAT_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND KOPANG = '$kopang'  AND GAPOK = '$gapok'");

                $pesan = "File Riwayat Pendidikan Non Formal Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'skp')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_skp\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tahun\" = '".$thn."' 
                        ";
                $this->db2->query($sql);

                $this->db->query("UPDATE PERS_skp set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND TAHUN = '$thn' ");

                $pesan = "File Riwayat SKP Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'jbf')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_jabatanf\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'
                        ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_JABATANF_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TMT = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND KOLOK = '".$kolok."'  AND KOJAB = '".$kojab."' ";
                $this->db->query($Quer);

                $pesan = "File Riwayat Jabatan Fungsional Berhasil Di Upload";
            }
            elseif($jenis_riwayat == 'cuti')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_cuti\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tmt\" = '".$teemte."'
                        ";
                    $this->db2->query($sql);
                
                $Quer = "UPDATE PERS_CUTI_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TGAKHIR = TO_DATE('".$tgakhir."', 'DD-MM-YYYY') AND TMT = TO_DATE('".$tmt."', 'DD-MM-YYYY') AND JENCUTI = '".$jencuti."' ";

                $this->db->query($Quer);

                $pesan = "File Riwayat CUTI Berhasil Di Upload--";
            }
            elseif($jenis_riwayat == 'penghargaan')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_penghargaan\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                    AND \"kdharga\" = '".$kdharga."' 
                    ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_PENGHARGAAN set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND KDHARGA = '".$kdharga."' ";

                $this->db->query($Quer);

                $pesan = "File Riwayat Penghargaan Berhasil Di Upload--";
            }
            elseif($jenis_riwayat == 'hukdis')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_hukdis\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                        AND \"tgsk\" = '".$TSK."'
                        ";
                    $this->db2->query($sql);

                $Quer = "UPDATE PERS_DISIPLIN_HIST set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND TGSK =  TO_DATE('".$tgsk."', 'DD-MM-YYYY')";

                $this->db->query($Quer);

                $pesan = "File Riwayat Hukuman Disiplin Berhasil Di Upload--";
            }
            elseif($jenis_riwayat == 'hubkel')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_keluarga\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                    AND \"hubkel\" = '".$hubklg."' 
                    ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_KELUARGA set FILE_UPLOAD = '".$gambar."', STATUS_FILE_UPLOAD = '1' WHERE NRK = '".$nrk."' AND HUBKEL = '".$hubklg."'";

                $this->db->query($Quer);

                $pesan = "File Riwayat Hubungan Keluarga Berhasil Di Upload ";
            }
            elseif($jenis_riwayat == 'jabatan')
            {
                $sql = "UPDATE \"tbl_hist_pegawai_jabatan\" SET \"file\" = '".$gambar."',\"update_by\" = '".$nrk."',\"update_date\" = '".$date."' WHERE \"nrk\" = '".$nrk."' 
                    AND \"tmt\" = '".$tmt."' AND \"kolok\" = '".$kolok."' AND \"kojab\" = '".$kojab."'
                    ";
                $this->db2->query($sql);

                $Quer = "UPDATE PERS_JABATAN_HIST set FILE_UPLOAD = '$gambar', STATUS_FILE_UPLOAD = '1' WHERE NRK = '$nrk' AND TMT = '$tmt' AND KOLOK = '$kolok'  AND KOJAB = '$kojab'";

                $this->db->query($Quer);

                $pesan = "File Riwayat Jabatan Struktural Berhasil Di Upload ";

            }

            $status_property['parameter']       = 'pesan';
            $status_property['message']         = $pesan;
            $status_property['error_message']   = 'alert-success';
            $status_property['status_message']  = 'delete';
            $status_property['url_process']     = '';
            $status_property['error_icon']      = 'fa fa-info';
            $status_property['error_type']      = 'Sukses.'; 
            $this->Model_public->message_status($status_property);
            redirect('profile');

        ftp_close($ftp_conn);
        exit();
    }



































}
?>            
