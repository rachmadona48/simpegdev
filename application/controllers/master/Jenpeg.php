<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenpeg extends CI_Controller {

	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->library('session');
    	$this->load->model('master/v_jenpeg','jpg');

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
			$this->load->view('master/pers_jenis_pegawai_rpt_grid.php');
			$this->load->view('head/footer');		
	}	

	public function data()
	{		
		$requestData = $this->input->post();	

		$columns = array( 
		// datatable column index  => database column name
			0 => 'jenpeg',
			1 => 'keterangan',			
		);

		// getting total number records without any search
		$sql = "SELECT rownum, x.* FROM (SELECT rownum as rn, jenpeg, keterangan, tg_upd ";
		$sql .= " FROM pers_jenpeg_rpt) X";		
		$query = $this->db->query($sql);
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

		$sql = "SELECT rownum, x.* FROM (SELECT rownum as rn, jenpeg, keterangan, tg_upd ";
		$sql .= " FROM pers_jenpeg_rpt) X";

		$sql .= " WHERE 0 = 0";

		// getting records as per search parameters
		if( !empty($requestData['columns'][0]['search']['value']) ){   //kode universitas
			$sql.=" AND lower(jenpeg) LIKE lower('%".$requestData['columns'][0]['search']['value']."%') ";
		}
		if( !empty($requestData['columns'][1]['search']['value']) ){   //kode universitas
			$sql.=" AND lower(keterangan) LIKE lower('%".$requestData['columns'][1]['search']['value']."%') ";
		}		

		
		$query= $this->db->query($sql);
		$totalFiltered = $query->num_rows();	
		
		$sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length'].""; 
		$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length

		$query= $this->db->query($sql);
		
		$data = array();		

		foreach($query->result() as $row){
			$nestedData=array(); 

			$nestedData[] = $row->JENPEG;
			$nestedData[] = $row->KETERANGAN;			
			$nestedData[] = "<div class='form-group'>
								<div class='col-sm-12'>	
									<div class='row'>
										<div class='col-sm-4'>	
											
												<input type='hidden' name='jenpeg' id='jenpeg' value=".$row->JENPEG.">
												<button class='btn btn-success btn-xs' onClick=edit_jenpeg('".$row->JENPEG."')>edit</button>								
											
										</div>
										<div class='col-sm-4'>	
											<button class='btn btn-danger btn-xs' 
											onClick=delete_jenpeg('".$row->JENPEG."') >hapus</button>

										</div>										
									</div>
								</div>
							</div>
							";			
			
			$data[] = $nestedData;
		}	

		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   
					"recordsTotal"    => intval( $totalData ),  
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $data   
					);

		echo json_encode($json_data);  
	}

	public function ajax_add()
	{
		$data = array(
				'jenpeg' => $this->jpg->getnextval(),
				'keterangan' => $this->input->post('keterangan'),
				'tg_upd'=>date('Y-m-d h:i:s'),
			);
		$insert = $this->jpg->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'jenpeg' => $this->input->post('jenpeg'),
				'keterangan' => $this->input->post('keterangan'),
				'tg_upd'=>date('Y-m-d h:i:s'),
			);
		//$this->jpg->update(array('jenpeg' => $this->input->post('jenpeg')), $data);
		$this->jpg->update($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_edit($id)
	{
		$data = $this->jpg->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_delete($id)
	{
		$this->jpg->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}
