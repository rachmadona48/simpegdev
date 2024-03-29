<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_kokel extends CI_Controller {

	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->library('session');
    	$this->load->model('ref/v_ref_kokel','rkl');

    	if ($this->session->userdata('logged_in')) {            

            $session_data       = $this->session->userdata('logged_in');
            $this->user['id']     	= $session_data['id'];
            $this->user['username']  	= $session_data['username'];
        }else{
			redirect(base_url().'index.php/login', 'refresh');
		}	    
   	}

	public function index()
	{	
			
			$data['listKowil']= $this->rkl->getListKowil();
			$data['listKocam']= "";


			$this->load->view('head/header', $this->user);
			$this->load->view('head/menu');
			$this->load->view('ref/ref_kokel_grid.php',$data);
			$this->load->view('head/footer');		
	}	



	public function data()
	{		
		$requestData = $this->input->post();	
		

		$columns = array(
		// datatable column index  => database column name
			
			0 => 'ROWNUM',
			1 => 'KOKEL',
			2 => 'NAKEL',
			3 => 'USER_ID',
			4 => 'TERM',
			5 => 'TG_UPD',		
			
		);
		
			$wh_kowil = " AND PERS_KOKEL_TBL.KOWIL='' ";
			$wh_kocam = " AND PERS_KOKEL_TBL.KOCAM='' ";
		//$wh_kolok = "";
		if( !empty($requestData['KOWIL']) ){
			$wh_kowil = " AND lower(PERS_kokel_TBL.KOWIL) LIKE lower('%".$requestData['KOWIL']."%') ";
		}
		if( !empty($requestData['KOCAM']) ){
			$wh_kocam = " AND lower(PERS_kokel_TBL.KOCAM) LIKE lower('%".$requestData['KOCAM']."%') ";
		}

		$sql = "SELECT rownum, x.* FROM (SELECT rownum as rn,
				kokel,nakel,user_id,term,tg_upd";
		$sql .= " FROM PERS_kokel_TBL 
				  WHERE (
				  			1=1
				  			$wh_kowil
				  			$wh_kocam
				  		)
				ORDER BY kokel
				) X";	
		//ECHO $sql;
		$query= $this->db->query($sql);
		
		$data = array();		

		foreach($query->result() as $row){
			$nestedData=array(); 

			$nestedData[] = $row->ROWNUM;;
			$nestedData[] = $row->KOKEL;
			$nestedData[] = $row->NAKEL;
			$nestedData[] = $row->USER_ID;
			$nestedData[] = $row->TERM;
			$nestedData[] = $row->TG_UPD;							
			
			$data[] = $nestedData;
			
		}	

		$json_data = array( 
					"data"            => $data   
					);

		echo json_encode($json_data);  
	}

	public function getKocam(){
		$kowil = $this->input->post('kowil');
		
		$listKocam = $this->rkl->getListKocam($kowil); 
		$arr = array('response' => 'SUKSES', 'listKocam' => $listKocam);
		echo json_encode($arr);
	}
}
