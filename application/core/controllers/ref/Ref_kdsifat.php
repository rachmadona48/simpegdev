<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_kdsifat extends CI_Controller {

	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->library('session');
    	

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
			$this->load->view('head/header', $this->user);
			$this->load->view('head/menu');
			$this->load->view('ref/ref_kdsifat_grid.php');
			$this->load->view('head/footer');		
	}	



	public function data()
	{		
		$requestData = $this->input->post();	

		$columns = array( 
		// datatable column index  => database column name
			0 => 'kdsifat',
			1 => 'keterangan',
			2 => 'tg_upd',			
		);

		// getting total number records without any search
		$sql = "SELECT rownum, x.* FROM (SELECT rownum as rn, kdsifat, keterangan, tg_upd";
		$sql .= " FROM pers_kdsifat_rpt
				WHERE (0=0)
				ORDER BY kdsifat) X";		
		
		$query= $this->db->query($sql);
		
		$data = array();		

		foreach($query->result() as $row){
			$nestedData=array(); 

			$nestedData[] = $row->ROWNUM;
			$nestedData[] = $row->KDSIFAT;
			$nestedData[] = $row->KETERANGAN;
			$nestedData[] = $row->TG_UPD;							
			
			$data[] = $nestedData;
			
		}	

		$json_data = array(
					"data" => $data   
					);

		echo json_encode($json_data);  
	}
}
