
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

class Skp extends CI_Controller {
	private $ci;
	private $printskp;
	public function __construct()
	{
		 /*header('Access-Control-Allow-Origin: http://10.15.32.31');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");*/
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('infopegawai');
		$this->load->model('mreferensi','referensi');
		$this->load->model('admin/v_pegawai','mdl');
		$this->load->model('hist/v_jabatanf_hist');

		$this->load->model('mhome','home');
		$this->load->model('model_skp','skp');
		
		$this->ci =& get_instance();
		$this->printskp = array();
       

		if ($this->session->userdata('logged_in')) {

			$session_data       = $this->session->userdata('logged_in');
			// var_dump($session_data);
			$this->user['id']     	= $session_data['id'];
			$this->user['username']  	= $session_data['username'];
			$this->user['user_group']     = $session_data['user_group'];
			$this->user['kowil']     = $session_data['kowil'];
			$this->user['param_cari'] = $this->session->userdata('param_cari');

			// var_dump($this->user['kowil']);
		}else{
			redirect(base_url().'login', 'refresh');  
		}
	}

	public function index()
	{
		$tgl_sekarang = date("Y-m-d");
		$tgl = date('Y-m-d', strtotime($tgl_sekarang));
		$tglproses = date('Y-m-d', strtotime($tgl_sekarang));

		$spmu = $this->mdl->getSPMUSKP();
		if($this->user['user_group']!='2')
		{
			$koloks = $this->mdl->getKolokSKP();	
		}
		else
		{
			$koloks = '';		
		}
		
		

		$namasrc = $this->input->post('namasrc');
		$nrksrc = $this->input->post('nrksrc');
		$koloksrc = $this->input->post('koloksrc');
		

		$hak_akses = $this->infopegawai->hakAksesModul('23628',$this->user['user_group']);
		$data = array(
			'tgl' => $tgl,
			'tglproses' => $tglproses,
			'koloks' => $koloks,
			'koloksrc' => $koloksrc,
			'nrksrc' => $nrksrc,
			'namasrc' => $namasrc,
			'param_cari'=> $this->user['param_cari'],
			'hak_akses'=>$hak_akses,
			'spmu'=>$spmu
			);

		


		$datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
		$datam['inisial'] = 'skp';

		$menuid='23628';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        if($cekaksesmenu == '1')
        {
			$this->load->view('head/header',$this->user);
			$this->load->view('head/menu',$datam);
			$this->load->view('admin/skp_grid.php',$data);
			$this->load->view('head/footer');
		}
        else
        {
            $this->load->view('403');
        } 
	}



	

	
	public function data()
	{

		$hak_akses = $this->infopegawai->hakAksesModul('16870',$this->user['user_group']);
		
		$requestData = $this->input->post();


		$pjg_input=strlen($requestData['nrk']);

		$columns = array(
			// datatable column index  => database column name
//			0 => 'ROWNUM',
			0 => 'NRK',
			1 => 'NAMA',
			2 => 'TAHUN',
			3 => 'PELAYANAN',
			4 => 'INTEGRITAS',
			5 => 'KOMITMEN',
			6 => 'DISIPLIN',
			7 => 'KERJASAMA',
			8 => 'KEPEMIMPINAN',
			9 => 'NILAI_SKP',
			10 => 'NILAI_PERILAKU',
			11 => 'NILAI_PRESTASI'
			
		);

		// getting total number records without any search
		$q = "SELECT
					COUNT(*) AS jml
				FROM PERS_PEGAWAI1 P1 
						
						INNER JOIN PERS_KLOGAD3 KL ON P1.KLOGAD = KL.KOLOK
						
						 where (P1.kdmati <> 'Y' OR P1.KDMATI IS NULL) AND P1.KLOGAD NOT LIKE '11111111%' AND P1.NRK < 999999
                AND P1.NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412)
				 ";
		// WHERE NOT EXISTS (SELECT NRK FROM PERS_PEGAWAI1 B WHERE DELETED ='Y' AND P1.NRK=B.NRK)
		$rs = $this->db->query($q)->result();
		$totalData = $rs[0]->JML;

		$wh_statval = "";

		if( !empty($requestData['opsi']) ){
			
			if($requestData['opsi'] == '-')
			{
				$wh_statval = " AND (A .STATUS_VALIDASI) = '0' ";	
			}
			else if($requestData['opsi'] == '1')
			{
				$wh_statval = " AND (A .STATUS_VALIDASI) = '".$requestData['opsi']."' ";	
			}
			
		}

		
		$whkoloksearch = "";

		if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
		{
			if(!empty($requestData['spmu']))
			{
				if( !empty($requestData['kolok']) )
				{
					if($requestData['kolok'] == "all")
					{
						$whkoloksearch = " AND P1.SPMU = '".$requestData['spmu']."' AND 5=5 ";
					}
					else
					{
						$whkoloksearch = " AND P1.SPMU = '".$requestData['spmu']."' AND KL.NALOK = '".$requestData['kolok']."'";	
					}
					
				}		
				
			}
			else
			{
				$whkoloksearch = " AND 5=5 ";
			}	
		}
		else
		{
			if( !empty($requestData['kolok']) )
			{
				if($requestData['kolok'] == "-" || $requestData['kolok'] == "all" )
				{
					$whkoloksearch = " AND 5=5 ";
				}
				else
				{
					$whkoloksearch = " AND KL.NALOK = '".$requestData['kolok']."'";	
				}
				
			}	
		}
		
		



		
		
	

		//$wh_nrk = " AND PERS_PEGAWAI1.nrk='' ";
		$wh_nrk = "";
		$wh_ukpd="";
		$whspmu="";
		$wh_k3="";
		$spmu_arr=array();

		if ($this->session->userdata('logged_in')['user_group']!='1')
		{

			if($this->session->userdata('logged_in')['user_group']=='47')
			{
				$idukpd = $this->user['id'];
				 $cekkolok = "SELECT a.kolok,a.nalok,a.spmu,a.kode_unit_sipkd,b.\"user_id\" 
                        from pers_klogad3 a
                        LEFT JOIN \"master_user\" b on a.kode_unit_sipkd = b.\"user_id\" 
                        where b.\"user_id\" = '$idukpd'";
                        //die($cekkolok);
            	$querycekkolok = $this->db->query($cekkolok);
            	if($querycekkolok) 
            	{
                	$reskolok=$querycekkolok->row()->KOLOK;
                	$wh_ukpd=" AND (P1.KLOGAD = '$reskolok' OR P1.KOLOK IN (SELECT KOLOK FROM UNIT_DISDIK WHERE KOLOK_SUDIN='$reskolok'))";   
            	}
            	else
            	{
            		$wh_ukpd=" AND 2=2";	
            	}

            	if( !empty($requestData['nrk']) )
				{
					$nrk_status = "WHERE NRK =('".$requestData['nrk']."')";
					//$wh_nrk = " AND lower(PERS_PEGAWAI1.nrk) LIKE lower('%".$requestData['nrk']."%') ";

					if($pjg_input==6)
					{
						$wh_nrk="AND (
		                        P1.nrk =('".$requestData['nrk']."')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        
		                    )";
					}
					else
					{
						$wh_nrk="AND (
		                       	(P1.nrk) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP18) LIKE UPPER('%".$requestData['nrk']."%')
		                    )";	
					}
				
				}
				
			}
			else if($this->session->userdata('logged_in')['user_group']=='5')
			{
				$username = $this->user['id'] ;

            	$getspmu = "SELECT * FROM PERS_TABEL_SPMU WHERE KODE_UNIT_SIPKD ='$username'";
            	$querygetspmu = $this->db->query($getspmu);
            	$numspm = $querygetspmu->num_rows();

            	if($numspm == 0)
            	{
            		$whspmu = " AND 3=3 ";
            	}
	            else if($numspm == 1)
	            {
	                $spmu = $querygetspmu->row()->KODE_SPM;

	                $whspmu = " AND P1.SPMU='$spmu' ";
	                $spmu_arr[0] = $spmu;
	                

	            }
	            else 
	            {
	                $arrayspmu = $querygetspmu->result();
	                

	                foreach ($arrayspmu  as $value) {
	                    # code...
	                    
	                    $spmu[] = $value->KODE_SPM;
	                    $spmu_arr = $value->KODE_SPM;
	                }
	                $quewh="";
	                for($i=0;$i<$numspm;$i++)
	                {

	                    $quewh.= "'".$spmu[$i]."'";
	                    if($i<$numspm-1)
	                    {
	                        $quewh.=",";
	                    }
	                }
	                
	                $whspmu = " AND P1.SPMU IN (".$quewh.") ";
	                
	               
	                
	            }

            	if( !empty($requestData['nrk']) )
				{
					$nrk_status = "WHERE NRK =('".$requestData['nrk']."')";
					

					if($pjg_input==6)
					{
						$wh_nrk=" AND (
		                        P1.nrk =('".$requestData['nrk']."')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        
		                    )";
					}
					else
					{
						$wh_nrk=" AND (
		                       	(P1.nrk) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP18) LIKE UPPER('%".$requestData['nrk']."%')
		                    )";	
					}
				
				}
				
			}
			else if($this->session->userdata('logged_in')['user_group']=='10')
			{
				$wil = $this->user['kowil'];

				if ($wil == '1')
				{
					$wh_k3 = " AND P1.KOLOK IS NOT NULL AND (P1.KOLOK LIKE '$wil%' AND SUBSTR(P1.KOLOK,2,1)!='1') ";
				}
				else if($wil == '11')
				{
					$wh_k3 = " AND P1.KOLOK IS NOT NULL AND (P1.KOLOK LIKE '$wil%' AND SUBSTR(P1.KOLOK,2,1)='1') ";
				}
				else
				{
					$wh_k3 = " AND P1.KOLOK IS NOT NULL AND P1.KOLOK LIKE '$wil%' ";
				}

				if( !empty($requestData['nrk']) )
				{
					$nrk_status = "WHERE NRK =('".$requestData['nrk']."')";
					

					if($pjg_input==6)
					{
						$wh_nrk=" AND (
		                        P1.nrk =('".$requestData['nrk']."')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        
		                    )";
					}
					else
					{
						$wh_nrk=" AND (
		                       	(P1.nrk) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP18) LIKE UPPER('%".$requestData['nrk']."%')
		                    )";	
					}
				
				}
			}

			else
			{

				if( !empty($requestData['nrk']) )
				{
					$nrk_status = "WHERE P1.NRK =('".$requestData['nrk']."')";
					

					if($pjg_input==6)
					{
						$wh_nrk="AND (
		                        P1.nrk =('".$requestData['nrk']."')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        
		                    )";
					}
					else
					{
						$wh_nrk="AND (
		                       	(P1.nrk) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.nama) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP) LIKE UPPER('%".$requestData['nrk']."%')
		                        OR (P1.NIP18) LIKE UPPER('%".$requestData['nrk']."%')
		                    )";	
					}
				
				}
				
			}

			
		} else {

			$wh_nrk = " AND P1.nrk = '".$this->session->userdata('logged_in')['nrk']."' ";
		}



		if($requestData['opsi'] == '2' || $requestData['opsi'] == '3')
		{
			if($requestData['opsi'] == '2')
			{
				$tahunOPT = date('Y')-1;	
			}
			else
			{
				$tahunOPT = date('Y')-2;
			}
			
			if($this->session->userdata('logged_in')['user_group']=='47')
			{
				$sql ="SELECT rownum, X.* FROM 
					(
						SELECT 
						rownum as rn, 
						P1.NRK,
						 ' ' AS TAHUN, 
						 ' ' AS PELAYANAN,
						 ' ' AS INTEGRITAS,
						 ' ' AS KOMITMEN,
						 ' ' AS DISIPLIN,
						 ' ' AS KERJASAMA,
						 ' ' AS KEPEMIMPINAN,     
						 ' ' AS NILAI_SKP,
						 ' ' AS NILAI_PERILAKU,
						 ' ' AS NILAI_PRESTASI,
						 ' ' AS STATUS_VALIDASI, 
						 ' ' AS USERID_INPUT, 
						 ' ' AS TGUPD_INPUT,
						 ' ' AS RATA2,
						 ' ' AS INPUT_SKP,
						 P1.KLOGAD,
						 P1.NIP,
						 P1.NAMA,
						 P1.NIP18,
						 KL.NALOK AS NALOKL,
						P1.SPMU    
						 FROM PERS_PEGAWAI1 P1 
						
						INNER JOIN PERS_KLOGAD3 KL ON P1.KLOGAD = KL.KOLOK
						
						 where (P1.kdmati <> 'Y' OR P1.KDMATI IS NULL) AND P1.KLOGAD NOT LIKE '11111111%' AND P1.NRK < 999999
                AND P1.NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412)
                  
			and not exists (select s.nrk from pers_skp s where s.tahun='$tahunOPT' and P1.nrk =s.nrk ) $wh_ukpd $whspmu $wh_k3 $wh_nrk 
			$whkoloksearch";


			}
			else
			{
				$sql ="SELECT rownum, X.* FROM 
					(
						SELECT 
						rownum as rn, 
						P1.NRK,
						 ' ' AS TAHUN, 
						 ' ' AS PELAYANAN,
						 ' ' AS INTEGRITAS,
						 ' ' AS KOMITMEN,
						 ' ' AS DISIPLIN,
						 ' ' AS KERJASAMA,
						 ' ' AS KEPEMIMPINAN,     
						 ' ' AS NILAI_SKP,
						 ' ' AS NILAI_PERILAKU,
						 ' ' AS NILAI_PRESTASI,
						 ' ' AS STATUS_VALIDASI, 
						 ' ' AS USERID_INPUT, 
						 ' ' AS TGUPD_INPUT,
						 ' ' AS RATA2,
						 ' ' AS INPUT_SKP,
						 P1.KLOGAD,
						 P1.NIP,
						 P1.NAMA,
						 P1.NIP18,
						 KL.NALOK AS NALOKL,
						P1.SPMU    
						 FROM PERS_PEGAWAI1 P1 
						
						INNER JOIN PERS_KLOGAD3 KL ON P1.KLOGAD = KL.KOLOK
						
						 where (P1.kdmati <> 'Y' OR P1.KDMATI IS NULL) AND P1.KLOGAD NOT LIKE '11111111%' AND P1.NRK < 999999
                AND P1.NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412)
                  
			and not exists (select s.nrk from pers_skp s where s.tahun='$tahunOPT' and P1.nrk =s.nrk ) $wh_ukpd $whspmu $wh_k3 $wh_nrk $whkoloksearch";
			}

			
		}
		else if($requestData['opsi'] == '-' || $requestData['opsi'] == '1')
		{
			$tahunlalu = date('Y')-1;	
			
			if($this->session->userdata('logged_in')['user_group']=='47')
			{
				$sql = "SELECT rownum, X.* FROM 
						(
							SELECT
							rownum as rn,
							P1 .NRK,
							A .TAHUN,
							A .PELAYANAN,
							A .INTEGRITAS,
							A .KOMITMEN,
							A .DISIPLIN,
							A .KERJASAMA,
							A .KEPEMIMPINAN,
							A .NILAI_SKP,
							A .NILAI_PERILAKU,
							A .NILAI_PRESTASI,
							A .STATUS_VALIDASI,
							A .USERID_INPUT,
							TO_CHAR (
								A .TGUPD_INPUT,
								'DD-MM-YYYY HH24:MI:SS'
							) TGUPD_INPUT,
							A.RATA2,
						 	A.INPUT_SKP,
							P1.KLOGAD,
							P1.NIP,
							P1.NAMA,
							P1.NIP18,
							KL.NALOK AS NALOKL,
							P1.SPMU
						FROM
							PERS_PEGAWAI1 P1
						inner JOIN PERS_SKP A ON A.NRK = P1.NRK 
						
						INNER JOIN PERS_KLOGAD3 KL ON P1.KLOGAD = KL.KOLOK
						


                  WHERE (P1.kdmati <> 'Y' OR P1.KDMATI IS NULL) AND P1.KLOGAD NOT LIKE '11111111%' AND P1.NRK < 999999
                AND P1.NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412)
                  AND A.TAHUN = '$tahunlalu' 
                  AND
                  			2=2
							$wh_statval
							$wh_nrk
							$wh_k3
							$wh_ukpd
							$whspmu
							$whkoloksearch
							";
			}
			else
			{
				$sql = "SELECT rownum, X.* FROM 
						(
							SELECT
							rownum as rn,
							P1 .NRK,
							A .TAHUN,
							A .PELAYANAN,
							A .INTEGRITAS,
							A .KOMITMEN,
							A .DISIPLIN,
							A .KERJASAMA,
							A .KEPEMIMPINAN,
							A .NILAI_SKP,
							A .NILAI_PERILAKU,
							A .NILAI_PRESTASI,
							A .STATUS_VALIDASI,
							A .USERID_INPUT,
							TO_CHAR (
								A .TGUPD_INPUT,
								'DD-MM-YYYY HH24:MI:SS'
							) TGUPD_INPUT,
							A.RATA2,
						 	A.INPUT_SKP,
							P1.KLOGAD,
							P1.NIP,
							P1.NAMA,
							P1.NIP18,
							KL.NALOK AS NALOKL,
							P1.SPMU
						FROM
							PERS_PEGAWAI1 P1
						inner JOIN PERS_SKP A ON A.NRK = P1.NRK 
						
						INNER JOIN PERS_KLOGAD3 KL ON P1.KLOGAD = KL.KOLOK
						


                  WHERE (P1.kdmati <> 'Y' OR P1.KDMATI IS NULL) AND P1.KLOGAD NOT LIKE '11111111%' AND P1.NRK < 999999
                AND P1.NRK NOT IN (25310,199412,999000,885649,805171,666666,611722,576008,555555,537176,470045,441138,435023,412002,409579,376263,353515,
                333333,321095,317668,266407,250204,222222,217208,200558,199412)
                  AND A.TAHUN = '$tahunlalu' 
                  AND
                  			2=2
							$wh_statval
							$wh_nrk
							$wh_k3
							$wh_ukpd
							$whspmu
							$whkoloksearch
							";
			}	
				
		}




	
							
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND ( P1.NRK = ('".$requestData['search']['value']."') ";    
            $sql.=" OR P1.NAMA LIKE UPPER ('%".$requestData['search']['value']."%') ";
            $sql.=" OR P1.NIP LIKE ('%".$requestData['search']['value']."%') ";
            $sql.=" OR P1.NIP18 LIKE ('%".$requestData['search']['value']."%') ";
            $sql.=" OR KL.NALOK LIKE ('%".$requestData['search']['value']."%') )";
            
		}



		$sql .= " ORDER BY
					P1.NRK ASC,
					TAHUN DESC
				) X";
		//die($sql);
		 $sql.=" WHERE 1=1";	
		 
		
		$query= $this->db->query($sql);

		$totalFiltered = $query->num_rows();
		$startrow = $requestData['start'];
		$endrow = $startrow + $requestData['length'];

		$sql.=" AND RN BETWEEN $startrow  AND $endrow";
	
		
		$query= $this->db->query($sql);


		$data = array();

		$no_urut = $requestData['start']+1;
		foreach($query->result() as $row){
			$nestedData=array();


			
				$nestedData[] = $row->NRK;
				$nestedData[] = $row->NAMA;
				$nestedData[] = $row->TAHUN;
				$nestedData[] = $row->PELAYANAN;
				$nestedData[] = $row->INTEGRITAS;
				$nestedData[] = $row->KOMITMEN;
				$nestedData[] = $row->DISIPLIN;
				$nestedData[] = $row->KERJASAMA;
				$nestedData[] = $row->KEPEMIMPINAN;
				$nestedData[] = $row->INPUT_SKP;
				$nestedData[] = $row->RATA2;
				$nestedData[] = $row->NILAI_PRESTASI;
				$nestedData[] = $row->USERID_INPUT."<br/>( ".$row->TGUPD_INPUT." )";
			

			
			$peg1=$this->infopegawai->getPegawai1($row->NRK);
			$penginput = $this->user['id'];
			$html_reset_pass="";
			if ($this->user['user_group']=='2' || $this->user['user_group']=='3' || $this->user['user_group']=='5' || $this->user['user_group']=='47' || $this->user['user_group']=='26')
			{

				

				$htmledit="<div class='col-sm-3' align='center'><button type='button' class='btn btn-outline btn-xs btn-success' title='Edit' onClick='getForm(\"skp\",\"update\",\"".$row->NRK."\",\"".$row->TAHUN."\",\"".$this->user['id']."\");'><i class='fa fa-pencil-square'></i></button> &nbsp;</div>";


				$htmlval="<div class='col-sm-3' align='center'>
										<button class='btn btn-outline btn-xs btn-danger' data-toggle='tool-tip' title='Validasi skp' pull-right onclick='validasiskp(&#39;".$row->NRK."&#39;,&#39;".$row->TAHUN."&#39;)'><i class='fa fa-check'></i></button>
								</div>";
			

				

				if($requestData['opsi'] == '-'  || $requestData['opsi'] == '1')
				{
					$nestedData[] = "<div class='form-group'>
								<div class='col-sm-12'>
									<div class='row'>
										
										
										$htmledit
										$htmlval
										
									</div>
								</div>
							</div>
							
                            <script>
                                $('#tbl-grid_filter > label > input.form-control').val('');
                            </script>
                            ";
				}
				else
				{
					$nestedData[] = "<div class='form-group'>
								<div class='col-sm-12'>
									<div class='row'>
										
										
										$htmledit
										
										
									</div>
								</div>
							</div>
							
                            <script>
                                $('#tbl-grid_filter > label > input.form-control').val('');
                            </script>
                            ";
				}
				

				
			} 
			
			
			else if ($this->user['user_group']=='10')
			{
					$wil = $this->user['kowil'];	
					$htmledit="<div class='col-sm-3' align='center'><button type='button' class='btn btn-outline btn-xs btn-success' title='Edit' onClick='getForm(\"skp\",\"update\",\"".$row->NRK."\",\"".$row->TAHUN."\",\"".$this->user['id']."\");'><i class='fa fa-pencil-square'></i></button> &nbsp;</div>";


					$htmlval="<div class='col-sm-3' align='center'>
										<button class='btn btn-outline btn-xs btn-danger' data-toggle='tool-tip' title='Validasi skp' pull-right onclick='validasiskp(&#39;".$row->NRK."&#39;,&#39;".$row->TAHUN."&#39;)'><i class='fa fa-check'></i></button>
								</div>";


					if($wil == '1')
					{
						if(substr($peg1->KOLOK,0,1) == 1 && substr($peg1->KOLOK,1,1) != 1)
						{
							if($requestData['opsi'] == '-'  || $requestData['opsi'] == '1')
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													$htmlval
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
							else
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
						}
						else
						{
							$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							
						}
					}
					else if($wil == '11')
					{
						if(substr($peg1->KOLOK,0,1) == 1 && substr($peg1->KOLOK,1,1) == 1)
						{
							if($requestData['opsi'] == '-'  || $requestData['opsi'] == '1')
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													$htmlval
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
							else
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
						}
						else
						{
							$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							
						}
					}
					else
					{
						if(substr($peg1->KOLOK,0,1) != 1 && $wil = substr($peg1->KOLOK,0,1) && $wil!=1)
						{
							if($requestData['opsi'] == '-'  || $requestData['opsi'] == '1')
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													$htmlval
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
							else
							{
								$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
													
													$htmledit
													
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
							}
						}
						else
						{
							$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
						}
					} 
			}
			else
			{
				$nestedData[] = "<div class='form-group'>
											<div class='col-sm-12'>
												<div class='row'>
													
												</div>
											</div>
										</div>
										
			                            <script>
			                                $('#tbl-grid_filter > label > input.form-control').val('');
			                            </script>
			                            ";
			}
			//var_dump($nestedData);exit;
			

			$data[] = $nestedData;
			$no_urut++;
		}

		// <button type='button' class='btn btn-danger btn-xs' onclick='tolakHdr('".$row->NRK."')'>Tolak</button>
		//<div class='col-sm-4' align='center'><button class='btn btn-outline btn-xs btn-danger' data-toggle='tool-tip' data-placement='bottom' title='hapus pegawai' onClick=confirmHapusDataPegawai('".$row->NRK."') ><i class='fa fa-trash'></i></button></div>
			
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
		);

		echo json_encode($json_data);
	}



	 public function generateForm(){
        
        if(isset($_POST['form'])){
            $form = $_POST['form'];
            // var_dump($form);

            $nrk = $_POST['key1'];
            $tahun = $_POST['key2'];
            $validator = $_POST['key3'];

        }else{
            $return = array('response' => 'GAGAL', 'err' => 'No Form');
            echo json_encode($return);
            exit();
        }

        $data = $this->generateDataForm($form);
        $widthForm = $data['widthForm'];
        // var_dump($data);exit;
        $data['nrk'] = $nrk;
        $data['validator'] = $validator;
        

   
        $msg = $this->load->view('admin/form_hist/form_'.$form, $data, true);
//        var_dump($msg);exit;
        $return = array('response' => 'SUKSES', 'result' => $msg, 'widthForm' => $widthForm);
        echo json_encode($return);
    }

    public function getSessionData()
	{
		$post = $this->input->post();
		$nrkpost = $post['nrk'];
		$kolokpost = $post['kolok'];
		$opsipost = $post['opsi'];
		$spmupost = $post['spmu'];
		//var_dump($nrkpost);
		$session_data = $this->session->userdata('logged_in');
		
		if($nrkpost!="" || $kolokpost !="" || $opsipost !="" || $spmupost !="")
		{

			if($session_data)
			{
				// array_push($session_data['param_cari'], $kolokpost , $nrkpost);
				$new_param = array ($kolokpost , $nrkpost, $opsipost, $spmupost);
				$this->session->set_userdata('param_cari', $new_param);
								
				// var_dump($session_data['param_cari']);
				//$session_data['param_cari'][0]);
			}
		}

		
	}

    public function generateDataForm($form){
        $data['empty'] = ""; $data['widthForm'] = "two";
        switch ($form) {
           

            case 'skp':                
                $action = $this->input->post('action');//action
                $nrk = $this->input->post('nrk');//nrk
                $nrk2 = $this->input->post('key1');//nrk
                $tahun = $this->input->post('key2');//tahun 
                $yrnw = date('Y');
                $data['yrnw'] = $yrnw;
                $data['action'] = $action;                  

                if($action != null && $action == 'update'){                    
                    $data['infoSKP'] = $this->infopegawai->getSKPHistBy($nrk2,$tahun);  
                     
                    if($data['infoSKP']->KEPEMIMPINAN == '0')
                    {
                    	$data['infoSKP']->KETKEPEMIMPINAN ='';
                    }
                    else
                    {
                    	$data['infoSKP']->KETKEPEMIMPINAN = $data['infoSKP']->KETKEPEMIMPINAN;
                    }
                }
                
                break;

            default:
                $data['empty'] = "";
                break;
        }

        return $data;
    }    









    function updatevalidasi()
	{
		
		$data = $this->input->post();
		
		
		$result = $this->mdl->updatevalidasi($data);
		

		$return = array('resp' => $result['resp']);

        echo json_encode($return);
	}




	
	function validasiskp()
	{
		$id = $this->input->post();

		$nrk = $id['NRK'];
		$tahun = $id['TAHUN'];
		
		
		echo '
			<div class="modal-dialog" role="document" id="pesan">
		        <form class="form-horizontal" id="formPass" action="javascript:validasi();" method="POST">                
		            <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                
		                <input type="hidden" id="NRK" name="NRK" value="' ; echo $nrk;	
		                echo'"><input type="hidden" id="TAHUN" name="TAHUN" value="'; echo $tahun;
						echo'"><input type="hidden" id="VALIDATOR" name="VALIDATOR" value="';echo $this->user['id'] ;
						echo'">

		            </div>
		            <div class="modal-body">
		                    
		                

		                <div class="form-group">
		                    <h2>Anda Yakin akan validasi data skp ini??</h2>

		                </div>

		                
		    
		            </div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default dim" data-dismiss="modal" id="tutupModal">Batalkan</button>
		                    <button type="submit" class="btn btn-primary dim">Validasi</button>
		                </div>
		            </div>
		        </form>
		    </div>

		    <script type="text/javascript" language="javascript" >
		    	
			    function validasi(){
			        var url = "'.site_url("skp/updatevalidasi").'";
			        $.ajax({
			            url: url,
			            type: "POST",
			            data: $("#formPass").serialize(),
			            dataType: "json",
			           
			            success: function(data) {                               
			                
			                if(data.resp == "0"){
			                    swal("Error!", "Gagal Validasi", "error");                    
			                    
			                }
			                else if(data.resp == "1"){
			                  
			                    swal("Sukses!", "Validasi Berhasil", "success"); 
			                   $("#modalPassword").modal("hide");
			                    $("#tbl-grid").DataTable().ajax.reload();
			                }
			               
			            },
			            error: function(xhr) {                              
			                
			            },
			            complete: function() {              
			                
			            }
			        });
			    }

			</script>
		';
	}



	function tampilPhoto($nrk='989898'){
		// Now query back the uploaded BLOB and display it
		$rs=$this->mdl->get_data($nrk)->row();
		$result = $rs->X_PHOTO->load();
		// If any text (or whitespace!) is printed before this header is sent,
		// the text won't be displayed and the image won't display properly.
		// Comment out this line to see the text and debug such a problem.
		header("Content-type: image/JPEG");
		echo $result;
	}

	function reset_password(){
		 // <img src="'.base_url("assets/img/eye.png").';" onmouseover="mouseoverPass(old_pass);" onmouseout="mouseoutPass(old_pass);">
		                 
		$id = $this->input->post('NRK');
		$nama = $this->infopegawai->getDataUser($id);

		if(isset($nama))
		{
			echo '
			<div class="modal-dialog" role="document" id="pesan">
		        <form class="form-horizontal" id="formPass" action="javascript:updatePassword();" method="POST">                
		            <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title" id="modalUmumTitle">Edit Password<i> '; 
		                echo $id; echo '-';
		                echo $nama->user_name;	echo '</i></h4>
		                <input type="hidden" id="NRK" name="NRK" value="' ; echo $id;	
		                
		                echo'">
		            </div>
		            <div class="modal-body">
		                    
		                <div class="form-group">
		                    <label for="username" class="col-sm-3 control-label">Password Baru</label>
		                    <div class="col-sm-9">

		                    <input type="password" class="form-control" id="old_pass" name="old_pass" Placeholder="Password Baru">
		                   	<img src="'.base_url("assets/img/eye.png").'" onmouseover="mouseoverPass(old_pass);" onmouseout="mouseoutPass(old_pass);">
		                   	</div>
		                </div>

		                <div class="form-group">
		                    <label for="username" class="col-sm-3 control-label">Password Konfirmasi</label>
		                    <div class="col-sm-9">
		                    <input type="password" class="form-control" id="new_pass" name="new_pass" Placeholder="Password Konfirmasi">
		                    <span class="text-danger" id="errnew_pass"></span>
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label for="username" class="col-sm-3 control-label"></label>
		                    <div class="col-sm-9">
		                    <i>( Harap ganti Password secara berkala untuk menjaga kerahasiaan data pribadi anda ! )</i>
		                    </div>
		                </div>
		    
		            </div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default dim" data-dismiss="modal" id="tutupModal">Tutup</button>
		                    <button type="submit" class="btn btn-primary dim">Simpan</button>
		                </div>
		            </div>
		        </form>
		    </div>

		    <script type="text/javascript" language="javascript" >
		    	function mouseoverPass(obj) {
		  			//var obj = document.getElementById("myPassword");
		  			obj.type = "text";
				}

				function mouseoutPass(obj) {
		  			//var obj = document.getElementById("myPassword");
				  	obj.type = "password";
				}

			    function updatePassword(){
			        var url = "'.site_url("pegawai/UpdatePass").'";
			        $.ajax({
			            url: url,
			            type: "POST",
			            data: $("#formPass").serialize(),
			            dataType: "json",
			            beforeSend: function() {                
			                var old_pass = $("#old_pass").val();
			                if(old_pass == ""){
			                    $("#errold_pass").html("Passwor Lama Wajib diisi!!!");
			                    return false;
			                }else{
			                    $("#errold_pass").html();                    
			                }

			                var new_pass = $("#new_pass").val();
			                if(new_pass == ""){
			                    $("#errnew_pass").html("Password Baru Wajib diisi!!!");
			                    return false;
			                }else{
			                    $("#errnew_pass").html();                    
			                }

			               
			            },
			            success: function(data) {                               
			                
			                if(data.responeinsert == "SUKSES"){
			                    swal("Sukses!", "Reset password berhasil", "success");                    
			                    $("#tutupModal").click();
			                    $("#tbl-grid").DataTable().ajax.reload();
			                }else{
			                   swal("Gagal!", "Password konfirmasi tidak sesuai.", "error");
			                }
			            },
			            error: function(xhr) {                              
			                
			            },
			            complete: function() {              
			                
			            }
			        });
			    }

			</script>
		';
		}
		else
		{
			echo '
			<div class="modal-dialog" role="document" id="pesan">
		        <form class="form-horizontal" id="formPass" action="javascript:updatePassword();" method="POST">                
		            <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title" id="modalUmumTitle">Edit Password<i> ';

		                echo $id;

		                echo '
		                </i></h4>
		                <input type="hidden" id="NRK" name="NRK" value="">
		            </div>
		            <div class="modal-body">
		                    
		                <h2>USER <i>'; echo $id; echo '</i> BELUM MEMILIKI AKUN UNTUK MENGAKSES WEBSITE INI </h2>
		    
		            </div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default dim" data-dismiss="modal" id="tutupModal">Tutup</button>
		                    <button type="submit" class="btn btn-primary dim" style="display:none">Simpan</button>
		                </div>
		            </div>
		        </form>
		    </div>

		    
		';
		}
		
	}

	function UpdatePass(){
		$nrk = $this->input->post('NRK');
		$old_pass = $this->input->post('old_pass');
		$new_pass = $this->input->post('new_pass');
		$pass_old = md5($old_pass);
        $pass_new = md5($new_pass);
        // echo $nrk;
        // echo "pass lama"; var_dump($pass_old);

        // $cek_pass = $this->mdl->get_pass($nrk);
        // echo "pass db"; var_dump($cek_pass->user_password);

        // echo "pass db"; var_dump($cek_pass->user_id);
        
        if($pass_new  ==  $pass_old){
            $this->mdl->ubah_password($nrk,$pass_new);
            $respone = "SUKSES";
        }else{
            $respone = "GAGAL";
        }

        $return = array('responeinsert' => $respone);

        echo json_encode($return);
	}

	

	public function cekDataSKP()
	{

		$val_select = $this->input->post('val');
		$kolok = $this->input->post('kolok');
		$spmu = $this->input->post('spmu');
 		

 		if($kolok=="all")
 		{
 			$kolok = '';
 		}
		
			if($val_select == "-")
	 		{
	 			$th1 = date('Y')-1;

	 			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
	 			{
	 				if($spmu == "")
	 				{
	 					$query = $this->mdl->getCtDataSKPBelumValidasi($th1,$kolok);	
	 				}
	 				else
	 				{
	 					$query = $this->mdl->getCtDataSKPBelumValidasi($th1,$kolok,$spmu);	
	 				}
	 			}
	 			else
	 			{
	 				$query = $this->mdl->getCtDataSKPBelumValidasi($th1,$kolok);		
	 			}
				
				
				
	 		}
	 		else if($val_select == "1")
	 		{
	 			$th1 = date('Y')-1;
				
				if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
	 			{
	 				if($spmu == "")
	 				{
	 					$query = $this->mdl->getCtDataSKPSudahValidasi($th1,$kolok);	
	 				}
	 				else
	 				{
	 					$query = $this->mdl->getCtDataSKPSudahValidasi($th1,$kolok,$spmu);	
	 				}
	 			}
	 			else
	 			{
	 				$query = $this->mdl->getCtDataSKPSudahValidasi($th1,$kolok);		
	 			}
				
	 		}
	 		else if($val_select == "2")
	 		{
	 			$th1 = date('Y')-1;
				
				if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
	 			{

	 				if($spmu == "")
	 				{
	 					$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok);	
	 				}
	 				else
	 				{
	 					
	 					$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok,$spmu);	
	 				}
	 			}
	 			else
	 			{
	 				$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok);		
	 			}
				
	 		}
			else if($val_select == "3")
	 		{
	 			$th1 = date('Y')-2;
				
				if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
	 			{

	 				if($spmu == "")
	 				{
	 					$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok);	
	 				}
	 				else
	 				{
	 					$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok,$spmu);	
	 				}
	 			}
	 			else
	 			{
	 				$query = $this->mdl->getCtDataSKPBelumInput($th1,$kolok);		
	 			}
				
	 		}	
		

 		

 		$hasilcekdata = $query[0]->CT;
 		
 		$response =  array(
		        'jml' => $hasilcekdata
		        
		    ); 

		echo json_encode($response);
 		
	}


	public function export_excel_skp()
 	{
 		
 		$val_select = $this->input->post('val');
 		$kolok = $this->input->post('kolok');
 		$spmu = $this->input->post('spmu');

 		if($kolok=='all')
 		{
 			$kolok ='';
 		}
 		else
 		{
 			$kolok = $kolok;
 		}
 		
 		if($val_select == "-")
 		{
 			$th1 = date('Y')-1;

			//$query = $this->mdl->getDataSKPBelumValidasi($th1,$kolok);	
			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumValidasi($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumValidasi($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumValidasi($th1,$kolok);		
			}
			
			$filename = 'Laporan SKP Belum Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "1")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPSudahValidasi($th1,$kolok);	
			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPSudahValidasi($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPSudahValidasi($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPSudahValidasi($th1,$kolok);		
			}

			$filename = 'Laporan SKP Sudah Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "2")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);
			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumInput($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);		
			}

			$filename = 'Laporan SKP Belum Input Tahun '.$th1.".csv";
 		}
		else if($val_select == "3")
 		{
 			$th1 = date('Y')-2;

			//$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);	

			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumInput($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumInput($th1,$kolok);		
			}
			$filename = 'Laporan SKP Belum Input Tahun '.$th1.".csv";
 		}


 		$this->load->library("phpexcel/PHPExcel");

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Penilaian Prestasi Kerja PNS - Provinsi DKI Jakarta")
									 ->setLastModifiedBy("BKD - Provinsi DKI Jakarta")
									 ->setTitle("Laporan Penilaian Prestasi Kerja PNS")
									 ->setSubject("Laporan SKP")
									 ->setDescription("Laporan Penilaian Prestasi Kerja PNS DKI Provinsi DKI Jakarta.")
									 ->setKeywords("SKP")
									 ->setCategory("SKP")
									 ->setCompany("BKD Provinsi DKI Jakarta");

		$arrMonth = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->setActiveSheetIndex(0);
        
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NRK');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NAMA');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'TAHUN');
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'PELAYANAN');
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'INTEGRITAS');
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'KOMITMEN');
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DISIPLIN');
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'KERJASAMA');
		$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'KEPEMIMPINAN');
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'INPUT_SKP');
		$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'RATA2');
		$objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'NILAI PRESTASI');
		$objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'LOKASI GAJI');
		$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// Set column widths
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(70);

		$i=2;
		
		$no=1;
		foreach($query as $row){
			


			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);									
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '`'.$row->NRK);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row->NAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $row->TAHUN);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $row->PELAYANAN);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $row->INTEGRITAS);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $row->KOMITMEN);	
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $row->DISIPLIN);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $row->KERJASAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $row->KEPEMIMPINAN);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $row->INPUT_SKP);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $row->RATA2);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $row->NILAI_PRESTASI);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $row->NALOKL);

			$i++;			$no++;
			
		}
		// $objPHPExcel->getActiveSheet()->getStyle('A5:K'.($totalData+1))->applyFromArray($styleThinBlackBorderOutline);

	

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('sheet1');		

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);		
		
		//UNTUK CREATE ANOTHER SHEET IN SAME FILE		
		//$objPHPExcel->createSheet(1);	
		//$objPHPExcel->setActiveSheetIndex(1);
        

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

	

	
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);	


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_SKP"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		ob_start();
		$objWriter->save('php://output');
		
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
		        'op' => 'ok',
		        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
		        'filename' => $filename
		    ); 

		echo json_encode($response);
	}


	public function export_excel_skp1()
 	{
 		
 		$val_select = $this->input->post('val');
 		$kolok = $this->input->post('kolok');
 		$spmu = $this->input->post('spmu');

 		if($kolok=='all')
 		{
 			$kolok ='';
 		}
 		else
 		{
 			$kolok = $kolok;
 		}
 		
 		
 		if($val_select == "-")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPBelumValidasi1($th1,$kolok);	
			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumValidasi1($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumValidasi1($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumValidasi1($th1,$kolok);		
			}
			
			$filename = 'Laporan SKP Belum Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "1")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPSudahValidasi1($th1,$kolok);	

			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPSudahValidasi1($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPSudahValidasi1($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPSudahValidasi1($th1,$kolok);		
			}
			$filename = 'Laporan SKP Sudah Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "2")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);	
			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);		
			}

			$filename = 'Laporan SKP(1) Belum Input Tahun '.$th1.".csv";
 		}
		else if($val_select == "3")
 		{
 			$th1 = date('Y')-2;
			//$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);	
			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumInput1($th1,$kolok);		
			}
			$filename = 'Laporan SKP(1) Belum Input Tahun '.$th1.".csv";
 		}


 		$this->load->library("phpexcel/PHPExcel");

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Penilaian Prestasi Kerja PNS - Provinsi DKI Jakarta")
									 ->setLastModifiedBy("BKD - Provinsi DKI Jakarta")
									 ->setTitle("Laporan Penilaian Prestasi Kerja PNS")
									 ->setSubject("Laporan SKP")
									 ->setDescription("Laporan Penilaian Prestasi Kerja PNS DKI Provinsi DKI Jakarta.")
									 ->setKeywords("SKP")
									 ->setCategory("SKP")
									 ->setCompany("BKD Provinsi DKI Jakarta");

		$arrMonth = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->setActiveSheetIndex(0);
        
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NRK');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NAMA');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'TAHUN');
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'PELAYANAN');
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'INTEGRITAS');
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'KOMITMEN');
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DISIPLIN');
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'KERJASAMA');
		$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'KEPEMIMPINAN');
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'INPUT_SKP');
		$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'RATA2');
		$objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'NILAI PRESTASI');
		$objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'LOKASI GAJI');
		$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// Set column widths
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(70);

		$i=2;
		
		$no=1;
		foreach($query as $row){
			


			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);									
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '`'.$row->NRK);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row->NAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $row->TAHUN);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $row->PELAYANAN);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $row->INTEGRITAS);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $row->KOMITMEN);	
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $row->DISIPLIN);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $row->KERJASAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $row->KEPEMIMPINAN);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $row->INPUT_SKP);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $row->RATA2);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $row->NILAI_PRESTASI);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $row->NALOKL);

			$i++;			$no++;
			
		}
		// $objPHPExcel->getActiveSheet()->getStyle('A5:K'.($totalData+1))->applyFromArray($styleThinBlackBorderOutline);

	

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('sheet1');		

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);		
		
		//UNTUK CREATE ANOTHER SHEET IN SAME FILE		
		//$objPHPExcel->createSheet(1);	
		//$objPHPExcel->setActiveSheetIndex(1);
        

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

	

	
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);	


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_SKP"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		ob_start();
		$objWriter->save('php://output');
		
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
		        'op' => 'ok',
		        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
		        'filename' => $filename
		    ); 

		echo json_encode($response);
	}

	public function export_excel_skp2()
 	{
 		
 		$val_select = $this->input->post('val');
 		$kolok = $this->input->post('kolok');
 		$spmu = $this->input->post('spmu');

 		if($kolok=='all')
 		{
 			$kolok ='';
 		}
 		else
 		{
 			$kolok = $kolok;
 		}
 		
 		
 		if($val_select == "-")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok);	

			if($this->user['user_group'] == "2" || $this->user['user_group'] == "26")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok);		
			}
			
			$filename = 'Laporan SKP Belum Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "1")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPSudahValidasi2($th1,$kolok);	

			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPSudahValidasi2($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPSudahValidasi2($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPSudahValidasi2($th1,$kolok);		
			}

			$filename = 'Laporan SKP Sudah Validasi Tahun '.$th1.".csv";
 		}
 		else if($val_select == "2")
 		{
 			$th1 = date('Y')-1;
			//$query = $this->mdl->getDataSKPBelumInput2($th1,$kolok);	

			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumInput2($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumInput2($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumInput2($th1,$kolok);		
			}
			$filename = 'Laporan SKP(2) Belum Input Tahun '.$th1.".csv";
 		}
		else if($val_select == "3")
 		{
 			$th1 = date('Y')-2;
			$query = $this->mdl->getDataSKPBelumInput2($th1,$kolok);	

			if($this->user['user_group'] == "2")
			{
				if($spmu == "")
				{
					$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok);	
				}
				else
				{
					$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok,$spmu);	
				}
			}
			else
			{
				$query = $this->mdl->getDataSKPBelumValidasi2($th1,$kolok);		
			}
			$filename = 'Laporan SKP(2) Belum Input Tahun '.$th1.".csv";
 		}


 		$this->load->library("phpexcel/PHPExcel");

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Penilaian Prestasi Kerja PNS - Provinsi DKI Jakarta")
									 ->setLastModifiedBy("BKD - Provinsi DKI Jakarta")
									 ->setTitle("Laporan Penilaian Prestasi Kerja PNS")
									 ->setSubject("Laporan SKP")
									 ->setDescription("Laporan Penilaian Prestasi Kerja PNS DKI Provinsi DKI Jakarta.")
									 ->setKeywords("SKP")
									 ->setCategory("SKP")
									 ->setCompany("BKD Provinsi DKI Jakarta");

		$arrMonth = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->setActiveSheetIndex(0);
        
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NRK');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NAMA');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'TAHUN');
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'PELAYANAN');
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'INTEGRITAS');
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'KOMITMEN');
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DISIPLIN');
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'KERJASAMA');
		$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'KEPEMIMPINAN');
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'INPUT_SKP');
		$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'RATA2');
		$objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'NILAI PRESTASI');
		$objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'LOKASI GAJI');
		$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// Set column widths
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(70);

		$i=2;
		
		$no=1;
		foreach($query as $row){
			


			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);									
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '`'.$row->NRK);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row->NAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $row->TAHUN);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $row->PELAYANAN);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $row->INTEGRITAS);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $row->KOMITMEN);	
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $row->DISIPLIN);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $row->KERJASAMA);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $row->KEPEMIMPINAN);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $row->INPUT_SKP);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $row->RATA2);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $row->NILAI_PRESTASI);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $row->NALOKL);

			$i++;			$no++;
			
		}
		// $objPHPExcel->getActiveSheet()->getStyle('A5:K'.($totalData+1))->applyFromArray($styleThinBlackBorderOutline);

	

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('sheet1');		

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);		
		
		//UNTUK CREATE ANOTHER SHEET IN SAME FILE		
		//$objPHPExcel->createSheet(1);	
		//$objPHPExcel->setActiveSheetIndex(1);
        

		// =======================================================================================================

		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B '. $objPHPExcel->getProperties()->getTitle() .' &RPrinted on &D');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// Set page orientation and size		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

	

	
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);	


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_SKP"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		ob_start();
		$objWriter->save('php://output');
		
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
		        'op' => 'ok',
		        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
		        'filename' => $filename
		    ); 

		echo json_encode($response);
	}

	public function getKolok()
    {
        $spmu = $this->input->post('spmu');

        
            $koloks = $this->mdl->getKolokFromSPMU($spmu);
        
        $arr = array('response' => 'SUKSES', 'koloks' => $koloks);
        echo json_encode($arr);
    }

    // added by pemda, 9-4-2019: Modul SKP

    public function ajax_list_skp(){    	
    	$nrk = $this->user['id'];
    	$nrk_atasan = $this->skp->atasan_cuti($nrk);	
    	$arr_fields = ["nrk","deleted_at"];
		$arr_values = [$nrk,'is null'];
		$p = $this->get_params($arr_fields, $arr_values);					
		$skp =  $this->skp->get_all_page($p["start"], $p["limit"], $p["str_order"] , $p["str_where"]);		
		// echo $this->db->last_query();
		// die();
		$arrdata = array();
		if (count($skp)>0){
			foreach ($skp as $key => $value) {							
				if ($value->status_approvement == 0) { 
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onEditSkp(\''.$value->id.'\')">Edit</a> | <a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onDeleteSkp(\''.$value->id.'\')">Delete</a> | <a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onDetail(\''.$value->id.'\')">Detail</a>';
				}else if ($value->status_approvement == 1) {
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="onDetail(\''.$value->id.'\')">Menunggu persetujuan atasan</a>';
				}else if ($value->status_approvement == 2) {
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="onDetail(\''.$value->id.'\')">Di koreksi Atasan</a>';
				}else {
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="onDetail(\''.$value->id.'\')">Disetujui atasan</a>';
				}				
				$arrdata[] = array(
					$value->startdate, 
					$value->enddate,
					$value->description,
					$str_edit);			
			}
		}

		if (count($arrdata) == 0){
			$arrdata[] = array("", "","","");			
		}
		
		$dbtotal = $this->skp->get_total( $p["str_order"] , $p["str_where"]);
		
		$data["draw"] = 0;
		$data["recordsTotal"] = $dbtotal->TOTAL;
		$data["recordsFiltered"] = $dbtotal->TOTAL;
		$data["data"] =  $arrdata;
		
		echo json_encode($data);				
    }

     public function ajax_list_listnilaibawahan(){
    	$nrk = $this->user['id'];
    	$nrk_atasan = $this->skp->atasan_cuti($nrk);	
    	$arr_fields = ["atasan","deleted_at", "status_approvement"];
		$arr_values = [$nrk,'is null',SKP_DITERIMA];
		$p = $this->get_params($arr_fields, $arr_values);
		$skp =  $this->skp->get_skp_join_penilaian($p["start"], $p["limit"], $p["str_order"] , $p["str_where"]);		
		$arrdata = array();
		if (count($skp)>0){
			foreach ($skp as $key => $value) {
				if ($value->penilaian_approvement == PENILAIAN_DIKIRIM){
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onPenilaian(\''.$value->id.'\')">Menunggu feedback bawahan</a>';
				}else{								
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onPenilaian(\''.$value->id.'\')">Input penilaian</a>';
				}				
				$arrdata[] = array(
					$value->startdate, 
					$value->enddate,
					$value->description,
					$str_edit);			
			}
		}

		if (count($arrdata) == 0){
			$arrdata[] = array("", "","","");			
		}
		
		$dbtotal = $this->skp->get_total( $p["str_order"] , $p["str_where"]);
		
		$data["draw"] = 0;
		$data["recordsTotal"] = $dbtotal->TOTAL;
		$data["recordsFiltered"] = $dbtotal->TOTAL;
		$data["data"] =  $arrdata;
		
		echo json_encode($data);				
    }

    public function ajax_list_hasilnilai(){
    	$nrk = $this->user['id'];
    	$nrk_atasan = $this->skp->atasan_cuti($nrk);	
    	$arr_fields = ["nrk","deleted_at", "status_approvement"];
		$arr_values = [$nrk,'is null',SKP_DITERIMA];
		$p = $this->get_params($arr_fields, $arr_values);
		$skp =  $this->skp->get_skp_join_penilaian($p["start"], $p["limit"], $p["str_order"] , $p["str_where"]);
		$arrdata = array();
		if (count($skp)>0){
			foreach ($skp as $key => $value) {
				if ($value->penilaian_approvement == PENILAIAN_DIKIRIM){
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onFeedback(\''.$value->id.'\')">Feedback</a>';
				}else{
					$str_edit = '<a href="javascript:void(0)" class="btn btn-sm btn-primary" onClick="onPenilaian(\''.$value->id.'\')">Feedback1</a>';
				}
				$arrdata[] = array(
					$value->startdate, 
					$value->enddate,
					$value->description,
					$str_edit);			
			}
		}

		if (count($arrdata) == 0){
			$arrdata[] = array("", "","","");			
		}
		
		$dbtotal = $this->skp->get_total( $p["str_order"] , $p["str_where"]);
		
		$data["draw"] = 0;
		$data["recordsTotal"] = $dbtotal->TOTAL;
		$data["recordsFiltered"] = $dbtotal->TOTAL;
		$data["data"] =  $arrdata;
		
		echo json_encode($data);				
    }

    public function ajax_list_skp_approval(){
    	$nrk = $this->user['id'];
    	$nrk_atasan = $this->skp->atasan_cuti($nrk);	
    	$arr_fields = ["atasan", "deleted_at"];
		$arr_values = [$nrk, 'is null'];
		$p = $this->get_params($arr_fields, $arr_values);					
		$skp =  $this->skp->get_all_page($p["start"], $p["limit"], $p["str_order"] , $p["str_where"]);						
		// echo $this->db->last_query();die();
		$arrData = array();
		if (count($skp)){
			foreach ($skp as $key => $value) {	
				if ($value->status_approvement == DIKIRIM || $value->status_approvement==SKP_DITERIMA){
					if ($value->status_approvement == DIKIRIM){
						$str_edit = '<a href="javascript:void(0)"  class="btn btn-sm btn-primary" onClick="onDetailApproval(\''.$value->id.'\')">Detail</a>';
					}else if ($value->status_approvement == SKP_DITERIMA){
						$str_edit = '<a href="javascript:void(0)"  class="btn btn-sm btn-warning" onClick="onDetailApproval(\''.$value->id.'\')">Disetujui</a>';
					}					
					$arrdata[] = array(
						$value->nama, 
						$value->startdate, 
						$value->enddate,
						$value->description,
						$str_edit);			
				}
			}
		}
		if (count($arrData)==0){
			$arrdata[] = array("","", "","","");			
		}
		
		$dbtotal = $this->skp->get_total( $p["str_order"] , $p["str_where"]);
		
		$data["draw"] = 1;
		$data["recordsTotal"] = $dbtotal->TOTAL;
		$data["recordsFiltered"] = $dbtotal->TOTAL;
		$data["data"] =  $arrdata;
		echo json_encode($data);					
    }

    public function edit_skp(){
    	$id = $this->input->get("id");
    	$arr_fields = ["id","deleted_at"];
		$arr_values = [$id,'is null'];		
		$skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");
    	$arr = array('response' => 'SUKSES', 'data' => $skp[0]);
        echo json_encode($arr);
    }

    public function get_params($arr_fields = array(), $arr_values = array()){
		$str_order = "";
		$str_where = "where ";
		$start 	=  $this->input->get("start");
		$limit 	=  $this->input->get("length");
		$draw 	=  $this->input->get("draw");
		if (empty($start)) $start = 0;
		if (empty($limit)) $limit = 10;	
		if (empty($draw)) $draw = 1;

		$str_order = 'order by "SKP"."startdate"';			

		foreach ($arr_fields as $key => $value) {
			if ($value=='deleted_at'){
					$str_where.= '"SKP"."'.$value.'" '.$arr_values[$key].' AND ' ;
			}else{
					$str_where.= '"SKP"."'.$value.'"=\''.$arr_values[$key].'\' AND ' ;
			}
		}

		if (isset($this->input->get("search")["value"])){
			$value = $this->input->get("search")["value"];
			$str_where .= ' ("SKP"."description" like \'%'.$value.'%\' OR "SKP"."startdate" like \'%'.$value.'%\' OR "SKP"."enddate" like \'%'.$value.'%\')';
		}
		$str_where = rtrim($str_where,'AND ');
		 // echo $str_where;die();
		return array("start" => $start, "limit" => $limit, "draw" => $draw, "str_where" => $str_where , "str_order" => $str_order);
	}



    public function list_skp(){    	
    	$is_back = $this->input->get("back");
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
        $tahun = date('Y');        
        $thbl = '201803'; //sementara
        
        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        // $firstCharacter = $infoUser->ESELON[0];
        // echo $firstCharacter;die();

        $data['infoUser'] = $infoUser;

        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;

        $pejtt = ""; 
        $jencuti = "";        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);                
        $nrk = $this->session->userdata["logged_in"]["nrk"];		     
        $arr_fields = ["NRK"];
		$arr_values = [$nrk];		
		// $jabatans = $this->skp->get_data($arr_fields, $arr_values, "PERS_DUK_PANGKAT");
		// $jabatan = array();
		// if (count($jabatans)>0){
		// 	$jabatan = $jabatans[0];
		// }
		// $data["jabatan"] = $jabatan;				

        if($cekaksesmenu == '1'){
        	if ($is_back){        		
        		$this->load->view('skp/_list_skp',$data);
        		$this->load->view('skp/list_skp_js',$data);                

        	}else{        		
	            $this->load->view('head/header',$this->user);
	            $this->load->view('head/menu',$datam);
	            $this->load->view('skp/list_skp',$data);
	            $this->load->view('skp/list_skp_js',$data);
	            $this->load->view('head/footer');
            }
        }else {
            $this->load->view('403');
        }    	   	
    	
	}

   	public function form_skp(){    	
    	$id = $this->input->get("id");    	 
    	$type = $this->input->get("type");    	 
    	$data["id"] = $id;
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

        $tahun = date('Y');        
        $thbl = '201803'; //sementara        
        $data["type"] = $type;
        $data["id"] = $id;
        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);

        $data['infoUser'] = $infoUser;

        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;
        

        $pejtt = ""; 
        $jencuti = "";        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);                
        $nrk = $this->session->userdata["logged_in"]["nrk"];		
        $arr_fields = ["id", "deleted_at"];
		$arr_values = [$id, 'is null'];		
		$skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 												

		$arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE"); 				
		//print_r($max_version->VERSION);die("a");
		$data["is_approved_target"] = false;
		if ($type=="mine"){						
			$data["skp"] = array();
			$data["skp_header"] = array();
			if (count($skp)>0){
				$data["skp_header"] = $skp[0];
				$data["is_approved_target"] = ($skp[0]->approved_target_by != $skp[0]->nrk);
				if (count($skp[0]) > 0){
					$version = $this->skp->max_skp_details($id);		
					$max_version = $version->VERSION;
					if (!$max_version){
						$max_version = 0;
					}
					if ($skp[0]->status_approvement=== DIKEMBALIKAN ){
						$data["skp"] = $this->skp->get_skp_new_target($id, ($max_version-1));
						$data["skp_koreksi"] = $this->skp->get_skp_new_target($id);
						$data["version"] = $this->skp->get_version($id);
						$data["max_version"] = $max_version;
					}else if ($skp[0]->status_approvement=== DIKIRIM){
						$data["skp"] = $this->skp->get_skp_new_target($id,  ($max_version-1));
					}else{
						$data["skp"] = $this->skp->get_skp_new_target($id);
					}
				}
			}
	        if($cekaksesmenu == '1'){
	            $this->load->view('skp/_form_skp',$data);
	        }else{
	            $this->load->view('403');
	        }
		}else{			
			$data["skp"] = array();
			if (count($skp)>0){
				$data["skp_header"] = $skp[0];				
				$data["skp"] = $this->skp->get_skp_new_target($id);
				$data["owner_skp"] = $this->home->getUserInfo2($data["skp_header"]->nrk);				

			}
	        if($cekaksesmenu == '1'){	     
	            $this->load->view('skp/_form_skp',$data);
	        }else {
	            $this->load->view('403');
	        }    	   		    	
		}
		$this->printskp = $data["skp"];		
	}

	public function approved_target(){
		$id = $this->input->post("id");		
    	$nrk = $this->user['id'];		
		$nrk_atasan = $this->skp->atasan_cuti($nrk);	
		$arr_column = array(
				"approved_target_by" => $nrk,
    			"approved_target_waiting" => $nrk_atasan,
    			"status_target" => 1);
		$arr_condition = array("id" => $id);
        $this->skp->sql_update($arr_column, $arr_condition, "SKP"); 		
        $a = array('response' => 'SUKSES');
		echo json_encode($a);	
	}

	public function save_skp(){		
		$nrk = $this->user['id'];	
		$startdate = $this->input->post('startdate');
		$arr_startdate = explode("/",$startdate);
		$startdate = $arr_startdate[2]."/".$arr_startdate[1]."/".$arr_startdate[0];

		$enddate = $this->input->post('enddate');
		$arr_enddate = explode("/", $enddate);
		$enddate = $arr_enddate[2]."/".$arr_enddate[1]."/".$arr_enddate[0];

		$desc = $this->input->post('desc');	
		$id = $this->input->post('id');		
		$str_where = 'where "nrk"=\''.$nrk.'\' AND ( (TO_DATE(\''.$startdate.'\',\'yyyy/mm/dd\') BETWEEN  "startdate" AND "enddate") OR (TO_DATE(\''.$enddate.'\',\'yyyy/mm/dd\') BETWEEN  "startdate" AND "enddate") ) AND "deleted_at" is null';		
		$dbtotal = $this->skp->get_total( "",  $str_where);
		if ($dbtotal->TOTAL > 0){
			$a = array('response' => 'ERROR', "description" => "sudah terisi oleh kegiatan lainnya<br/><br/>");
			echo json_encode($a);
			exit();
		}


		if ($id == ""){							
			$nrk = $this->user['id'];			
			$username = $this->user['username'];		
			$nrk_atasan = $this->skp->atasan_cuti($nrk);		
			$id = $this->id();
			$fields = array(
				"id" => $id,
				"nrk" => $nrk,				
				"nama"=> $username,
				"approved_by" => $nrk,
				"approved_waiting" => $nrk_atasan,
				"approved_target_by" => $nrk,
				"approved_target_waiting" => $nrk_atasan,					
				"atasan" => $nrk_atasan,	
				"created_by" => $nrk,
				"updated_by" => $nrk,
				"created_at" => 'CURRENT_TIMESTAMP',
				"updated_at" => 'CURRENT_TIMESTAMP',
				"status_approvement" => "0",
				"status_realisasi" => "0",
				"startdate" => 'TO_DATE(\''.$startdate.'\',\'yyyy/mm/dd\')',
				"enddate" => 'TO_DATE(\''.$enddate.'\',\'yyyy/mm/dd\')',
				"description" => $desc,
			);
			$this->skp->sql_insert2("SKP", $fields); 			
		}else{			
			 $arr_column = array(
			 	"startdate" => 'TO_DATE(\''.$startdate.'\',\'yyyy/mm/dd\')',
				"enddate" => 'TO_DATE(\''.$enddate.'\',\'yyyy/mm/dd\')',
				"description" => $desc,
			 );			             
            $arr_condition = array("id" => $id);            
            $this->skp->insert_log("SKP", $id);            
            $this->skp->sql_update($arr_column, $arr_condition, "SKP"); 
		}
		$a = array('response' => 'SUKSES');
		echo json_encode($a);		
	}

	public function view_version_skp(){
		$nrk = $this->user['id'];
		$id = $this->input->post("id");
		$version = $this->input->post("version");
		$arr_fields = ["skp_id","version"];
		$arr_values = [$id, $version];		
		$data["skp"] = $this->skp->get_skp_new_target($id, $version); 						
		$this->load->view('skp/_history',$data);		
	}

	public function delete_skp_header(){
		$nrk = $this->user['id'];
		$id = $this->input->get("id");
		$this->skp->insert_log("SKP", $id);            
		$arr_column = array("deleted_at" => "CURRENT_TIMESTAMP",
							"deleted_by" => $nrk );
		$arr_condition = array("id" => $id);
        $this->skp->sql_update($arr_column, $arr_condition, "SKP"); 

        $arr_column = array("deleted_at" => "CURRENT_TIMESTAMP",
    		"deleted_by" => $nrk);
		$arr_condition = array("skp_id" => $id);
        $this->skp->sql_update($arr_column, $arr_condition, "SKP_DETAILS"); 


		$arr_column = array("deleted_at" => "CURRENT_TIMESTAMP",
    		"deleted_by" => $nrk);
		$arr_condition = array("skp_id" => $id);
        $this->skp->sql_update($arr_column, $arr_condition, "SKP_TARGET"); 

        $a = array('response' => 'SUKSES');
		echo json_encode($a);		
	}

	public function tambah_skp(){		
		$id = $this->input->post('id');					
		$input = $this->input->post('data');			
		$nrk = $this->session->userdata["logged_in"]["nrk"];
		$username = $this->session->userdata["logged_in"]["username"];	
		//var_dump($username);die;  
		$nrk_atasan = $this->skp->atasan_cuti($nrk);

		$this->skp->insert($nrk, $username, $nrk_atasan, $id, $input);

		$arr_fields = ["id"];
		$arr_values = [$id];
		$skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");		
		$data["skp"] = array();
		if (count($skp)>0){			
			$data["skp"] = $this->skp->get_skp_new_target($skp[0]->id);  		   															
		}
		
		$array = array('response' => 'SUKSES', 'data' => $data["skp"]);
		echo json_encode($array);		
	}

	public function update_approval(){
		$id = $this->input->post('id');
		$value =$this->input->post('value');
		$arr_id_target = $this->input->post('arr_id_target');		
		
		if ($value === DIKIRIM){
				$version = $this->skp->max_skp_details($id);		
				$max_version = $version->VERSION;
				if (!$max_version){
					$max_version = 0;
				}
        		$arr_fields = ["skp_id", "status", "deleted_at"];
				$arr_values = [$id, "1",null];		        
				$skp_details = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");
		        
        		$arr_column = array("status" => "0", "status_koreksi" => "0");
				$arr_condition = array("skp_id" => $id);
        		$this->skp->sql_update($arr_column, $arr_condition, "SKP_DETAILS"); 		        
		        

		        foreach ($skp_details as $key => $detail) {		        	
		        	$details = (Array)$detail;		        	
		        	$details["id"] =  $this->id(); 	
		        	$details["version"] = $details["version"]+1;
		        	$details["status"] = "1";		        	
		        	$this->skp->sql_insert2("SKP_DETAILS", $details);		        	
		        }
		}

		$arr_column = array("status_approvement" => $value);
		$arr_condition = array("id" => $id);		
        $this->skp->sql_update($arr_column, $arr_condition, "SKP");       
        
        $a = array('response' => 'SUKSES');
		echo json_encode($a);			
	}

	public function add_skp_inisialisasi(){

		$utama = $this->input->post('existing');				
		$tambahan_existing = $this->input->post('add_existing');				
		$tambahan_new = $this->input->post('add_new');
		$tambahan_existing_kreatifitas = $this->input->post('existing_kreatifitas');				
		$tambahan_new_kreatifitas = $this->input->post('new_kreatifitas');

		$input = $this->input->post('data');
		$ids = $this->input->post('id');

		 // echo "<pre>";
		 // print_r($tambahan_new);die;
		//dari id  yang ada dapatkan informasinya;
		// tampung nlai nrk dengan nilai dari informasinya
		// username 

		/*$nrk = $this->session->userdata["logged_in"]["nrk"];
		*/
	

		// ini update type_kegiatan = 1
		foreach ($utama as $key => $value) {
            $idchild = $this->id();          
            $id_detail = $this->id();
            $fields = array("id" => $idchild , 
            				"id_details" => $id_detail,
            				"skp_id" => $ids, 
            				"kegiatan"=> $value[0],                         	
            				"quantity" => $value[1], 
                        	"output" => $value[2], 
                        	"quality" => $value[3], 
                        	"total_month" => $value[4], 
                        	"biaya" => $value[5], 
                        	"status" => "1", 
                        	"created_at" => 'CURRENT_TIMESTAMP');                  
            $sql = $this->skp->sql_insert2("SKP_DETAILS", $fields);                    
        };

        // ini update type_kegiatan = 2
        if (count($tambahan_existing) > 0){
	        foreach ($tambahan_existing as $key => $value) {
	            $idchild = $this->id();
	            $id_detail = $this->id();
	            $fields = array("id" => $idchild , 
	            				"id_details" => $id_detail,
	            				"skp_id" => $ids, 
	                        	"kegiatan"=> $value[0],                         	
	                        	"quantity" => $value[1], 
	                        	"output" => $value[2], 
	                        	"quality" => $value[3], 
	                        	"total_month" => $value[4], 
	                        	"biaya" => $value[5], 
	                        	"status" => "1", 
	                        	"created_at" => 'CURRENT_TIMESTAMP');	            
	            $sql = $this->skp->sql_insert2("SKP_DETAILS", $fields);                    	            
	        };
        }

        // ini update type_kegiatan = 2
        if (count($tambahan_new) > 0){
	        foreach ($tambahan_new as $key => $value) {
	            $idchild = $this->id();                    
	            $id_detail = $this->id();
	            $fields = array("id" => $idchild , 
	            				"id_details" => $idchild,                         	
	            				"skp_id" => $ids, 
	                        	"kegiatan"=> $value[0],	
	                        	"ak" => $value[1],                        	
	                        	"quantity" => $value[2], 
	                        	"output" => $value[3], 
	                        	"quality" => $value[4], 
	                        	"total_month" => $value[5], 
	                        	"biaya" => $value[6],
	                        	"ak_realisasi" => $value[7],
	                        	"qty_realisasi" => $value[8],
	                        	"output_realisasi" => $value[9],
	                        	"quality_realisasi" => $value[10],
	                        	"waktu_realisasi" => $value[11], 
	                        	"biaya_realisasi" => $value[12],
	                        	"status" => "1",
	                        	"type_kegiatan"=> "2",                            	
	                        	"created_at" => 'CURRENT_TIMESTAMP');                  
	            
	            $sql = $this->skp->sql_insert2("SKP_DETAILS", $fields);                    	           
	        };
    	}

    	// ini update type_kegiatan = 3
        if (count($tambahan_existing_kreatifitas) > 0){
	        foreach ($tambahan_existing_kreatifitas as $key => $value) {
	            $idchild = $this->id();  
	            $id_detail = $this->id();                  
	            $fields = array("id" => $idchild ,
	            				"id_details" => $idchild,                         	 
	            				"skp_id" => $ids, 
	                        	"kegiatan"=> $value[0],                         	
	                        	"quantity" => $value[1], 
	                        	"output" => $value[2], 
	                        	"quality" => $value[3], 
	                        	"total_month" => $value[4], 
	                        	"biaya" => $value[5], 
	                        	"status" => "1", 
	                        	"created_at" => 'CURRENT_TIMESTAMP');
	            $sql = $this->skp->sql_insert2("SKP_DETAILS", $fields);                    	            
	        };
        }

        // ini update type_kegiatan = 3
        if (count($tambahan_new_kreatifitas) > 0){
	        foreach ($tambahan_new_kreatifitas as $key => $value) {
	            $idchild = $this->id();                    
	            $id_detail = $this->id();  
	            $fields = array("id" => $idchild , 
	            				"id_details" => $idchild,                         	
	            				"skp_id" => $ids, 
	                        	"kegiatan"=> $value[0],	
	                        	"ak" => $value[1],                        	
	                        	"quantity" => $value[2], 
	                        	"output" => $value[3], 
	                        	"quality" => $value[4], 
	                        	"total_month" => $value[5], 
	                        	"biaya" => $value[6],
	                        	"ak_realisasi" => $value[7],
	                        	"qty_realisasi" => $value[8],
	                        	"output_realisasi" => $value[9],
	                        	"quality_realisasi" => $value[10],
	                        	"waktu_realisasi" => $value[11], 
	                        	"biaya_realisasi" => $value[12],
	                        	"status" => "1",
	                        	"type_kegiatan"=> "3",                            	
	                        	"created_at" => 'CURRENT_TIMESTAMP'); 
	           //  echo "<pre>";
	           // print_r($fields);die("aa");
	            // echo $this->db->last_query();
	            
	            $sql = $this->skp->sql_insert2("SKP_DETAILS", $fields);                    
	            // echo "<br>";
	            //  echo $this->db->last_query();
	            //  die("bb");
	        };
    	}


   //  		echo $this->db->last_query();
			// die();
			$arr_fields = ["skp_id","deleted_at"];
			$arr_values = [$ids, ""];			
			
			$data["doc_master"] = $this->skp->get_data([], [], "SKP_MASTER_DOC_TYPE");

			//$data["skp"] = $this->skp->get_skp_target($ids); 			
			$data["skp"] = $this->skp->get_skp_target_pengukuran($ids); 
			// echo "<pre>"; 
			// //print_r($data["skp"]);
			 // echo $this->db->last_query();
			 // die();			   		
		
		$array = array('response' => 'SUKSES', 'data' => $data["skp"],'doc_master' => $data["doc_master"]);	
		echo json_encode($array);
	}

	public function update_skp(){				
		$input = $this->input->post('data');
		$type = $this->input->post('type');
		$id = $this->input->post('id');		
		$nrk = $this->user['id'];					
		$data = $this->skp->update($id, $input, $nrk, $type);
		$a = array('response' => 'SUKSES', 'data' => $input, "id" => $id);
		echo json_encode($a);	

	}

	public function delete_skp(){
		$nrk  = $this->input->post('data');
		$id = $this->input->post('id');		
		$data = $this->skp->delete($id, $nrk);		
		$a = array('response' => 'SUKSES');
		echo json_encode($a);				
	}


	public function perilaku_kerja(){
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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);

        $data['infoUser'] = $infoUser;

        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;

        $data['nrk_atasan_es3'] = $this->skp->atasan_cuti($nrk_atasan);        
        $nrk_atasan_s3 = $data['nrk_atasan_es3'];


        $infoUserAtasanEs3 = $this->home->getUserInfo2($nrk_atasan_s3);
        $data['infoUserAtasan_es3'] = $infoUserAtasanEs3;
        // echo "<pre>";
        // print_r($data);

        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);
        

        if($cekaksesmenu == '1'){
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('skp/perilaku_kerja',$data);                
                $this->load->view('head/footer');   
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function pengukuran(){
		// START GET NRK        
		$skp_id = $this->input->get("skp_id");
		$nrk_bawahan = $this->input->get("nrk_bawahan");

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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 
        $data["skp_id"] = $skp_id;
        $data["nrk_bawahan"] = $nrk_bawahan;

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;

        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);
        
        $arr_fields = ["id","deleted_at"];
		$arr_values = [$skp_id,""];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 
        // echo "<pre>";
        // var_dump($skp);die;
        $data["skp_h"]=$skp;

        $arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE"); 

		if (count($skp)>0){
			$data["skp"] = $this->skp->get_skp_new_target($skp[0]->id);

			 // echo $this->db->last_query();
			 // die();
			// echo "<pre>";
			// print_r($data["skp"]);
			// die();
			// $arr_fields = ["skp_id", "delete_at"]; // skp_id pada tabel skp details 
			// $arr_values = [$skp[0]->id, ""];			
			// $data["skp"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");  		   			

		}		
        if($cekaksesmenu == '1'){
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('skp/pengukuran',$data);                
                $this->load->view('head/footer');   
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function pengukuran2(){
		// START GET NRK        
		$skp_id = $this->input->get("skp_id");	
		$nrk_bawahan = $this->input->get("nrk_bawahan");

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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 

        $data["skp_id"] = $skp_id;
        $data["nrk_bawahan"] = $nrk_bawahan;

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;


        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        

        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);
        
        $arr_fields = ["id"];
		$arr_values = [$skp_id];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");  
        $data["skp_h"]=$skp;

        $arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE");								

		if (count($skp)>0){
			$data["skp"] = $this->skp->get_skp_new_target($skp[0]->id);
			// $arr_fields = ["skp_id"]; // skp_id pada tabel skp details 
			// $arr_values = [$skp[0]->id];			
			// $data["skp"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");  		   
		}		
        if($cekaksesmenu == '1'){
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('skp/pengukuran2',$data);                
                $this->load->view('head/footer');   
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function pengukuran3(){
		// START GET NRK        
		$skp_id = $this->input->get("skp_id");
		$nrk_bawahan = $this->input->get("nrk_bawahan");

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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 
        $data["skp_id"] = $skp_id;
        $data["nrk_bawahan"] = $nrk_bawahan;

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;

        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);
        
        $arr_fields = ["id","deleted_at"];
		$arr_values = [$skp_id,""];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 
        // echo "<pre>";
        // var_dump($skp);die;
        $data["skp_h"]=$skp;

        $arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE");

		if (count($skp)>0){
			$data["skp"] = $this->skp->get_skp_new_target($skp[0]->id);

			 // echo $this->db->last_query();
			 // die();
			// echo "<pre>";
			// print_r($data["skp"]);
			// die();
			// $arr_fields = ["skp_id", "delete_at"]; // skp_id pada tabel skp details 
			// $arr_values = [$skp[0]->id, ""];			
			// $data["skp"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");  		   			

		}		
        if($cekaksesmenu == '1'){
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('skp/pengukuran3',$data);                
                $this->load->view('head/footer');   
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function list_penilaian(){
		$is_back = $this->input->get("back");
        $nrk = $this->user['id'];                    
        $tahun = date('Y');        
        $thbl = '201803'; //sementara
        
        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);

        $data['infoUser'] = $infoUser;

        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;

        $pejtt = ""; 
        $jencuti = "";        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='30423';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);                
        $nrk = $this->session->userdata["logged_in"]["nrk"];		     
        $arr_fields = ["NRK"];
		$arr_values = [$nrk];

        if($cekaksesmenu == '1'){
        	if ($is_back){
        		$this->load->view('skp/_list_penilaian',$data);
		        $this->load->view('skp/list_penilaian_js',$data);
        	}else{
	        	$this->load->view('head/header',$this->user);
		        $this->load->view('head/menu',$datam);
		        $this->load->view('skp/list_penilaian',$data);
		        $this->load->view('skp/list_penilaian_js',$data);
		        $this->load->view('head/footer');
	        }
        }else {
            $this->load->view('403');

        }    	   	
	}

	public function penilaian(){
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

        $skp_id = $this->input->get("skp_id");
        $data["skp_id"] = $skp_id;


        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $pejtt = ""; 
        $jencuti = "";
        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='29438';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        $arr_fields = ["id"];
		$arr_values = [$skp_id];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 
        if (count($skp)> 0){
        	$skp = $skp[0];
        }

        $nrk_skp = $skp->nrk;

        $infoUser = $this->home->getUserInfo2($nrk_skp);
        $data['infoUser'] = $infoUser;                
        if ($infoUser->ESELON[0]!='2'){
        	$data['nrk_atasan'] = $this->skp->atasan_cuti($nrk_skp);        
        	$nrk_atasan = $data['nrk_atasan'];
        	$infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        	$data['infoUserAtasan'] = $infoUserAtasan;
        	// echo "<pre>";print_r($infoUserAtasan);die();
        	if ($infoUserAtasan->ESELON[0]!='2'){
        		$data['nrk_atasan_es3'] = $this->skp->atasan_cuti($nrk_atasan);                		
        		if ( isset($data['nrk_atasan_es3']) ) {        			
	        		$nrk_atasan_s3 = $data['nrk_atasan_es3'];
	        		$infoUserAtasanEs3 = $this->home->getUserInfo2($nrk_atasan_s3);
	        		$data['infoUserAtasan_es3'] = $infoUserAtasanEs3;
        		}
        	}
        }        

        
        $arr_fields = ["skp_id"];
		$arr_values = [$skp_id];
        $nilai = $this->skp->get_data($arr_fields, $arr_values, "SKP_PENILAIAN"); 
        if (count($nilai)> 0){
        	$nilai = $nilai[0];
        }
        $data["nilai"] = $nilai;

        if($cekaksesmenu == '1'){                
                $this->load->view('skp/_penilaian',$data);                                
                $this->load->view('skp/list_penilaian_js',$data); 
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function penilaian_feedback(){
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

        $skp_id = $this->input->get("skp_id");
        $data["skp_id"] = $skp_id;


        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $pejtt = ""; 
        $jencuti = "";
        
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='29438';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        $arr_fields = ["id"];
		$arr_values = [$skp_id];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 
        if (count($skp)> 0){
        	$skp = $skp[0];
        }

        $nrk_skp = $skp->nrk;

        $infoUser = $this->home->getUserInfo2($nrk_skp);
        $data['infoUser'] = $infoUser;                
        if ($infoUser->ESELON[0]!='2'){
        	$data['nrk_atasan'] = $this->skp->atasan_cuti($nrk_skp);        
        	$nrk_atasan = $data['nrk_atasan'];
        	$infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        	$data['infoUserAtasan'] = $infoUserAtasan;
        	// echo "<pre>";print_r($infoUserAtasan);die();
        	if ($infoUserAtasan->ESELON[0]!='2'){
        		$data['nrk_atasan_es3'] = $this->skp->atasan_cuti($nrk_atasan);                		
        		if ( isset($data['nrk_atasan_es3']) ) {        			
	        		$nrk_atasan_s3 = $data['nrk_atasan_es3'];
	        		$infoUserAtasanEs3 = $this->home->getUserInfo2($nrk_atasan_s3);
	        		$data['infoUserAtasan_es3'] = $infoUserAtasanEs3;
        		}
        	}
        }        

        
        $arr_fields = ["skp_id"];
		$arr_values = [$skp_id];
        $nilai = $this->skp->get_data($arr_fields, $arr_values, "SKP_PENILAIAN"); 
        if (count($nilai)> 0){
        	$nilai = $nilai[0];
        }
        $data["nilai"] = $nilai;

        if($cekaksesmenu == '1'){                
                $this->load->view('skp/_penilaian',$data);                                
                $this->load->view('skp/list_penilaian_js',$data); 
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function list_popup_kegiatan(){
		$nrk = $this->user['id'];
		$infoUser = $this->home->getUserInfo2($nrk);
		$refensi = array("kolok" => $infoUser->KOLOK, "kojab" => $infoUser->KOJAB);
		if ($infoUser->ESELON=="00"){
			$atasan = $this->skp->atasan_cuti($nrk);
			$infoatasan = $this->home->getUserInfo2($atasan);
			$refensi["kojab"] = $infoatasan->KOJAB;			
		}		
		$type = $this->input->post("type");
		$data = array();
		if ($type == "tupoksi"){
			$arr_fields = ["kolok","kojab"];
			$arr_values = [$refensi["kolok"], $refensi["kojab"]];
			$data = $this->skp->get_skp_kegiatan_tupoksi($refensi["kolok"],$refensi["kojab"]); 		
		}
		$a = array("response" => "SUKSES", "data"=> $data);
		echo json_encode($a);
	}

	public function list_popup_kegiatan1(){
		print_r($_POST);

		$type = $this->input->post("type");
		$data = array();
		if ($type == "tupoksi"){
			$arr_fields = [];
			$arr_values = [];
			$data = $nilai = $this->skp->get_data($arr_fields, $arr_values, "SKP_TUPOKSI"); 		
		}
		$a = array("response" => "SUKSES", "data"=> $data);
		echo json_encode($a);
	}

	public function list_pengukuran(){
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


        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['infoUser'] = $infoUser;

        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'skp',0);
        $datam['inisial'] = 'skp';

        $menuid='29438';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);
        
        if($cekaksesmenu == '1'){
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('skp/list_pengukuran',$data);                
                $this->load->view('head/footer');   
        }else {
            $this->load->view('403');
        }    	   	
	}

	public function simpan_penilaian(){
		$nrk = $this->user['id'];   
		$skp_id = $this->input->post("skp_id");
		$arr_fields = ["skp_id"];
		$arr_values = [$skp_id];
        $skp_penilaian = $this->skp->get_data($arr_fields, $arr_values, "SKP_PENILAIAN"); 

        $arr_fields = ["id"];
		$arr_values = [$skp_id];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP"); 
        if (count($skp)>0){
        	$skp= $skp[0];
        }

        if (count($skp_penilaian)==0){
        	$fields = $this->input->post("data");
        	$fields["skp_id"] = $skp_id;        	
        	$fields["nrk"] = $skp->nrk;  
        	$fields["nrk_atasan"] = $nrk;  
        	$fields["id"] = $this->id();
        	$fields["created_at"] = 'CURRENT_TIMESTAMP';
        	$fields["created_by"] = $nrk;
        	$fields["penilaian_approvement"] = 0;        	
        	$sql = $this->skp->sql_insert2("SKP_PENILAIAN", $fields);        	
        }else{
        	$arr_column = $this->input->post("data"); 
        	$arr_column["updated_at"] = 'CURRENT_TIMESTAMP';
        	$arr_column["updated_by"] = $nrk;
        	$arr_condition = array("skp_id" => $skp_id); 
        	$this->skp->sql_update($arr_column, $arr_condition, "SKP_PENILAIAN"); 
        }
        $a = array("response" => "SUKSES");
    	echo json_encode($a);
	}

	public function kirim_penilaian(){
		$nrk = $this->user['id'];   
		$skp_id = $this->input->post("skp_id");
		$arr_column = $this->input->post("data"); 
        $arr_column["updated_at"] = 'CURRENT_TIMESTAMP';
        $arr_column["updated_by"] = $nrk;
        $arr_column["penilaian_approvement"] = 1;        	
        $arr_condition = array("skp_id" => $skp_id); 
        $this->skp->sql_update($arr_column, $arr_condition, "SKP_PENILAIAN"); 
        $a = array("response" => "SUKSES");
    	echo json_encode($a);
	}

	// tampil list SKP
	public function ajax_list()
	{
		//echo "tes";
		$nrk = $this->user['id'];		
		$list = $this->skp->get_datatables1($nrk);	
		//echo $this->db->last_query();die();	
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $skp) {
			$no++;
			$row = array();
			$row[] = $skp->nrk;
			$row[] = $skp->nama;
			$row[] = $skp->startdate;
			$row[] = $skp->enddate;
			$row[] = $skp->description;
			//$row[] = $skp->thbl;

			//add html for action

			if ($skp->nrk==$nrk){
				if ($skp->status_approvement== STATUS_INPUT_USULAN){ // STATUS_INPUT_USULAN pada file constanst.php
					$row[] = '<a class="btn btn-sm btn-primary" href="pengukuran3?skp_id='.$skp->id.'" title="Input Usulan"><i class="glyphicon glyphicon-pencil"></i>Input Usulan</a>
				  	  ';
				}
				else {
					$row[] = '<a class="btn btn-sm btn-primary" href="pengukuran2?skp_id='.$skp->id.'" title="Input Realisasi"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
				  	  ';
				}
			}
			// else {
			// 	$row[] = '<a class="btn btn-sm btn-primary" href="pengukuran?skp_id='.$skp->id.'" title="Input Realisasi"><i class="glyphicon glyphicon-pencil"></i> Input Realisasi</a>
					  
			// 	  	  ';
			// }
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->skp->count_all(),
						"recordsFiltered" => $this->skp->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	// tampil list SKP Atasan
	public function ajax_list2()
	{
		//echo "tes";
		$nrk = $this->user['id'];
		//var_dump($nrk);die;		
		$list = $this->skp->get_datatables2($nrk);		
		 // echo $this->db->last_query();die();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $skp) {
			$no++;
			$row = array();
			$row[] = $skp->nrk;
			$row[] = $skp->nama;
			$row[] = $skp->startdate;
			$row[] = $skp->enddate;
			$row[] = $skp->description;

			//add html for action
			//echo $skp->status_approvement."==".STATUS_INPUT_REALISASI;
			//die();
			// echo $this->db->last_query();
			// print_r($skp);die();
			
			if ($skp->status_approvement== STATUS_INPUT_REALISASI){ // STATUS_INPUT_REALISASI pada file constanst.php
				$row[]='<a class="btn btn-sm btn-primary" href="pengukuran?skp_id='.$skp->id.'&amp;nrk_bawahan='.$skp->nrk.'" title="Input Realisasi"><i class="glyphicon glyphicon-pencil"></i> Input Realisasi</a>';'					  	  ';
			}else if ($skp->status_approvement== STATUS_REALISASI_DITERIMA){
				$row[] = '<a class="btn btn-sm btn-primary" href="pengukuran2?skp_id='.$skp->id.'" title="Input Realisasi"><i class="glyphicon glyphicon-pencil"></i>Disetujui Penilai</a>
				  	  ';
			} else {
					$row[] = '<a class="btn btn-sm btn-primary" href="pengukuran2?skp_id='.$skp->id.'" title="Input Realisasi"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
				  	  ';
				
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->skp->count_all2(),
						"recordsFiltered" => $this->skp->count_filtered2(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function cetak_skp(){
		$nrk = $this->user['id'];
		$id = $this->input->get("id");
		$infoUser = $this->home->getUserInfo2($nrk);
		$nrk_atasan = $this->skp->atasan_cuti($nrk);
        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);        	

        $arr_fields = ["id"];
		$arr_values = [$id];
        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");          
        if (count($skp) > 0){
        	$skp = $skp[0];
        }

        if ($skp->status_approvement == DIKIRIM){
        	$version = $this->skp->max_skp_details($id);		
			$max_version = $version->VERSION;
			if (!$max_version){
				$max_version = 0;
			}
        	$skp_details = $this->skp->get_skp_new_target($id, ($max_version-1));
        }else{
        	$skp_details = $this->skp->get_skp_new_target($id);	
        }
        
		
		
		$page = 1;
		$row = 1; 

        $this->load->library("pdf_skp");
        $pdf = new pdf_skp('P', 'mm', 'F5', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-25, PDF_MARGIN_RIGHT);
        $pdf->AddPage("L");
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);
        $html = '

		<html>
		    <head>
		        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		        <meta http-equiv="Content-Style-Type" content="text/css" /> 
		        <meta name="generator" content="Aspose.Words for .NET 17.1.0.0" />
		        <title></title>
		    </head>
		    <body>
		   	<p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:9pt"><span style="font-family:Arial; font-weight:bold">SASARAN KERJA</span></p>
		    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:9pt"><span style="font-family:Arial; font-weight:bold">PEGAWAI NEGERI SIPIL</span></p>

		               
		                        
		        <br>
		    	<br>
		    	<table border="1" cellpadding="2" width="100%"  style="font-size:8px">
		        
                                                            <tr>
                                                                <th width="3%">NO</th>
                                                                <th colspan="2" width="55%">I. PEJABAT PENILAI</th>
                                                                <th width="3%">NO</th>
                                                                <th colspan="5" width="40%">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
                                                            </tr>
                                                        
                                                            <tr>
                                                                <td>1</td>
                                                                <td  width="35%">Nama</td>
                                                                <td width="20%">'.$infoUserAtasan->NAMA_ABS.'</td>
                                                                <td>1</td>
                                                                <td colspan="2">Nama</td> 
                                                                <td colspan="3">'.$infoUser->NAMA_ABS.'</td>
                                                            </tr>
                                                             <tr>
                                                                <td>2</td>
                                                                <td>NIP</td>
                                                                <td>'.$infoUserAtasan->NIP18.'</td>
                                                                <td>2</td>
                                                                <td colspan="2">NIP</td> 
                                                                <td colspan="3">'.$infoUser->NIP18.'</td>
                                                            </tr>
                                                             <tr>
                                                                <td>3</td>
                                                                <td>Pangkat/Gol.Ruang</td>
                                                                <td>'.$infoUserAtasan->NAPANG.'('.$infoUserAtasan->GOL.')</td>
                                                                <td>3</td>
                                                                <td colspan="2">Pangkat/Gol.Ruang</td> 
                                                                <td colspan="3">'.$infoUser->NAPANG.'('.$infoUser->GOL.')</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>Jabatan</td>
                                                                <td>'.$infoUserAtasan->NAJABL.'</td>
                                                                <td>4</td>
                                                                <td colspan="2">Jabatan</td> 
                                                                <td colspan="3">'.$infoUser->NAJABL.'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Unit Kerja</td>
                                                                <td>'.$infoUserAtasan->NALOKL.'</td>
                                                                <td class="center">5</td>
                                                                <td colspan="2">Unit Kerja</td> 
                                                                <td colspan="3">'.$infoUser->NALOKL.'</td>
                                                            </tr>';
			$html.=  $this->getHtmlHeader();              
            $html.= '<tbody>';
            foreach ($skp_details as $key => $value){  
            	$biaya = $value->biayashow;
            	if ($value->biayashow ==0){
            		$biaya = "-";
            	}
            	if ( (($key+1) % 7) == 0 ){
            		$html .= '</tbody></table>';
            		$pdf->writeHTML($html, true, false, true, false, '');
            		$pdf->AddPage('L');            		
            		$html = "&nbsp;<br/><br/>";            		
            		$html .= '<table border="1" cellpadding="2" width="100%"  style="font-size:8px">';
            		$html .= $this->getHtmlHeader();              
            		
            		
            	}
		    		$html=$html.'<tr>
                                                                <td>'.($key+1).'</td>
                                                                <td>'.$value->kegiatan.'</td>
                                                                <td>'.$value->ak.'</td>
                                                                <td>'.$value->quantityshow.'</td>
                                                                <td>'.$value->outputshow.'</td> 
                                                                <td>100</td>
                                                                <td>'.$value->total_monthshow.'</td>
                                                                <td>bulan</td>
                                                                <td>'.$biaya.'</td>                                                                
                                                            </tr>';
            }              

            $html=$html.'</tbody>
                                </table>                                    

		     	<br> <br>
		        <table border="0" cellpadding="0" width="100%"  style="font-size:8px">
		                <tr>
		                	<td width="50%">
		                		&nbsp;
		                	</td>
		                	<td width="50%" style="text-align:center">Jakarta, 2 January 2019</td>
		                </tr>		                
		                <tr>
		                    <td style="text-align:center">		                        
		                        	Pejabat Penilai<br/><br/><br/><br/>
		                        	'.$infoUserAtasan->NAMA_ABS.'<br/>
		                        	'.$infoUserAtasan->NIP18.'
		                       
		                    </td>
		                    <td  style="text-align:center">		                    	
		                        	Pegawai Negeri Sipil Yang di Nilai<br/><br/><br/><br/>               
		                        	'.$infoUser->NAMA_ABS.'<br/>
		                        	'.$infoUser->NIP18.'
		                    </td>
		                </tr>		            
		        </table>		    	
			                
			</body>
		</html>';		
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('skp.pdf', 'I');
    }

    public function getHtmlHeader(){
    	$html = '<tr>
                                                                <th rowspan="2" width="3%">NO</th>
                                                                <th rowspan="2" width="35%">III. KEGIATAN TUGAS JABATAN</th>
                                                                <th rowspan="2" width="20%">AK</th>                                             
                                                                <th colspan="6" width="43%">TARGET</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2">KUANT/OUTPUT</th>
                                                                <th>KUAL/MUTU</th>
                                                                <th colspan="2">Waktu</th>
                                                                <th>Biaya</th>                                                                
                                                            </tr>';
                                                            return $html;
    }

    public function cetak_pengukuran(){
		// START GET NRK        
		$skp_id = $this->input->get("skp_id");
		$nrk_bawahan = $this->input->get("nrk_bawahan");

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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 
        $data["skp_id"] = $skp_id;
        $data["nrk_bawahan"] = $nrk_bawahan;

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

       $infoUser = $this->home->getUserInfo2($nrk);
        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;

        //var_dump($infoUserAtasan);die;
        //var_dump($nrk_atasan);die;
        //var_dump($infoUser);die;
        $data['infoUser'] = $infoUser;
		$arr_fields = ["id"];
		$arr_values = [$skp_id];
		// $skp_id=$this->input->get('skp_id');
		// //print_r($skp_id);die;

        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");
        //echo "<pre>";
        // print_r($skp);die;
        $data["skp_h"]=$skp; 
 
        //print_r($data["skp_h"][0]->status_approvement);die;
        //echo $data["skp_h"][0]->status_approvement;die;
        $arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE"); 
		
		//print_r($skp[0]->id);die;

		// if (count($skp)>0){
			$data["skp"] = $this->skp->get_skp_new_target($skp_id);

			 // echo $this->db->last_query();
			 // die();
			// echo "<pre>";
			// print_r($data["skp"]);
			// die();
			// $arr_fields = ["skp_id", "delete_at"]; // skp_id pada tabel skp details 
			// $arr_values = [$skp[0]->id, ""];			
			// $data["skp"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");  		   			

		//}		
        $this->load->library("pdf_skp");
        $pdf_cuti = new pdf_skp('P', 'mm', 'F5', true, 'UTF-8', false);

        // ob_start();

        $pdf_cuti->SetCreator(PDF_CREATOR);
        // Add a page
        // ob_start();
        $pdf_cuti->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-25, PDF_MARGIN_RIGHT);
        // $pdf_cuti->Output('name.pdf', 'D');
        $pdf_cuti->AddPage('L');
        //$pdf_cuti->writeHTML('IWK');
      
        //$pdf_cuti->AddPage('L');
        $pdf_cuti->SetFont('helvetica', '', 6);

        // add a page
        // $this->pdf_cuti->AddPage();

        $pdf_cuti->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);

        $day = date('d');
        $month = date('F');
        $year = date('Y');
        $today=$day.'&nbsp;'.$month.'&nbsp;'.$year;

        $html = '

		<html>
		    <head>
		        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		        <meta http-equiv="Content-Style-Type" content="text/css" /> 
		        <meta name="generator" content="Aspose.Words for .NET 17.1.0.0" />
		        <title></title>
		    </head>
		    <body>
		    <h3 style="text-align:center;">PENILAIAN CAPAIAN SASARAN KERJA PEGAWAI NEGERI SIPIL</h3>
		    <p>Jangka Waktu Penilaian '.$data["skp_h"][0]->startdate.' s.d. '.$data["skp_h"][0]->enddate.'</p>
		    <table  border="1" cellpadding="1" width="100%" style="font-size:8px">
                    <thead>
                    <tr >
                        <th rowspan="2" valign="center" width="2%"><br/><br/>NO</th>
                        <th rowspan="2" width="30%"><br/><br/>I. Kegiatan Tugas Pokok Jabatan</th>
                        <th rowspan="2" align="center" width="3%"><br/><br/>AK</th>
                        <th colspan="6" align="center" width="24%">TARGET</th>
                        <th rowspan="2" align="center" width="3%"><br/><br/>AK</th>
                        <th colspan="6" align="center" width="24%">REALISASI</th>
                        <th rowspan="2" align="center" width="9%"><br/><br/>PENGHITUNGAN</th>
                        <th rowspan="2" align="center">NILAI CAPAIAN SKP</th>
                    </tr>
                    <tr>
                        <th colspan="2" align="center" width="8%">Kuant/ Output</th>
                        <th align="center" width="4%">Kual/ Mutu</th>
                        <th colspan="2" align="center" width="8%">Waktu</th>
                        <th align="center" width="4%">Biaya</th>
                        <th colspan="2" align="center" width="8%">Kuant/ Output</th>
                        <th align="center" width="4%">Kual/ Mutu</th>
                        <th colspan="2" align="center" width="8%">Waktu</th>
                        <th align="center" width="4%">Biaya</th>
                    </tr>
                    <tr>
                        <th align="center" width="2%">1</th>
                        <th align="center" width="30%">2</th>
                        <th align="center" width="3%">3</th>
                        <th colspan="2" align="center" width="8%">4</th>
                        <th align="center" width="4%">5</th>
                        <th colspan="2" align="center" width="8%">6</th>
                        <th align="center" width="4%">7</th>
                        <th align="center" width="3%">8</th>
                        <th colspan="2" align="center" width="8%">9</th>
                        <th align="center" width="4%">10</th>
                        <th colspan="2" align="center" width="8%">11</th>
                        <th align="center" width="4%">12</th>
                        <th align="center" width="9%">13</th>
                        <th align="center">14</th>
                    </tr>
                    <tr>
                        <th align="center" width="2%"></th>
                        <th width="30%"><b>I. UNSUR UTAMA</b></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="9%"></th>
                        <th align="center"></th>
                    </tr>
                    </thead>
                    
                    <tbody>'; 
                    $no_utama=1;
                    $count_utama=0;
                    $count_tambahan=0;
                    $count_kreatifitas=0;
                    $total_utama = 0;
                    $total_tambahan = 0;
                    $total_kreatifitas = 0;
                    $average_utama = 0;
                    $average_tambahan = 0;
                    $average_kreatifitas = 0;
                    foreach ($data['skp'] as $key => $value) {
                	if ($value->type_kegiatan==1){
                    $html.='
                    <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%">'.$no_utama.'</td>
                        <td width="30%">'.$value->kegiatan.'</td>
                        <td align="right" width="3%">'.$value->ak.'</td>
                        <td align="right" width="4%">'.$value->quantityshow.'</td>
                        <td width="4%" style="font-size:6px">'.$value->outputshow.'</td>
                        <td align="right" width="4%">'.$value->qualityshow.'</td>
                        <td align="right" width="4%">'.$value->waktushow.'</td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">'.$value->biaya.'</td>
                        <td align="right" width="3%">
                            '.$value->ak_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->qty_realisasi.'
                        </td>';

                       
                        $html.='<td width="4%" style="font-size:6px">';
                        foreach ($data['doc_type'] as $key => $values) {
                        	if($values->id==$value->output_realisasi){
                    			$html.="$values->name'";     
                            }
                        }
                        $html.='</td>';
                        
                    $html.=' <td align="right" width="4%">
                            '.$value->quality_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->waktu_realisasi.'
                        </td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">
                            '.$value->biaya_realisasi.'
                        </td>';
                        // Get Kuantitas
                        $qty_target = $value->quantityshow;
                        $qty_realisasi = $value->qty_realisasi;

                        if($qty_realisasi>=1){
                            $kuantitas= @($qty_realisasi/$qty_target)*100;
                        }
                        else {
                            $kuantitas = "";
                            $kuantitas = 0;
                        }
                        // Get Kualitas
                        $k_target = $value->qualityshow;
                        $k_realisasi = $value->quality_realisasi;

                        if($k_target>1){
                            $kualitas= @($k_realisasi/$k_target)*100;
                        }
                        else {
                            $kualitas = "";
                            $kualitas = 0;
                        }

                        // Get Waktu
                        $w_target = $value->waktushow;
                        $w_realisasi = $value->waktu_realisasi;
                        // ef %
                        if ($w_realisasi<=1){
                            $ef = "";
                        }
                        else {
                            $ef = 100-@($w_realisasi/$w_target)*100;
                        }
                        // <= 24 %
                        if ($w_realisasi<1){
                            $duaempat_min = "";
                        }
                        else {
                            $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                        }
                         // > 24 %
                        if ($w_realisasi<1){
                            $duaempat_plus = "";
                        }
                        else {
                            $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                        }
                        // waktu
                        if ($w_realisasi<1){
                            $waktu ="";
                        }
                        else {
                            if($ef>24){
                                $waktu = $duaempat_plus;
                            }
                            else {
                                $waktu = $duaempat_min;
                            }
                        }
                        // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                        // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                        // kolom penghitungan
                        $b_realisasi = $value->biaya_realisasi;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $penghitungan = $kuantitas + $kualitas;
                            }
                            else {
                                $penghitungan = $kuantitas + $kualitas + $waktu;
                            }
                        }
                        // kolom nilai capaian skp
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $capaian_skp = $penghitungan / 4;
                            }
                            else {
                                $capaian_skp = $penghitungan / 3;
                            }
                        }

                        $capaian_skp = number_format($capaian_skp,2);

                        $avg_skp = count($capaian_skp);
                        //echo 'rata-rata'.$avg_skp;

                        $count_utama++;
                        $total_utama = $total_utama + $penghitungan;                        
                     
                        
                    $html.='<td align="right" width="9%">'.$penghitungan.'</td>
                        <td align="right">'.$capaian_skp.'</td>
                    </tr>';

                    $no_utama++; 
                		}
                	}

                    $html.='
                     <tr>
                        <th align="center" width="2%"></th>
                        <th width="30%"><b>II. UNSUR PENUNJANG:<br/>TUGAS TAMBAHAN DAN KREATIVITAS :</b></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="9%"></th>
                        <th align="center"></th>
                    </tr>';

                    $html.='
                     <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%"></td>
                        <td width="30%">Tugas Tambahan:</td>
                        <td align="right" width="3%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="3%">
                            
                        </td>
                        <td align="right" width="4%">
                           
                        </td>
                        <td width="4%"></td>
                        <td align="right" width="4%">
                       
                        </td>
                        <td align="right" width="4%">
                         
                        </td>
                        <td width="4%"></td>
                        <td width="4%">
                          
                        </td>
                        <td align="right" width="9%"></td>
                        <td align="right"></td>
                    </tr>';
                    $no_tambahan=1;
                    foreach ($data['skp'] as $key => $value) {
                    	if ($data["skp_h"][0]->status_approvement==STATUS_REALISASI_DITERIMA){
                				if ($value->type_kegiatan==2){
                    $html.='
                    <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%">'.$no_tambahan.'</td>
                        <td width="30%">'.$value->kegiatan.'</td>
                        <td align="right" width="3%">'.$value->ak.'</td>
                        <td align="right" width="4%">'.$value->quantityshow.'</td>
                        <td width="4%" style="font-size:6px">'.$value->outputshow.'</td>
                        <td align="right" width="4%">'.$value->qualityshow.'</td>
                        <td align="right" width="4%">'.$value->waktushow.'</td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">'.$value->biaya.'</td>
                        <td align="right" width="3%">
                            '.$value->ak_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->qty_realisasi.'
                        </td>';
                        $html.='<td style="font-size:6px">';
                        foreach ($data['doc_type'] as $key => $values) {
                        	if($values->id==$value->output_realisasi){
                    			$html.="$values->name'";     
                            }
                        }
                        $html.='</td>';
                        $html.='<td align="right" width="4%">
                            '.$value->quality_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->waktu_realisasi.'
                        </td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">
                            '.$value->biaya_realisasi.'
                        </td>';
                        // Get Kuantitas
                        $qty_target = $value->quantityshow;
                        $qty_realisasi = $value->qty_realisasi;

                        if($qty_realisasi>=1){
                            $kuantitas= @($qty_realisasi/$qty_target)*100;
                        }
                        else {
                            $kuantitas = "";
                            $kuantitas = 0;
                        }
                        // Get Kualitas
                        $k_target = $value->qualityshow;
                        $k_realisasi = $value->quality_realisasi;

                        if($k_target>1){
                            $kualitas= @($k_realisasi/$k_target)*100;
                        }
                        else {
                            $kualitas = "";
                            $kualitas = 0;
                        }

                        // Get Waktu
                        $w_target = $value->waktushow;
                        $w_realisasi = $value->waktu_realisasi;
                        // ef %
                        if ($w_realisasi<=1){
                            $ef = "";
                        }
                        else {
                            $ef = 100-@($w_realisasi/$w_target)*100;
                        }
                        // <= 24 %
                        if ($w_realisasi<1){
                            $duaempat_min = "";
                        }
                        else {
                            $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                        }
                         // > 24 %
                        if ($w_realisasi<1){
                            $duaempat_plus = "";
                        }
                        else {
                            $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                        }
                        // waktu
                        if ($w_realisasi<1){
                            $waktu ="";
                        }
                        else {
                            if($ef>24){
                                $waktu = $duaempat_plus;
                            }
                            else {
                                $waktu = $duaempat_min;
                            }
                        }
                        // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                        // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                        // kolom penghitungan
                        $b_realisasi = $value->biaya_realisasi;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $penghitungan = $kuantitas + $kualitas;
                            }
                            else {
                                $penghitungan = $kuantitas + $kualitas + $waktu;
                            }
                        }
                        // kolom nilai capaian skp
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $capaian_skp = $penghitungan / 4;
                            }
                            else {
                                $capaian_skp = $penghitungan / 3;
                            }
                        }

                        $capaian_skp = number_format($capaian_skp,2);
                        $count_tambahan++;
                        $total_tambahan = $total_tambahan + $perhitungan;

                        $html.='<td align="right" width="9%">'.$penghitungan.'</td>
                        <td align="right">'.$capaian_skp.'</td>
                    </tr>';

                    $no_tambahan++; 
                				}
                			}
                		}

                    $html.='<tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%"></td>
                        <td width="30%">Kreatifitas:</td>
                        <td align="right" width="3%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="3%">
                            
                        </td>
                        <td align="right" width="4%">
                           
                        </td>
                        <td width="4%"></td>
                        <td align="right" width="4%">
                       
                        </td>
                        <td align="right" width="4%">
                         
                        </td>
                        <td width="4%"></td>
                        <td width="4%">
                          
                        </td>
                        <td align="right" width="9%"></td>
                        <td align="right"></td>
                    </tr>';
                    $no_kreatifitas=1;
                    foreach ($data['skp'] as $key => $value) {
                    	if ($data["skp_h"][0]->status_approvement==STATUS_REALISASI_DITERIMA){
                				if ($value->type_kegiatan==3){
                    $html.='
                    <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%">'.$no_kreatifitas.'</td>
                        <td width="30%">'.$value->kegiatan.'</td>
                        <td align="right" width="3%">'.$value->ak.'</td>
                        <td align="right" width="4%">'.$value->quantityshow.'</td>
                        <td width="4%" style="font-size:6px">'.$value->outputshow.'</td>
                        <td align="right" width="4%">'.$value->qualityshow.'</td>
                        <td align="right" width="4%">'.$value->waktushow.'</td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">'.$value->biaya.'</td>
                        <td align="right" width="3%">
                            '.$value->ak_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->qty_realisasi.'
                        </td>';
                        $html.='<td style="font-size:6px">';
                        foreach ($data['doc_type'] as $key => $values) {
                        	if($values->id==$value->output_realisasi){
                    			$html.="$values->name'";     
                            }
                        }
                        $html.='</td>';
                        
                    $html.='<td align="right" width="4%">
                            '.$value->quality_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->waktu_realisasi.'
                        </td>
                        <td width="4%" style="font-size:6px">Bulan</td>
                        <td width="4%">
                            '.$value->biaya_realisasi.'
                        </td>';
                     // Get Kuantitas
                        $qty_target = $value->quantityshow;
                        $qty_realisasi = $value->qty_realisasi;

                        if($qty_realisasi>=1){
                            $kuantitas= @($qty_realisasi/$qty_target)*100;
                        }
                        else {
                            $kuantitas = "";
                            $kuantitas = 0;
                        }
                        // Get Kualitas
                        $k_target = $value->qualityshow;
                        $k_realisasi = $value->quality_realisasi;

                        if($k_target>1){
                            $kualitas= @($k_realisasi/$k_target)*100;
                        }
                        else {
                            $kualitas = "";
                            $kualitas = 0;
                        }

                        // Get Waktu
                        $w_target = $value->waktushow;
                        $w_realisasi = $value->waktu_realisasi;
                        // ef %
                        if ($w_realisasi<=1){
                            $ef = "";
                        }
                        else {
                            $ef = 100-@($w_realisasi/$w_target)*100;
                        }
                        // <= 24 %
                        if ($w_realisasi<1){
                            $duaempat_min = "";
                        }
                        else {
                            $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                        }
                         // > 24 %
                        if ($w_realisasi<1){
                            $duaempat_plus = "";
                        }
                        else {
                            $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                        }
                        // waktu
                        if ($w_realisasi<1){
                            $waktu ="";
                        }
                        else {
                            if($ef>24){
                                $waktu = $duaempat_plus;
                            }
                            else {
                                $waktu = $duaempat_min;
                            }
                        }
                        // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                        // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                        // kolom penghitungan
                        $b_realisasi = $value->biaya_realisasi;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $penghitungan = $kuantitas + $kualitas;
                            }
                            else {
                                $penghitungan = $kuantitas + $kualitas + $waktu;
                            }
                        }
                        // kolom nilai capaian skp
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $capaian_skp = $penghitungan / 4;
                            }
                            else {
                                $capaian_skp = $penghitungan / 3;
                            }
                        }

                        $capaian_skp = number_format($capaian_skp,2);
                        $count_kreatifitas++;
                        $total_kreatifitas = $total_kreatifitas+ $perhitungan;

                    $html.='<td align="right" width="9%">'.$penghitungan.'</td>
                        <td align="right">'.$capaian_skp.'</td>
                    </tr>';

                    $no_kreatifitas++; 
                				}
                			}
                		}
                    $average_utama = $total_utama/$count_utama;
                    $average_tambahan = $total_tambahan/$count_tambahan;
                    $average_kreatifitas = $total_kreatifitas/$count_kreatifitas;
                    $average = number_format((($average_utama+$average_tambahan+$average_kreatifitas)/3),2);
                    
                    $nilai_hasil = "sangat baik";
                    if ($average<=50.999){
						$nilai_hasil = "buruk";                    	
                    }else if ($average<=60.999){
						$nilai_hasil = "sedang";                    	
                    }else if ($average<=75.999){
						$nilai_hasil = "cukup";                    	
                    }else if ($average<=90.999){
						$nilai_hasil = "baik";                    	
                    }
                    $html.='<tr height="20">
                        <td colspan="17" rowspan="2" align="right"><div align="center"><br/><b>Nilai Capaian SKP</b></div></td>
                        <td height="20" align="right"><b>'.$average.'</b></td>
                     </tr>
                     <tr height="20">
                        <td height="20" align="right"><b>('.$nilai_hasil.')</b></td>
                     </tr>
                    </tbody>
                 
                    </table>
		    	
		    	<p style="text-align:right">
		    		Jakarta, '.$today.'<br/>
		    		Pejabat Penilai<br/><br/><br/><br/><br/>
		    		'.$infoUserAtasan->NAMA_ABS.','.$infoUserAtasan->TITEL.'<br/>
		    		'.$infoUserAtasan->NIP18.'
		    		
		    	</p>
		         
		        
			                
			</body>
		</html>';		
        $pdf_cuti->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf_cuti->Output('skp.pdf', 'I');
	}

    public function cetak_pengukuran11(){

    	$skp_id = $this->input->get("skp_id");
		$nrk_bawahan = $this->input->get("nrk_bawahan");
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



        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

                 
        $data["skp_id"] = $skp_id;
        $data["nrk_bawahan"] = $nrk_bawahan;

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $infoUser = $this->home->getUserInfo2($nrk);
        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];

        $infoUserAtasan = $this->home->getUserInfo2($nrk_atasan);
        $data['infoUserAtasan'] = $infoUserAtasan;

        //var_dump($infoUserAtasan);die;
        //var_dump($nrk_atasan);die;
        //var_dump($infoUser);die;
        $data['infoUser'] = $infoUser;
		$arr_fields = ["nrk"];
		$arr_values = [$nrk];
		$skp_id=$this->input->get('skp_id');
		//var_dump($skp_id);die;

        $skp = $this->skp->get_data($arr_fields, $arr_values, "SKP");
        $data["skp_h"]=$skp;  	
        $arr_fields = ["deleted_at"];
		$arr_values = [null];		
		$data["doc_type"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_MASTER_DOC_TYPE"); 

		if (count($skp)>0){
			$data["skp"] = $this->skp->get_skp_new_target($skp[0]->id);
			// $arr_fields = ["skp_id"]; // skp_id pada tabel skp details 
			// $arr_values = [$skp[0]->id];
			// $data["skp"] = $this->skp->get_data($arr_fields, $arr_values, "SKP_DETAILS");
			// echo $this->db->last_query();die;
			// var_dump($data["skp"]);die;
		}
		//var_dump($skp);die;

        foreach ($skp as $key => $value) {
                        //echo 'idnya'.$value->id.'<br/>';
                    }
        //die;
        
	  $this->load->library("pdf_skp");
        $pdf_cuti = new pdf_skp('P', 'mm', 'F5', true, 'UTF-8', false);

        // ob_start();

        $pdf_cuti->SetCreator(PDF_CREATOR);
        // Add a page
        // ob_start();
        $pdf_cuti->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-25, PDF_MARGIN_RIGHT);
        // $pdf_cuti->Output('name.pdf', 'D');
        $pdf_cuti->AddPage('L');
        //$pdf_cuti->writeHTML('IWK');
      
        //$pdf_cuti->AddPage('L');
        $pdf_cuti->SetFont('helvetica', '', 6);

        // add a page
        // $this->pdf_cuti->AddPage();

        $pdf_cuti->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);


        $html = '

		<html>
		    <head>
		        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		        <meta http-equiv="Content-Style-Type" content="text/css" /> 
		        <meta name="generator" content="Aspose.Words for .NET 17.1.0.0" />
		        <title></title>
		    </head>
		    <body>
		    <h3 style="text-align:center;">PENILAIAN CAPAIAN SASARAN KERJA PEGAWAI NEGERI SIPIL</h3>
		    <p>Jangka Waktu Penilaian 2 Januari s.d. 31 Desember 2018</p>
		    <table  border="1" cellpadding="1" width="100%" style="font-size:8px">
                    <thead>
                    <tr >
                        <th rowspan="2" valign="center" width="2%"><br/><br/>NO</th>
                        <th rowspan="2" width="30%"><br/><br/>I. Kegiatan Tugas Pokok Jabatan</th>
                        <th rowspan="2" align="center" width="3%"><br/><br/>AK</th>
                        <th colspan="6" align="center" width="24%">TARGET</th>
                        <th rowspan="2" align="center" width="3%"><br/><br/>AK</th>
                        <th colspan="6" align="center" width="24%">REALISASI</th>
                        <th rowspan="2" align="center" width="9%"><br/><br/>PENGHITUNGAN</th>
                        <th rowspan="2" align="center">NILAI CAPAIAN SKP</th>
                    </tr>
                    <tr>
                        <th colspan="2" align="center" width="8%">Kuant/ Output</th>
                        <th align="center" width="4%">Kual/ Mutu</th>
                        <th colspan="2" align="center" width="8%">Waktu</th>
                        <th align="center" width="4%">Biaya</th>
                        <th colspan="2" align="center" width="8%">Kuant/ Output</th>
                        <th align="center" width="4%">Kual/ Mutu</th>
                        <th colspan="2" align="center" width="8%">Waktu</th>
                        <th align="center" width="4%">Biaya</th>
                    </tr>
                    <tr>
                        <th align="center" width="2%">1</th>
                        <th align="center" width="30%">2</th>
                        <th align="center" width="3%">3</th>
                        <th colspan="2" align="center" width="8%">4</th>
                        <th align="center" width="4%">5</th>
                        <th colspan="2" align="center" width="8%">6</th>
                        <th align="center" width="4%">7</th>
                        <th align="center" width="3%">8</th>
                        <th colspan="2" align="center" width="8%">9</th>
                        <th align="center" width="4%">10</th>
                        <th colspan="2" align="center" width="8%">11</th>
                        <th align="center" width="4%">12</th>
                        <th align="center" width="9%">13</th>
                        <th align="center">14</th>
                    </tr>
                    <tr>
                        <th align="center" width="2%"></th>
                        <th width="30%"><b>I. UNSUR UTAMA</b></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="9%"></th>
                        <th align="center"></th>
                    </tr>
                    </thead>
                    
                    <tbody>'; 
                    $no=1;
                    foreach ($data['skp'] as $key => $value) {
                    $html.='
                    <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%">'.$no.'</td>
                        <td width="30%">'.$value->kegiatan.'</td>
                        <td align="right" width="3%">'.$value->ak.'</td>
                        <td align="right" width="4%">'.$value->quantityshow.'</td>
                        <td width="4%">'.$value->outputshow.'</td>
                        <td align="right" width="4%">'.$value->qualityshow.'</td>
                        <td align="right" width="4%">'.$value->waktushow.'</td>
                        <td width="4%">Bulan</td>
                        <td width="4%">'.$value->biaya.'</td>
                        <td align="right" width="3%">
                            '.$value->ak_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->qty_realisasi.'
                        </td>
                        <td width="4%">'.$value->output_realisasi.'</td>
                        <td align="right" width="4%">
                            '.$value->quality_realisasi.'
                        </td>
                        <td align="right" width="4%">
                            '.$value->waktu_realisasi.'
                        </td>
                        <td width="4%">Bulan</td>
                        <td width="4%">
                            '.$value->biaya_realisasi.'
                        </td>
                        <td align="right" width="9%">264</td>
                        <td align="right">88</td>
                    </tr>';

                    $no++; 
                	}

                    $html.='

                     <tr>
                        <th align="center" width="2%"></th>
                        <th width="30%"><b>II. UNSUR PENUNJANG:<br/>TUGAS TAMBAHAN DAN KREATIVITAS :</b></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="3%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th colspan="2" align="center" width="8%"></th>
                        <th align="center" width="4%"></th>
                        <th align="center" width="9%"></th>
                        <th align="center"></th>
                    </tr>
                     <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%"></td>
                        <td width="30%">Tugas Tambahan:</td>
                        <td align="right" width="3%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="3%">
                            
                        </td>
                        <td align="right" width="4%">
                           
                        </td>
                        <td width="4%"></td>
                        <td align="right" width="4%">
                       
                        </td>
                        <td align="right" width="4%">
                         
                        </td>
                        <td width="4%"></td>
                        <td width="4%">
                          
                        </td>
                        <td align="right" width="9%"></td>
                        <td align="right"></td>
                    </tr>
                     <tr class="gradeX" height="20">
                        <td height="10" align="center" width="2%"></td>
                        <td width="30%">Kreatifitas:</td>
                        <td align="right" width="3%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td align="right" width="4%"></td>
                        <td width="4%"></td>
                        <td width="4%"></td>
                        <td align="right" width="3%">
                            
                        </td>
                        <td align="right" width="4%">
                           
                        </td>
                        <td width="4%"></td>
                        <td align="right" width="4%">
                       
                        </td>
                        <td align="right" width="4%">
                         
                        </td>
                        <td width="4%"></td>
                        <td width="4%">
                          
                        </td>
                        <td align="right" width="9%"></td>
                        <td align="right"></td>
                    </tr>
                    
                     <tr height="20">
                        <td colspan="17" rowspan="2" align="right"><div align="center"><br/><b>Nilai Capaian SKP</b></div></td>
                        <td height="20" align="right"><b>84.24</b></td>
                     </tr>
                     <tr height="20">
                        <td height="20" align="right"><b>(Baik)</b></td>
                     </tr>
                    </tbody>
                 
                    </table>
		    	
		    	<p style="text-align:right">
		    		Jakarta, 31 Desember 2018<br/>
		    		Pejabat Penilai<br/><br/><br/><br/><br/>
		    		'.$infoUserAtasan->NAMA_ABS.','.$infoUserAtasan->TITEL.'<br/>
		    		'.$infoUserAtasan->NIP18.'
		    		
		    	</p>
		         
		        
			                
			</body>
		</html>';		
        $pdf_cuti->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf_cuti->Output('skp.pdf', 'I');
    }

	
    public function submit_pengukuran_realisasi(){
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
       
        $infoUser = $this->home->getUserInfo2($nrk);
        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];
        
        $skp_id = $this->input->post('skp_id');
    	$inputs = $this->input->post('data');
    	$inputs = array_merge($this->input->post('new_kreatifitas'),$inputs);
    	// echo "<pre>";
    	// print_r($inputs);    	
    	// die();
    	

    	foreach ($inputs as $key => $value) {
    		// echo "<pre>";
    		// print_r($value);
    		// die();
    		$input = $value["data"];
			$id = $value["id"];	
    		$this->skp->update_realisasi($id,$input);
    		
    	}

    	//echo $this->db->last_query();die;
    	// baca isi rowsnya;
    	//update isi rowyanya/
    	// insert
    	//$skp_id,$nrk,$nrk_atasan
    	// $arr_values = array("id" => $skp_id,
    	// 			"approved_by" => $nrk,
    	// 			"approved_waiting" => $nrk_atasan);
    	//$this->skp->sql_insert2("SKP", $arr_values);
    	$this->skp->update_realisasi_approve($skp_id,$nrk,$nrk_atasan);
    	$a = array("response" => "SUKSES");
    	echo json_encode($a);
    	

    }
    public function submit_pengukuran_realisasi_usulan(){
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
       
        $infoUser = $this->home->getUserInfo2($nrk);
        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];
        
        $skp_id = $this->input->post('skp_id');
    	$inputs = $this->input->post('data');

    	//echo "<pre>";
    	//var_dump($inputs);die;
    	if (count($inputs)> 0){
	    	foreach ($inputs as $key => $value) {
	    		$input = $value["values"];
				$id = $value["id"];	
	    		$this->skp->update_realisasi($id,$input);
	    	}
    	}
    	// baca isi rowsnya;
    	//update isi rowyanya/
    	// insert
    	//$skp_id,$nrk,$nrk_atasan
    	// $arr_values = array("id" => $skp_id,
    	// 			"approved_by" => $nrk,
    	// 			"approved_waiting" => $nrk_atasan);
    	//$this->skp->sql_insert2("SKP", $arr_values);
    	$this->skp->update_realisasi_approve_usulan($skp_id,$nrk,$nrk_atasan);

    	$a = array("response" => "SUKSES");
    	echo json_encode($a);

    }

     public function tolak_pengukuran_realisasi(){
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
       
        $infoUser = $this->home->getUserInfo2($nrk);
        $data['nrk_atasan'] = $this->skp->atasan_cuti($nrk);        
        $nrk_atasan = $data['nrk_atasan'];
        
        $skp_id = $this->input->post('skp_id');
    	$inputs = $this->input->post('data');
    	$nrk_bawahan= $this->input->post('nrk_bawahan');
    	//echo $nrk_bawahan;die;

    	//echo "<pre>";
    	//var_dump($inputs);die;
   //  	foreach ($inputs as $key => $value) {
   //  		$input = $value["values"];
			// $id = $value["id"];	
   //  		$this->skp->update_realisasi($id,$input);
   //  	}
    	// baca isi rowsnya;
    	//update isi rowyanya/
    	// insert
    	//$skp_id,$nrk,$nrk_atasan
    	// $arr_values = array("id" => $skp_id,
    	// 			"approved_by" => $nrk,
    	// 			"approved_waiting" => $nrk_atasan);
    	//$this->skp->sql_insert2("SKP", $arr_values);
    	$this->skp->update_realisasi_tolak($skp_id,$nrk_bawahan,$nrk);

    }

    public function log(){
    	$this->skp->create_table_log("SKP");
    	$this->skp->create_table_log("SKP_DETAILS");
    	$this->skp->create_table_log("SKP_TARGET");
    	//$this->skp->insert_log('SKP','e33af099bd011dfb53c6ab94bea065cb');
    }

    public function id(){    	
        return $this->skp->id();        
    }

    public function dataid(){    	
    	echo "<table>";
    	for($i=0;$i<744;$i++){
        	echo "<tr><td>".$this->skp->id()."</td></tr>";        
    	}
    	echo "</table>";
    }

}