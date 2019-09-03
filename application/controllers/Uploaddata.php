<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploaddata extends CI_Controller {

	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
        $this->load->helper(array('form', 'url','download')); 

    	$this->load->library('session');
        
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','mdl');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->model('muploaddata','uploaddata');
        

    	if ($this->session->userdata('logged_in')) {            

            $session_data       = $this->session->userdata('logged_in');
            $this->user['id']     	= $session_data['id'];
            $this->user['username']  	= $session_data['username'];
            $this->user['user_group']     = $session_data['user_group'];
        }else{
			redirect(base_url().'index.php/login', 'refresh');
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
                //$datam['li']=$this->home->showMenu();
                $datam['activeMenu'] = "31335";
                $datam['activemn']=$this->infopegawai->initialMenu($this->user['user_group'],'uploaddata',0);
                $datam['inisial'] = 'uploaddata';
                
            // START THBL
            if(isset($_POST['thbl'])){
                $bulantahun = $_POST['thbl'];
            }else{
                $bulantahun = date('M Y');
            }
            $thbl = $this->convert->convertNamaBulanTahun($bulantahun);
            // END THBL

            $data['menu_select'] = $this->infopegawai->getMenuSelectHistNew($this->user['user_group']);
            $data['nrk'] = $nrk;
           
            $datam['nrk'] = $nrk;
            $datam['user_group'] = $this->user['user_group'];
            $data['user_id'] = $this->user['id'];
            $data['user_group'] = $this->user['user_group'];
            
                      
     

			$this->load->view('head/header',$this->user);
			$this->load->view('head/menu',$datam);
			$this->load->view('vuploaddata',$data);
            //$this->load->view('admin/pegawai_list',$data);
			$this->load->view('head/footer');

	}

     public function insertpanggaji()
    {
   
        // copy file library excel
        // copy file di third_party
        //$file = $_FILES['upload']['tmp_name'];
        
        $file = $_FILES['fFile']['tmp_name'];
        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
    
        $sheets = $objPHPExcel->getAllSheets();
        
        $allData = [];

        $worksheet = [];
        $ct=0;
        $ct1=0;
        $ct2=0;

        $sc1 =0;
        $sc2 =0;

        $jmldata = array();
        $cekerors1=array();
        $pter1=0;
        $cekerors2=array();
        $pter2=0;
        $cekdataada1 = array();
        
        $cekdataada2=array();
        
        foreach ($sheets as $sheet) 
        {

            $rowKeys = [];
            $data=[];
           

            foreach ($sheet->getRowIterator() as $row) {

                if (!$row->getCellIterator()->current()->getValue())
                    break;
                $cells = $row->getCellIterator();
                $rowData = [];
                
                foreach ($cells as $cell) {
                 //  
                    if ($row->getRowIndex() == 1)
                    {
                        if ($cell->getValue() == null)
                        {
                        
                        continue;
                        
                        }
                        else
                        {
                            $rowKeys[] = $cell->getValue();    
                        }
                        
                        
                    }
                        
                    else if($row->getRowIndex() > 1)
                    {
                         
                        $rowData[$rowKeys[$cell->columnIndexFromString($cell->getColumn()) - 1]] = $cell->getValue();
                        //var_dump($rowData[$rowKeys[$cell->columnIndexFromString($cell->getColumn()) - 1]] );
                    }
                    else
                    {
                         $rowData[$rowKeys[$cell->columnIndexFromString($cell->getColumn()) - 1]] = $cell->getValue();
                         

                    }
                }
                if ($row->getRowIndex() != 1)
                    $data[] = $rowData;
            }
            $worksheet[$ct]=$sheet->getTitle();
            
            
            $allData[$sheet->getTitle()] = $data;
            $ct++;
        }

        
        
        
        for($j = 0 ; $j<count($allData);$j++)
        {

            $jmldata[$j] = count($allData[$worksheet[$j]]);
            

            for($k=0 ; $k<count($allData[$worksheet[$j]]) ;$k++)
            {


                $isi = ($allData[$worksheet[$j]][$k]);
                // print_r($isi);
                // echo 'tes';exit();
                
                $arrIsi = array_values($isi);
                $compare = $arrIsi[2];



                if($compare == $allData[$worksheet[$j]][$k]['KOPANG'])
                {

                    if($isi['NRK'] != null && $isi['TMT']!=null && $isi['KOPANG']!=null && $isi['TTMASKER']!= null && $isi['BBMASKER']!= null && $isi['KOLOK']!= null && $isi['GAPOK']!= null&& $isi['PEJTT']!= null && $isi['NOSK']!= null && $isi['TGSK']!= null && $isi['USER_ID']!= null && $isi['TERM']!= null && $isi['TG_UPD']!= null)
                    {
                        $cekData = "SELECT * FROM SAMPLE_PERS_PANGKAT_HIST WHERE NRK='".$isi['NRK']."' AND TMT=TO_DATE('".$isi['TMT']."','DD-MM-YYYY') AND KOPANG='".$isi['KOPANG']."'";
                        
                        $excek = $this->db->query($cekData);
                        
                        if($excek)
                        {
                            $num = $excek->num_rows();

                            if($num == 0)
                            {   


                                $sql = "INSERT INTO PERS_PANGKAT_HIST(NRK,TMT,KOPANG,TTMASKER,BBMASKER,KOLOK,GAPOK,PEJTT,NOSK,TGSK,USER_ID,TERM,TG_UPD,KLOGAD,SPMU,TAHUN_REFGAJI,JENIS_SK,JENRUB)
                                        VALUES('".$isi['NRK']."',TO_DATE('".$isi['TMT']."','DD-MM-YYYY'),'".$isi['KOPANG']."',".$isi['TTMASKER'].",".$isi['BBMASKER'].",'".$isi['KOLOK']."',".$isi['GAPOK'].",".$isi['PEJTT'].",UPPER ('".$isi['NOSK']."'),TO_DATE('".$isi['TGSK']."','DD-MM-YYYY'),'".$isi['USER_ID']."','".$isi['TERM']."',TO_DATE('".$isi['TG_UPD']."','DD-MM-YYYY'),'".$isi['KLOGAD']."','".$isi['SPMU']."','".$isi['TAHUN_REFGAJI']."','".$isi['JENIS_SK']."','".$isi['JENRUB']."'
                                        )";
                                
                                $query = $this->db->query($sql);

                                if($query)
                                {
                                    $sc1++;
                                }
                                else
                                {
                                    $cekerors1[$pter1] = $k+1;
                                    $pter1++;
                                    continue;
                                }
                            }            
                            else
                            {

                                $cekdataada1[$ct1]= $k+1;
                                $ct1++;
                                continue;
                            }
                        }
                        else
                        {
                            $cekerors1[$pter1] = $k+1;
                            $pter1++;
                            continue;
                        }

                    }
                    else
                    {
                        $cekerors1[$pter1] = $k+1;
                        $pter1++;
                        
                        continue;


                    }

                }
                else if($compare == $allData[$worksheet[$j]][$k]['GAPOK'])
                {
                    
                    if($isi['NRK'] != null && $isi['TMT']!=null && $isi['GAPOK']!=null && $isi['JENRUB']!=null && $isi['KOPANG']!=null && $isi['TTMASKER']!=null && $isi['BBMASKER']!=null&& $isi['KOLOK']!=null && $isi['NOSK']!=null && $isi['TGSK']!=null && $isi['TTMASYAD']!=null && $isi['BBMASYAD']!=null && $isi['USER_ID']!=null && $isi['TERM']!=null && $isi['TG_UPD']!=null)
                    {
                        
                        $cekData = "SELECT * FROM SAMPLE_PERS_RB_GAPOK_HIST WHERE NRK='".$isi['NRK']."' AND TMT=TO_DATE('".$isi['TMT']."','DD-MM-YYYY') AND GAPOK=".$isi['GAPOK']."";
                        $excek = $this->db->query($cekData);
                        
                        if($excek)
                        {
                            $num = $excek->num_rows();

                            if($num == 0)
                            {   

                                $sql = "INSERT INTO PERS_RB_GAPOK_HIST(NRK,TMT,GAPOK,JENRUB,KOPANG,TTMASKER,BBMASKER,KOLOK,NOSK,TGSK,TTMASYAD,BBMASYAD,USER_ID,TERM,TG_UPD,KLOGAD,SPMU,TAHUN_REFGAJI,JENIS_SK)
                                        VALUES('".$isi['NRK']."',TO_DATE('".$isi['TMT']."','DD-MM-YYYY'),".$isi['GAPOK'].",".$isi['JENRUB'].",'".$isi['KOPANG']."',".$isi['TTMASKER'].",".$isi['BBMASKER'].",'".$isi['KOLOK']."',UPPER ('".$isi['NOSK']."'),TO_DATE('".$isi['TGSK']."','DD-MM-YYYY'),".$isi['TTMASYAD'].",".$isi['BBMASYAD'].",'".$isi['USER_ID']."','".$isi['TERM']."',TO_DATE('".$isi['TG_UPD']."','DD-MM-YYYY'),'".$isi['KLOGAD']."','".$isi['SPMU']."','".$isi['TAHUN_REFGAJI']."','".$isi['JENIS_SK']."'
                                        )";
                                   
                                $query = $this->db->query($sql);

                                if($query)
                                {
                                    $sc2++;
                                }
                                else
                                {
                                    $cekerors2[$pter2] = $k+1;
                                    $pter2++;
                                    continue;
                                }
                            }            
                            else
                            {
                                $cekdataada2[$ct2] = $k+1;
                                $ct2++;
                                continue;
                            }
                        }
                        else
                        {
                            $cekerors2[$pter2] = $k+1;
                            $pter2++;
                            continue;
                        }
                    }
                    else
                    {
                        $cekerors1[$pter2] = $k+1;
                        $pter2++;
                        continue;
                    }
                }
                else
                {
                    echo "hai";
                }
              
            }
        }

        $hasilsukses=0;
       
        if($ct1 == 0 && $ct2 == 0 && $jmldata[0] == $sc1 && $jmldata[1] == $sc2)
        {
            $hasilsukses =1;
        }
        else if($ct1 > 0 || $ct2>0 || $jmldata[0] <> $sc1 || $jmldata[1] <> $sc2)
        {
            $hasilsukses = -1;
        }
        else
        {
            $hasilsukses =0;   
        }

        $param = array('response' => $hasilsukses, 's1sukses' => $sc1, 's2sukses' => $sc2, 's1error' => $cekerors1, 's2error' => $cekerors2, 's1dup' => $cekdataada1 , 's2dup' => $cekdataada2);
        
        
        
        $myfile = fopen("./assets/log_upload/log_upload.txt", "w") or die("Unable to open file!");
        $date_now = date('Y-m-d H:i:s');
        $txt = "Laporan Upload Data Kolektif < ".$date_now." >";
        $txt.= "\r\n";
        $txt.= "_______________________________________";
        $txt.= "\r\n";
            $txt.=" Sheet ". $worksheet[0];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmldata[0];             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$sc1;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($cekerors1);
            $txt.= "\r\n";
            for($i=0;$i<count($cekerors1);$i++)
            {
                $roweror1 = $cekerors1[$i] +1;
                $txt.="         Error Row ".$roweror1;
            }
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($cekdataada1);
            $txt.= "\r\n";
            for($i=0;$i<count($cekdataada1);$i++)
            {   
                $rowdup1 = $cekdataada1[$i] +1;
                $txt.="         Duplikat Row ".$rowdup1;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="-----------------------------------------";
            $txt.= "\r\n";
            $txt.= "\r\n";

            $txt.=" Sheet ". $worksheet[1];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmldata[1];             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$sc2;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($cekerors2);
            $txt.= "\r\n";
            for($i=0;$i<count($cekerors2);$i++)
            {
                $roweror2 = $cekerors2[$i] +1;
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($cekdataada2);
            $txt.= "\r\n";
            for($i=0;$i<count($cekdataada2);$i++)
            {
                $rowdup2 = $cekdataada2[$i] +1;
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }

            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.=" -- akhir dari laporan -- ";
        fwrite($myfile,$txt);

        // echo fwrite($myfile,$txt);

        echo json_encode($param);
        //echo $hasilsukses;
    }


    public function insertsumpahpns()
    {
   		
        // copy file library excel
        // copy file di third_party
        //$file = $_FILES['upload']['tmp_name'];
        
        $file = $_FILES['fFile']['tmp_name'];

        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $countworksheet = $objPHPExcel->getSheetCount();

        $isiExcel = array();

        $titleworksheet = array();

        $jmlpeg1=0; $ctpeg1=0; $errpeg1=0; $arrErPeg1 = array();
        $jmljabhist=0; $ctjabhist=0; 
        $dupjabhist=0; $arrDupJabHist=array();$errjabhist=0; $arrErJabHist = array();
        $jmlpg=0; $ctpg=0; 
        $duppg=0; $arrDupPg=array();$errpg=0; $arrErPg = array();
        $jmlgp=0; $ctgp=0; 
        $dupgp=0; $arrDupGp=array();$errgp=0; $arrErGp = array();
        

        for($i=0;$i<$countworksheet;$i++)
        {
        	 $worksheet = $objPHPExcel->setActiveSheetIndex($i);

        	 $worksheetTitle=$worksheet->getTitle();
        	 $titleworksheet[$i] = $worksheetTitle;
        	 $highestRow=$worksheet->getHighestRow();
        	
        	 //PERS_PEGAWAI1
        	 if($i == 0)
        	 {
        	 	$jmlpeg1 = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('N');
        	 }
        	 else if($i == 1)
        	 {
        	 	$jmljabhist = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('V');
        	 }
        	 /*else if($i == 2)
        	 {
        	 	
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('V');
        	 }
        	 else if($i == 3)
        	 {
        	 	$jmlpg = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('R');
        	 }
        	 else if($i == 4)
        	 {
        	 	$jmlgp = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('S');
        	 }*/

        	 else if($i == 2)
        	 {
        	 	$jmlpg = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('R');
        	 }
        	 else if($i == 3)
        	 {
        	 	$jmlgp = $highestRow-1;
        	 	$highestColumn=PHPExcel_Cell::columnIndexFromString('S');
        	 }
        	 $isiExcel[$i] = array($worksheetTitle,$highestRow,$highestColumn);
        	 $dataperrow;

				for($r=2 ;$r<=$highestRow;$r++ )
				{
					$dataperrow= array();
					for($c =0;$c<$highestColumn;$c++)
					{
						
						$dataperrow[$c] = $worksheet->getCellByColumnAndRow($c, $r)->getValue();

						if($c == $highestColumn - 1)
						{
							if($highestColumn == count($dataperrow))
							{
								if($i == 0)
								{
									
									$nrk = $dataperrow[0];
									$klogad = $dataperrow[1];
									$nama = $dataperrow[2];
									$titel = $dataperrow[3];
									$stapeg = $dataperrow[4];
									$tmtstapeg = $dataperrow[5];
									$user_id = $dataperrow[6];
									$term = $dataperrow[7];
									$tg_upd = $dataperrow[8];
									$kolok = $dataperrow[9];
									$kojab = $dataperrow[10];
									$titeldepan = $dataperrow[11];
									$kd = $dataperrow[12];
									$spmu = $dataperrow[13];

									
									$sql_cek="SELECT * FROM PERS_PEGAWAI1 WHERE NRK='".$nrk."'";
									$query_cek = $this->db->query($sql_cek);

									if($query_cek)
									{
										$value_cek = $query_cek->num_rows();

										if($value_cek == 1)
										{
											if($nrk != null && $nama != null && $stapeg!=null && $user_id != null && $term!= null && $tg_upd != null)
											{
												$sql_update = "UPDATE PERS_PEGAWAI1 SET KLOGAD='".$klogad."',NAMA='".$nama."', TITEL='".$titel."', STAPEG=".$stapeg.", TMT_STAPEG=TO_DATE('".$tmtstapeg."','DD-MM-YYYY'),USER_ID ='".$user_id."',TERM='".$term."',TG_UPD = TO_DATE('".$tg_upd."','DD-MM-YYYY'),KOLOK='".$kolok."', KOJAB='".$kojab."',TITELDEPAN='".$titeldepan."',KD='".$kd."',SPMU='".$spmu."' WHERE NRK='".$nrk."'";
												// echo $sql_update;exit();
												$query_update = $this->db->query($sql_update);	

												if($query_update)
												{
													$ctpeg1++;
												}
												else
												{
													$arrErPeg1[$errpeg1] = $r;
													$errpeg1++;
												}
											}
											else
											{
												$arrErPeg1[$errpeg1] = $r;
												$errpeg1++;
											}
											
										}
										else
										{
											$arrErPeg1[$errpeg1] = $r;
											$errpeg1++;
										}
									}
									else
									{
										$arrErPeg1[$errpeg1] = $r;
										$errpeg1++;
									}
								}//end pegawai1

								else if($i == 1) 
								{
									
									$nrk = $dataperrow[0];
									$tmt = $dataperrow[1];
									$kolok = $dataperrow[2];
									$kojab = $dataperrow[3];
									$kdsort = $dataperrow[4];
									$tgakhir = $dataperrow[5];
									$kopang = $dataperrow[6];
									$eselon = $dataperrow[7];
									$pejtt = $dataperrow[8];
									$nosk = $dataperrow[9];
									$tgsk = $dataperrow[10];
									$kredit = $dataperrow[11];
									$status = $dataperrow[12];
									$user_id = $dataperrow[13];
									$term = $dataperrow[14];
									$tg_upd = $dataperrow[15];
									$ckojabf = $dataperrow[16];
									$tmtpensiun = $dataperrow[17];
									$klogad = $dataperrow[18];
									$spmu = $dataperrow[19];
									$neselon2 = $dataperrow[20];
									$jenis_sk = $dataperrow[21];
									
									$sql_cek="SELECT * FROM PERS_JABATAN_HIST WHERE NRK='".$nrk."' AND TMT = TO_DATE('".$tmt."','DD-MM-YYYY') AND KOLOK = '".$kolok."' AND KOJAB ='".$kojab."'";
									
									$query_cek = $this->db->query($sql_cek);

									if($query_cek)
									{
										$value_cek = $query_cek->num_rows();
										
										if($value_cek == 0)
										{
											if($nrk != null && $tmt != null && $kolok!=null && $kojab != null && $kdsort!= null && $kopang != null && $eselon != null && $pejtt != null && $nosk != null && $tgsk != null && $kredit != null && $status!=null && $user_id != null && $term != null && $tg_upd != null) 
											{
												$sql_insjab = "INSERT INTO PERS_JABATAN_HIST(NRK,TMT,KOLOK,KOJAB,KDSORT,TGAKHIR,KOPANG,ESELON,PEJTT,NOSK,TGSK,KREDIT,STATUS,USER_ID,TERM,TG_UPD,CKOJABF,KLOGAD,SPMU,TMTPENSIUN,NESELON2,JENIS_SK) 
                								VALUES ('".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),'".$kolok."','".$kojab."','".$kdsort."',TO_DATE('".$tgakhir."', 'DD-MM-YY'),'".$kopang."','".$eselon."',".$pejtt.",UPPER('".$nosk."'),TO_DATE('".$tgsk."', 'DD-MM-YYYY'),".$kredit.",".$status.",'".$user_id."','".$term."', TO_DATE('".$tg_upd."', 'DD-MM-YYYY'),'".$ckojabf."','".$klogad."','".$spmu."',TO_DATE('".$tmtpensiun."', 'DD-MM-YYYY'),'".$neselon2."','".$jenis_sk."')";
												
												$query_insjab = $this->db->query($sql_insjab);	

												if($query_insjab)
												{
													$ctjabhist++;
												}
												else
												{
													$arrErJabHist[$errjabhist] = $r;
													$errjabhist++;
												}
											}
											else
											{
												$arrErJabHist[$errjabhist] = $r;
												$errjabhist++;
											}
											
										}
										else
										{
											$arrDupJabHist[$dupjabhist] = $r;
											$dupjabhist++;
										}
									}
									else
									{
										$arrErJabHist[$errjabhist] = $r;
										$errjabhist++;
									}
								}// jabatan_hist
								/*else if($i == 2)
								{
									continue;
								}*/
								// pangkat hist
								else if($i == 2)
								{
									$nrk = $dataperrow[0];
									$tmt = $dataperrow[1];
									$kopang = $dataperrow[2];
									$ttmasker = $dataperrow[3];
									$bbmasker = $dataperrow[4];
									$kolok = $dataperrow[5];
									$gapok = $dataperrow[6];
									$pejtt = $dataperrow[7];
									$nosk = $dataperrow[8];
									$tgsk = $dataperrow[9];
									$user_id = $dataperrow[10];
									$term = $dataperrow[11];
									$tg_upd= $dataperrow[12];
									$klogad = $dataperrow[13];
									$spmu= $dataperrow[14];
									$tahun_refgaji = $dataperrow[15];
									$jenis_sk = $dataperrow[16];
									$jenrub = $dataperrow[17];
									
									
									$sql_cek="SELECT * FROM PERS_PANGKAT_HIST WHERE NRK='".$nrk."' AND TMT = TO_DATE('".$tmt."','DD-MM-YYYY') AND KOPANG = '".$kopang."' ";
									
									$query_cek = $this->db->query($sql_cek);

									if($query_cek)
									{
										$value_cek = $query_cek->num_rows();
										
										if($value_cek == 0)
										{
											if($nrk != null && $tmt != null && $kopang!=null && $ttmasker != null && $bbmasker!= null && $kolok != null && $gapok != null && $pejtt != null && $nosk != null && $tgsk != null && $user_id != null && $term != null && $tg_upd != null) 
											{
												$sql_inspg = "INSERT INTO PERS_PANGKAT_HIST(NRK,TMT,KOPANG,TTMASKER,BBMASKER,KOLOK,GAPOK,PEJTT,NOSK,TGSK,USER_ID,TERM,TG_UPD, KLOGAD, SPMU,TAHUN_REFGAJI,JENIS_SK,JENRUB) 
                											VALUES ('".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),'".$kopang."',".$ttmasker.",".$bbmasker.",'".$kolok."',".$gapok.",".$pejtt.",UPPER('".$nosk."'),TO_DATE('".$tgsk."', 'DD-MM-YYYY'),'".$user_id."','".$term."', TO_DATE('".$tg_upd."', 'DD-MM-YYYY'),'".$klogad."','".$spmu."','".$tahun_refgaji."','".$jenis_sk."',".$jenrub.")";
												
												$query_inspg = $this->db->query($sql_inspg);	

												if($query_inspg)
												{
													$ctpg++;
												}
												else
												{
													$arrErPg[$errpg] = $r;
													$errpg++;
												}
											}
											else
											{
												$arrErPg[$errpg] = $r;
												$errpg++;
											}
											
										}
										else
										{
											$arrDupPg[$duppg] = $r;
											$duppg++;
										}
									}
									else
									{
										$arrErPg[$errpg] = $r;
										$errpg++;
										
									}
								}// end pangkat hist

								// gapok hist
								else if($i == 3)
								{
									$nrk = $dataperrow[0];
									$tmt = $dataperrow[1];
									$gapok = $dataperrow[2];
									$jenrub = $dataperrow[3];
									$kopang = $dataperrow[4];
									$ttmasker = $dataperrow[5];
									$bbmasker = $dataperrow[6];
									$kolok = $dataperrow[7];
									$nosk = $dataperrow[8];
									$tgsk = $dataperrow[9];
									$ttmasyad = $dataperrow[10];
									$bbmasyad = $dataperrow[11];
									$user_id= $dataperrow[12];
									$term = $dataperrow[13];
									$tg_upd = $dataperrow[14];
									$klogad = $dataperrow[15];
									$spmu = $dataperrow[16];
									$tahun_refgaji = $dataperrow[17];
									$jenis_sk = $dataperrow[18];
									
									
									$sql_cek="SELECT * FROM PERS_RB_GAPOK_HIST WHERE NRK='".$nrk."' AND TMT = TO_DATE('".$tmt."','DD-MM-YYYY') AND GAPOK = ".$gapok."";
									
									$query_cek = $this->db->query($sql_cek);

									if($query_cek)
									{
										$value_cek = $query_cek->num_rows();
										
										if($value_cek == 0)
										{
											if($nrk != null && $tmt != null && $gapok!=null && $jenrub != null && $kopang!= null && $ttmasker != null && $bbmasker != null && $kolok != null && $nosk != null && $tgsk != null && $ttmasyad != null && $bbmasyad != null && $user_id != null && $term != null && $tg_upd != null) 
											{
												$sql_insgp = "INSERT INTO PERS_RB_GAPOK_HIST(NRK,TMT,GAPOK,JENRUB,KOPANG,TTMASKER,BBMASKER,KOLOK,NOSK,TGSK,TTMASYAD,BBMASYAD,USER_ID,TERM,TG_UPD,KLOGAD,SPMU,TAHUN_REFGAJI) 
													VALUES ('".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),".$gapok.",".$jenrub.",'".$kopang."',".$ttmasker.",".$bbmasker.",'".$kolok."',UPPER('".$nosk."'),TO_DATE('".$tgsk."', 'DD-MM-YYYY'),".$ttmasyad.",".$bbmasyad.",'".$user_id."','".$term."', TO_DATE('".$tg_upd."', 'DD-MM-YYYY'),'".$klogad."','".$spmu."','".$tahun_refgaji."')";
												
												$query_insgp = $this->db->query($sql_insgp);

												if($query_insgp)
												{
													$ctgp++;
												}	
												else
												{
													$arrErGp[$errgp] = $r;
													$errgp++;
												}
											}
											else
											{
												$arrErGp[$errgp] = $r;
												$errgp++;
											}
											
										}
										else
										{
											$arrDupGp[$dupgp] = $r;
											$dupgp++;
										}
									}
									else
									{
										$arrErGp[$errgp] = $r;
										$errgp++;
									}
								}// end gapok hist

							}
						}
					}//end looping col
				}// end looping row

       }

        $hasilsukses=-1;
        $x ;

       	/*var_dump($ctpeg1);
       	var_dump($jmlpeg1);
       	var_dump($ctjabhist);
       	var_dump($jmljabhist);
       	var_dump($ctpg);
       	var_dump($jmlpg);
       	var_dump($ctgp);
       	var_dump($jmlgp);exit;*/
        if($ctpeg1 == $jmlpeg1 && $ctjabhist == $jmljabhist && $ctpg == $jmlpg && $ctgp == $jmlgp)
        {
            $hasilsukses =1;
            $x = 'ha';
        }
        else if($errpeg1 > 0 || $errjabhist > 0 || $errpg > 0 || $errgp > 0)
        {
            $hasilsukses = -1;
            $x = 'hi';
        }
        else if($dupjabhist>0 || $duppg>0 || $dupgp>0)
        {
        	$hasilsukses = 0;
        	$x = 'hu';
        }
        else
        {
            $hasilsukses =-1;   
            $x = 'he';
        }
        
        
        
       
        
        $myfile = fopen("./assets/log_upload/log_upload_pns.txt", "w") or die("Unable to open file!");

        $date_now = date('Y-m-d H:i:s');
        $txt = "Laporan Upload Data Kolektif < ".$date_now." >";
        $txt.= "\r\n";
        $txt.= "_______________________________________";
        $txt.= "\r\n";

        
        	//laporan pegawai1

            $txt.=" Sheet ". $titleworksheet[0];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmlpeg1;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctpeg1;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErPeg1);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErPeg1);$i++)
            {
                $roweror1 = $arrErPeg1[$i] ;
                $txt.="         Error Row ".$roweror1;
                $txt.= "\r\n";
            }
            
            $txt.= "\r\n";
            
            //end laporan pegawai1

            $txt.="-----------------------------------------";
            
            //laporan jabhist
            $txt.= "\r\n";
            $txt.= "\r\n";
			$txt.=" Sheet ". $titleworksheet[1];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmljabhist;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctjabhist;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErJabHist);$i++)
            {
                $roweror2 = $arrErJabHist[$i];
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($arrDupJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrDupJabHist);$i++)
            {
                $rowdup2 = $arrDupJabHist[$i];
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }
			$txt.= "\r\n";
			//end laporan jabhist

			
			//laporan pangkat
            $txt.= "\r\n";
            $txt.= "\r\n";
			$txt.=" Sheet ". $titleworksheet[2];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmlpg;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctpg;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErPg);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErPg);$i++)
            {
                $roweror2 = $arrErPg[$i];
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($arrDupPg);
            $txt.= "\r\n";
            for($i=0;$i<count($arrDupPg);$i++)
            {
                $rowdup2 = $arrDupPg[$i];
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }
			$txt.= "\r\n";
			//end laporan pangkat    

			//laporan gapok
            $txt.= "\r\n";
            $txt.= "\r\n";
			$txt.=" Sheet ". $titleworksheet[3];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmlgp;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctgp;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErGp);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErGp);$i++)
            {
                $roweror2 = $arrErGp[$i];
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($arrDupGp);
            $txt.= "\r\n";
            for($i=0;$i<count($arrDupGp);$i++)
            {
                $rowdup2 = $arrDupGp[$i];
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }
			$txt.= "\r\n";
			//end laporan gapok        

            $txt.= "\r\n";
			$txt.=" -- akhir dari laporan -- ";
        fwrite($myfile,$txt);
        
        //var_dump($hasilsukses);exit;
       /*$param = array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist,'pangkatsukses' => $ctpg , 'pangkaterror' => count($arrErPg), 'pangkatdup' => $duppg,'gapoksukses' => $ctgp , 'gapokerror' => count($arrErGp), 'gapokdup' => $dupgp);*/

        echo json_encode(array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist,'pangkatsukses' => $ctpg , 'pangkaterror' => count($arrErPg), 'pangkatdup' => $duppg,'gapoksukses' => $ctgp , 'gapokerror' => count($arrErGp), 'gapokdup' => $dupgp));
      
        //echo $hasilsukses;
    }

    public function insertpensiun()
    {
        
        // copy file library excel
        // copy file di third_party
        //$file = $_FILES['upload']['tmp_name'];
        
        $file = $_FILES['fFile']['tmp_name'];

        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $countworksheet = $objPHPExcel->getSheetCount();

        $isiExcel = array();

        $titleworksheet = array();

        $jmlpeg1=0; $ctpeg1=0; $errpeg1=0; $arrErPeg1 = array();
        $jmljabhist=0; $ctjabhist=0; 
        $dupjabhist=0; $arrDupJabHist=array();$errjabhist=0; $arrErJabHist = array();
       
        

        for($i=0;$i<$countworksheet;$i++)
        {
             $worksheet = $objPHPExcel->setActiveSheetIndex($i);

             $worksheetTitle=$worksheet->getTitle();
             $titleworksheet[$i] = $worksheetTitle;
             $highestRow=$worksheet->getHighestRow();
            
             //PERS_PEGAWAI1
             if($i == 0)
             {
                $jmlpeg1 = $highestRow-1;
                $highestColumn=PHPExcel_Cell::columnIndexFromString('D');
             }
             else if($i == 1)
             {
                $jmljabhist = $highestRow-1;
                $highestColumn=PHPExcel_Cell::columnIndexFromString('P');
             }
             $isiExcel[$i] = array($worksheetTitle,$highestRow,$highestColumn);
             $dataperrow;


                for($r=2 ;$r<=$highestRow;$r++ )
                {
                    $dataperrow= array();
                    for($c =0;$c<$highestColumn;$c++)
                    {
                        
                        $dataperrow[$c] = $worksheet->getCellByColumnAndRow($c, $r)->getValue();
                        // print_r($dataperrow);exit();
                        if($c == $highestColumn - 1)
                        {
                            if($highestColumn == count($dataperrow))
                            {
                                if($i == 0)
                                {
                                    // echo $highestColumn;exit();
                                    $nrk = $dataperrow[0];
                                    $klogad = $dataperrow[1];
                                    $tmtpensiun = $dataperrow[2];
                                    $kojab = $dataperrow[3];
                                    
                                    
                                    $sql_cek="SELECT * FROM PERS_PEGAWAI1 WHERE NRK='".$nrk."'";
                                    $query_cek = $this->db->query($sql_cek);

                                    if($query_cek)
                                    {
                                        $value_cek = $query_cek->num_rows();

                                        if($value_cek == 1)
                                        {
                                            if($nrk != null && $klogad != null && $tmtpensiun!=null)
                                            {
                                                $sql_update = "UPDATE PERS_PEGAWAI1 SET KLOGAD='".$klogad."', TMTPENSIUN=TO_DATE('".$tmtpensiun."','DD-MM-YYYY'),KOJAB='".$kojab."' WHERE NRK='".$nrk."'";

                                                // echo $sql_update;exit();
                                                
                                                $query_update = $this->db->query($sql_update);  

                                                if($query_update)
                                                {
                                                    $ctpeg1++;
                                                }
                                                else
                                                {
                                                    $arrErPeg1[$errpeg1] = $r;
                                                    $errpeg1++;
                                                }
                                            }
                                            else
                                            {
                                                $arrErPeg1[$errpeg1] = $r;
                                                $errpeg1++;
                                            }
                                            
                                        }
                                        else
                                        {
                                            $arrErPeg1[$errpeg1] = $r;
                                            $errpeg1++;
                                        }
                                    }
                                    else
                                    {
                                        $arrErPeg1[$errpeg1] = $r;
                                        $errpeg1++;
                                    }
                                }//end pegawai1

                                else if($i == 1) 
                                {
                                    
                                    $nrk = $dataperrow[0];
                                    $tmt = $dataperrow[1];
                                    $kolok = $dataperrow[2];
                                    $kojab = $dataperrow[3];
                                    $kdsort = $dataperrow[4];
                                    $tgakhir = $dataperrow[5];
                                    $kopang = $dataperrow[6];
                                    $eselon = $dataperrow[7];
                                    $pejtt = $dataperrow[8];
                                    $nosk = $dataperrow[9];
                                    $tgsk = $dataperrow[10];
                                    $kredit = $dataperrow[11];
                                    $status = $dataperrow[12];
                                    $user_id = $dataperrow[13];
                                    $term = $dataperrow[14];
                                    $tg_upd = $dataperrow[15];
                                    $ckojabf = '';
                                    $tmtpensiun = '';
                                    $klogad = '';
                                    $spmu = '';
                                    $neselon2 = '';
                                    $jenis_sk = '';
                                    
                                    $sql_cek="SELECT * FROM PERS_JABATAN_HIST WHERE NRK='".$nrk."' AND TMT = TO_DATE('".$tmt."','DD-MM-YYYY') AND KOLOK = '".$kolok."' AND KOJAB ='".$kojab."'";
                                    // echo $sql_cek;exit();
                                    $query_cek = $this->db->query($sql_cek);
                                    // echo $query_cek;exit();
                                    if($query_cek)
                                    {
                                        // echo 'masuk';exit();
                                        $value_cek = $query_cek->num_rows();
                                        
                                        if($value_cek == 0)
                                        {
                                           // echo $value_cek;
                                            if($nrk != null && $tmt != null && $kolok!=null && $kojab != null && $kdsort!= null && $kopang != null && $eselon != null && $pejtt != null && $nosk != null && $tgsk != null && $kredit != null && $status!=null && $user_id != null && $term != null && $tg_upd != null

                                            ) 
                                            {
                                                
                                                $sql_insjab = "INSERT INTO PERS_JABATAN_HIST(NRK,TMT,KOLOK,KOJAB,KDSORT,TGAKHIR,KOPANG,ESELON,PEJTT,NOSK,TGSK,KREDIT,STATUS,USER_ID,TERM,TG_UPD,CKOJABF,KLOGAD,SPMU,TMTPENSIUN,NESELON2,JENIS_SK) 
                                                VALUES ('".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),'".$kolok."','".$kojab."','".$kdsort."',TO_DATE('".$tgakhir."', 'DD-MM-YY'),'".$kopang."','".$eselon."',".$pejtt.",UPPER('".$nosk."'),TO_DATE('".$tgsk."', 'DD-MM-YYYY'),".$kredit.",".$status.",'".$user_id."','".$term."', TO_DATE('".$tg_upd."', 'DD-MM-YYYY'),'".$ckojabf."','".$klogad."','".$spmu."',TO_DATE('".$tmtpensiun."', 'DD-MM-YYYY'),'".$neselon2."','".$jenis_sk."')";
                                                // echo $sql_insjab; exit();
                                                $query_insjab = $this->db->query($sql_insjab);  

                                                if($query_insjab)
                                                {
                                                    $ctjabhist++;
                                                }
                                                else
                                                {
                                                    $arrErJabHist[$errjabhist] = $r;
                                                    $errjabhist++;
                                                }
                                            }
                                            else
                                            {
                                                
                                                $arrErJabHist[$errjabhist] = $r;
                                                $errjabhist++;
                                            }
                                            

                                        }
                                        else
                                        {
                                            $arrDupJabHist[$dupjabhist] = $r;
                                            $dupjabhist++;
                                        }
                                    }
                                    else
                                    {
                                        $arrErJabHist[$errjabhist] = $r;
                                        $errjabhist++;
                                    }
                                }// jabatan_hist
                                
                                

                            }
                        }
                    }//end looping col
                }// end looping row

                // print_r($dataperrow);

                // exit();

       }

        $hasilsukses=-1;
        $x ;

        /*var_dump($ctpeg1);
        var_dump($jmlpeg1);
        var_dump($ctjabhist);
        var_dump($jmljabhist);
        var_dump($ctpg);
        var_dump($jmlpg);
        var_dump($ctgp);
        var_dump($jmlgp);exit;*/
        if($ctpeg1 == $jmlpeg1 && $ctjabhist == $jmljabhist && $errpeg1 == 0 && $errjabhist == 0 && $dupjabhist == 0)
        {
            $hasilsukses =1;
            $x = 'ha';
        }
        else if( $errpeg1 > 0 || $errjabhist > 0)
        {
            $hasilsukses = -1;
            $x = 'hi';
        }
        else if($dupjabhist>0 )
        {
            $hasilsukses = 0;
            $x = 'hu';
        }
        else
        {
            $hasilsukses =-1;   
            $x = 'he';
        }
        
        
        
       
        
        $myfile = fopen("./assets/log_upload/log_pensiun.txt", "w") or die("Unable to open file!");

        $date_now = date('Y-m-d H:i:s');
        $txt = "Laporan Upload Data Kolektif < ".$date_now." >";
        $txt.= "\r\n";
        $txt.= "_______________________________________";
        $txt.= "\r\n";

        
            //laporan pegawai1

            $txt.=" Sheet ". $titleworksheet[0];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmlpeg1;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctpeg1;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErPeg1);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErPeg1);$i++)
            {
                $roweror1 = $arrErPeg1[$i] ;
                $txt.="         Error Row ".$roweror1;
                $txt.= "\r\n";
            }
            
            $txt.= "\r\n";
            
            //end laporan pegawai1

            $txt.="-----------------------------------------";
            
            //laporan jabhist
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.=" Sheet ". $titleworksheet[1];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmljabhist;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctjabhist;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErJabHist);$i++)
            {
                $roweror2 = $arrErJabHist[$i];
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($arrDupJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrDupJabHist);$i++)
            {
                $rowdup2 = $arrDupJabHist[$i];
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            //end laporan jabhist

            $txt.= "\r\n";
            $txt.=" -- akhir dari laporan -- ";
        fwrite($myfile,$txt);
        
        
       /*$param = array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist,'pangkatsukses' => $ctpg , 'pangkaterror' => count($arrErPg), 'pangkatdup' => $duppg,'gapoksukses' => $ctgp , 'gapokerror' => count($arrErGp), 'gapokdup' => $dupgp);*/

        echo json_encode(array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist));
      
        //echo $hasilsukses;
    }

    public function insertjabataneselon()
    {
        
        // copy file library excel
        // copy file di third_party
        //$file = $_FILES['upload']['tmp_name'];
        
        $file = $_FILES['fFile']['tmp_name'];

        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $countworksheet = $objPHPExcel->getSheetCount();

        $isiExcel = array();

        $titleworksheet = array();

        $jmlpeg1=0; $ctpeg1=0; $errpeg1=0; $arrErPeg1 = array();
        $jmljabhist=0; $ctjabhist=0; 
        $dupjabhist=0; $arrDupJabHist=array();$errjabhist=0; $arrErJabHist = array();
       
        

        for($i=0;$i<$countworksheet;$i++)
        {
             $worksheet = $objPHPExcel->setActiveSheetIndex($i);

             $worksheetTitle=$worksheet->getTitle();
             $titleworksheet[$i] = $worksheetTitle;
             $highestRow=$worksheet->getHighestRow();
            
             //PERS_PEGAWAI1
             if($i == 0)
             {
                $jmlpeg1 = $highestRow-1;
                $highestColumn=PHPExcel_Cell::columnIndexFromString('D');
             }
             else if($i == 1)
             {
                $jmljabhist = $highestRow-1;
                $highestColumn=PHPExcel_Cell::columnIndexFromString('P');
             }
             $isiExcel[$i] = array($worksheetTitle,$highestRow,$highestColumn);
             $dataperrow;

                for($r=2 ;$r<=$highestRow;$r++ )
                {
                    $dataperrow= array();
                    for($c =0;$c<$highestColumn;$c++)
                    {
                        
                        $dataperrow[$c] = $worksheet->getCellByColumnAndRow($c, $r)->getValue();

                        if($c == $highestColumn - 1)
                        {
                            if($highestColumn == count($dataperrow))
                            {
                                if($i == 0)
                                {
                                    
                                    $nrk = $dataperrow[0];
                                    $klogad = $dataperrow[1];
                                    $user_id = $dataperrow[2];
                                    $tg_upd = $dataperrow[3];
                                    
                                    
                                    $sql_cek="SELECT * FROM PERS_PEGAWAI1 WHERE NRK='".$nrk."'";
                                    $query_cek = $this->db->query($sql_cek);

                                    if($query_cek)
                                    {
                                        $value_cek = $query_cek->num_rows();

                                        if($value_cek == 1)
                                        {
                                            if($nrk != null && $klogad != null && $user_id!=null && $tg_upd!=null)
                                            {
                                                $sql_update = "UPDATE PERS_PEGAWAI1 SET KLOGAD='".$klogad."', USER_ID = '".$user_id."', TG_UPD =TO_DATE('".$tg_upd."','DD-MM-YYYY') WHERE NRK='".$nrk."'";
                                                //echo $sql_update;
                                                $query_update = $this->db->query($sql_update);  

                                                if($query_update)
                                                {
                                                    $ctpeg1++;
                                                }
                                                else
                                                {
                                                    $arrErPeg1[$errpeg1] = $r;
                                                    $errpeg1++;
                                                }
                                            }
                                            else
                                            {
                                                $arrErPeg1[$errpeg1] = $r;
                                                $errpeg1++;
                                            }
                                            
                                        }
                                        else
                                        {
                                            $arrErPeg1[$errpeg1] = $r;
                                            $errpeg1++;
                                        }
                                    }
                                    else
                                    {
                                        $arrErPeg1[$errpeg1] = $r;
                                        $errpeg1++;
                                    }
                                }//end pegawai1

                                else if($i == 1) 
                                {
                                    
                                    $nrk = $dataperrow[0];
                                    $tmt = $dataperrow[1];
                                    $kolok = $dataperrow[2];
                                    $kojab = $dataperrow[3];
                                    $kdsort = $dataperrow[4];
                                    $tgakhir = $dataperrow[5];
                                    $kopang = $dataperrow[6];
                                    $eselon = $dataperrow[7];
                                    $pejtt = $dataperrow[8];
                                    $nosk = $dataperrow[9];
                                    $tgsk = $dataperrow[10];
                                    $kredit = $dataperrow[11];
                                    $status = $dataperrow[12];
                                    $user_id = $dataperrow[13];
                                    $term = $dataperrow[14];
                                    $tg_upd = $dataperrow[15];
                                    $ckojabf = '';
                                    $tmtpensiun = '';
                                    $klogad = '';
                                    $spmu = '';
                                    $neselon2 = '';
                                    $jenis_sk = '';
                                    
                                    $sql_cek="SELECT * FROM PERS_JABATAN_HIST WHERE NRK='".$nrk."' AND TMT = TO_DATE('".$tmt."','DD-MM-YYYY') AND KOLOK = '".$kolok."' AND KOJAB ='".$kojab."'";
                                    
                                    $query_cek = $this->db->query($sql_cek);

                                    if($query_cek)
                                    {
                                        $value_cek = $query_cek->num_rows();
                                        
                                        if($value_cek == 0)
                                        {
                                           
                                            if($nrk != null && $tmt != null && $kolok!=null && $kojab != null && $kdsort!= null && $kopang != null && $eselon != null && $pejtt != null && $nosk != null && $tgsk != null && $kredit != null && $status!=null && $user_id != null && $term != null && $tg_upd != null

                                            ) 
                                            {
                                                
                                                $sql_insjab = "INSERT INTO PERS_JABATAN_HIST(NRK,TMT,KOLOK,KOJAB,KDSORT,TGAKHIR,KOPANG,ESELON,PEJTT,NOSK,TGSK,KREDIT,STATUS,USER_ID,TERM,TG_UPD,CKOJABF,KLOGAD,SPMU,TMTPENSIUN,NESELON2,JENIS_SK) 
                                                VALUES ('".$nrk."',TO_DATE('".$tmt."', 'DD-MM-YYYY'),'".$kolok."','".$kojab."','".$kdsort."',TO_DATE('".$tgakhir."', 'DD-MM-YY'),'".$kopang."','".$eselon."',".$pejtt.",UPPER('".$nosk."'),TO_DATE('".$tgsk."', 'DD-MM-YYYY'),".$kredit.",".$status.",'".$user_id."','".$term."', TO_DATE('".$tg_upd."', 'DD-MM-YYYY'),'".$ckojabf."','".$klogad."','".$spmu."',TO_DATE('".$tmtpensiun."', 'DD-MM-YYYY'),'".$neselon2."','".$jenis_sk."')";
                                                
                                                $query_insjab = $this->db->query($sql_insjab);  

                                                if($query_insjab)
                                                {
                                                    $ctjabhist++;
                                                }
                                                else
                                                {
                                                    $arrErJabHist[$errjabhist] = $r;
                                                    $errjabhist++;
                                                }
                                            }
                                            else
                                            {
                                                
                                                $arrErJabHist[$errjabhist] = $r;
                                                $errjabhist++;
                                            }
                                            

                                        }
                                        else
                                        {
                                            $arrDupJabHist[$dupjabhist] = $r;
                                            $dupjabhist++;
                                        }
                                    }
                                    else
                                    {
                                        $arrErJabHist[$errjabhist] = $r;
                                        $errjabhist++;
                                    }
                                }// jabatan_hist
                                
                                

                            }
                        }
                    }//end looping col
                }// end looping row

       }

        $hasilsukses=-1;
        $x ;

        /*var_dump($ctpeg1);
        var_dump($jmlpeg1);
        var_dump($ctjabhist);
        var_dump($jmljabhist);
        var_dump($ctpg);
        var_dump($jmlpg);
        var_dump($ctgp);
        var_dump($jmlgp);exit;*/
        if($ctpeg1 == $jmlpeg1 && $ctjabhist == $jmljabhist && $errpeg1 == 0 && $errjabhist == 0 && $dupjabhist == 0)
        {
            $hasilsukses =1;
            $x = 'ha';
        }
        else if( $errpeg1 > 0 || $errjabhist > 0)
        {
            $hasilsukses = -1;
            $x = 'hi';
        }
        else if($dupjabhist>0 )
        {
            $hasilsukses = 0;
            $x = 'hu';
        }
        else
        {
            $hasilsukses =-1;   
            $x = 'he';
        }
        
        
        
       
        
        $myfile = fopen("./assets/log_upload/log_upload_jabeselon.txt", "w") or die("Unable to open file!");

        $date_now = date('Y-m-d H:i:s');
        $txt = "Laporan Upload Data Kolektif < ".$date_now." >";
        $txt.= "\r\n";
        $txt.= "_______________________________________";
        $txt.= "\r\n";

        
            //laporan pegawai1

            $txt.=" Sheet ". $titleworksheet[0];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmlpeg1;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctpeg1;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErPeg1);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErPeg1);$i++)
            {
                $roweror1 = $arrErPeg1[$i] ;
                $txt.="         Error Row ".$roweror1;
                $txt.= "\r\n";
            }
            
            $txt.= "\r\n";
            
            //end laporan pegawai1

            $txt.="-----------------------------------------";
            
            //laporan jabhist
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.=" Sheet ". $titleworksheet[1];
            $txt.= "\r\n";
            $txt.= "\r\n";
            $txt.="Jumlah Data : ".$jmljabhist;             
            $txt.= "\r\n";
            $txt.="Data Sukses : ".$ctjabhist;
            $txt.= "\r\n";
            $txt.="Data Error : ".count($arrErJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrErJabHist);$i++)
            {
                $roweror2 = $arrErJabHist[$i];
                $txt.="         Error Row ".$roweror2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            $txt.="Data Duplikasi : ".count($arrDupJabHist);
            $txt.= "\r\n";
            for($i=0;$i<count($arrDupJabHist);$i++)
            {
                $rowdup2 = $arrDupJabHist[$i];
                $txt.="         Duplikat Row ".$rowdup2;
                $txt.= "\r\n";
            }
            $txt.= "\r\n";
            //end laporan jabhist

            $txt.= "\r\n";
            $txt.=" -- akhir dari laporan -- ";
        fwrite($myfile,$txt);
        
        
       /*$param = array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist,'pangkatsukses' => $ctpg , 'pangkaterror' => count($arrErPg), 'pangkatdup' => $duppg,'gapoksukses' => $ctgp , 'gapokerror' => count($arrErGp), 'gapokdup' => $dupgp);*/

        echo json_encode(array('response' => $hasilsukses, 'peg1sukses' => $ctpeg1, 'peg1error' => count($arrErPeg1), 'jabhistsukses' => $ctjabhist, 'jabhisterror' => count($arrErJabHist), 'jabhistdup' => $dupjabhist));
      
        //echo $hasilsukses;
    }

    public function downloadlog(){

        force_download('assets/log_upload/log_upload.txt',NULL);

    } 

    public function downloadlogpns(){

        force_download('assets/log_upload/log_upload_pns.txt',NULL);

    }

     public function downloadlogpensiun(){

        force_download('assets/log_upload/log_pensiun.txt',NULL);

    } 

    public function downloadlogjabeselon(){

        force_download('assets/log_upload/log_upload_jabeselon.txt',NULL);

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
// If any text (or whitespace!) is printed before this header is sent,
// the text won't be displayed and the image won't display properly.
// Comment out this line to see the text and debug such a problem.
        header("Content-type: image/JPEG");
        echo $result;
    }

}
