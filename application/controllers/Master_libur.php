<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_libur extends CI_Controller {
	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper(array('form', 'url'));    	
    	$this->load->library('session');
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','vpeg');
        $this->load->model('master/libur_nasional','libur');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->library('format_uang');
        

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
                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $pejtt = ""; 
        $jencuti = "";
        $data['listJenCuti'] = $this->infopegawai->getJenisCuti($jencuti);
        $data['listPejtt'] = $this->infopegawai->getMasterPejtt($pejtt);
        

        // $info_gaji = $this->riwayat->get_info_gaji($nrk);
        // // echo $info_pg->JML_PGW;exit();
        // $data['info_gaji'] = $info_gaji->JML;

        // $info_gr = $this->riwayat->get_info_tkd_gr($nrk);
        // $data['info_tkd_gr'] = $info_gr->JML_GR;  

        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'master_libur',0);
        $datam['inisial'] = 'master_libur';

        $menuid='29548';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        // echo $cekaksesmenu;exit();

        if($cekaksesmenu == '1')
        {
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('master/master_libur',$data);
                $this->load->view('head/footer');   
        }
        else
        {
            $this->load->view('403');
        }

    }

    public function data_libur_nas()
    {
        
        $nrk = $this->user['id'];

        $this->libur->get_data_libur();
    }

    public function ajax_add_data_libur()
    {        
        $id = $this->user['id'];
        $tgl = $this->input->post('tgl');
        $ket = $this->input->post('ket');
        $cek = $this->libur->cek_libur($tgl);

        // echo $cek;
        // $insert = $this->home->save_cuti($data);
        
        if($cek <= 0){
        	$this->libur->save_libur($id,$tgl,$ket);
            echo json_encode(array("response" => 'SUKSES', 'act' => "add"));
        }else{
            echo json_encode(array("response" => 'GAGAL', 'act' => "add"));
        }
    }

    public function get_data_update(){
        $id = $this->input->post('id');

        $get_data = $this->libur->get_data($id);
        // echo $get_data->TGL_LIBUR;exit();

        if($get_data){
            $respone = 'SUKSES';
            $return =  array('respone' => $respone ,'tgl' => $get_data->TGL_LIBUR ,'ket' => $get_data->KET);
        }else{
            $respone = 'GAGAL';
            $return =  array('respone' => $respone ,'tgl' => '' ,'ket' => '');
        }
        
        echo json_encode($return);
    }


    public function ajax_update_data_libur()
    {        
        $id_user = $this->user['id'];
        $id = $this->input->post('id_update');
        $tgl = $this->input->post('tgl_update');
        $ket = $this->input->post('ket_update');
        $cek = $this->libur->cek_libur($tgl);

        // echo $cek;exit();
        // $insert = $this->home->save_cuti($data);
        
        if($cek <= 0){
            $this->libur->update_libur($id_user,$id,$tgl,$ket);
            echo json_encode(array("response" => 'SUKSES'));
        }else{
            echo json_encode(array("response" => 'GAGAL'));
        }
    }

    public function delete_libur(){
        $id = $this->input->post('id');
        $delete = $this->libur->delete_libur($id);

        if($delete){
            echo json_encode(array("response" => 'SUKSES'));
        }else{
            echo json_encode(array("response" => 'GAGAL'));
        }
    }

            		
}
?>            
