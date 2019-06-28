<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spesimen extends CI_Controller {
	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper(array('form', 'url'));    	
    	$this->load->library('session');
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','vpeg');
        $this->load->model('master/spesimen_ka_bkd','ttd');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->library('format_uang');
        $this->load->library('upload');
        

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

	

    public function ka_bkd()
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

        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'ttd_ka_bkd',0);
        $datam['inisial'] = 'ttd_ka_bkd';

        $menuid='31102';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        // echo $cekaksesmenu;exit();

        if($cekaksesmenu == '1')
        {
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('master/specimen_ka_bkd',$data);
                $this->load->view('head/footer');   
        }
        else
        {
            $this->load->view('403');
        }

    }

    public function data_ttd_ka_bkd()
    {
        
        $nrk = $this->user['id'];

        $this->ttd->get_data_ttd_ka_bkd();
    }

    public function cari_pegawai()
    {        
        $nrk = $this->input->post('nrk');
        $cek = $this->ttd->cek_pgw($nrk);

        // echo $cek;
        // $insert = $this->home->save_cuti($data);
        
        if($cek > 0){
            // echo 'ada';
        	$pgw = $this->ttd->get_pgw($nrk);
            echo json_encode(array("response" => 'SUKSES', 'nama_pgw' => $pgw->NAMA));
        }else{
            // echo 'tidak ada';
            echo json_encode(array("response" => 'GAGAL'));
        }
    }

    public function ajax_tambah_data()
    {        
        $id_user = $this->user['id'];
        $nrk = $this->input->post('nrk_input');
        $nama_input = $this->input->post('nama_input');
        $status_input = $this->input->post('status_input');
        $gambar = $this->input->post('gambar');
        $cek = $this->ttd->cek_ttd_bkd($nrk);
        $location = '/assets/img/ttd/';

        if($status_input=='on'){
            $status = 'Aktif';
        }else{
            $status = 'Tidak Aktif';
        }



        // echo realpath('./assets/img/ttd/');
        
        if($cek <= 0){
            // $this->libur->save_libur($id,$tgl,$ket);
            date_default_timezone_set('Asia/Jakarta');
            $date = date('d-m-Y');
            // $time = date('H-i-s');

            
            $config = array(
                'allowed_types' => 'jpg|jpeg',
                'upload_path' => realpath('./assets/img/ttd/'),
                'max_size' => 5000000000000,
                'overwrite' =>true,
                'file_name' => $nrk
            );

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $file1 = $this->upload->data();
                $file2 = $file1['file_name'];
                $gambar = $file2;
            }
            // echo $nrk;
            // echo $gambar;exit();

            if ($gambar == '' || $nrk == '') {
                echo json_encode(array("response" => 'GAGAL', 'judul' => "GAGAL",'pesan' => "NRK dan File tidak boleh kosong"));
            } else {
                $this->ttd->insert_ttd($id_user, $nrk, $status,$gambar,$location,$date);
                echo json_encode(array("response" => 'SUKSES','judul' => "Berhasil",'pesan' => "Data berhasil disimpan"));
            }

        }else{
            echo json_encode(array("response" => 'GAGAL', 'judul' => "GAGAL",'pesan' => "Data sudah ada"));
        }
    }


    public function delete_ttd(){
        $id = $this->input->post('id');
        $cek = $this->ttd->cek_status($id);

        if($cek->STATUS == 'Tidak Aktif'){

            $delete = $this->ttd->delete_data($id);

            if($delete){
                echo json_encode(array("response" => 'SUKSES',"pesan" => 'Hapus data berhasil'));
            }else{
                echo json_encode(array("response" => 'GAGAL',"pesan" => 'Proses Gagal'));
            }
        }else{
            echo json_encode(array("response" => 'GAGAL',"pesan" => 'Status masih Aktif'));
        }
    }


    public function get_data_update(){
        $id = $this->input->post('id');

        $get_data = $this->ttd->get_data($id);
        // echo $get_data->TGL_LIBUR;exit();

        if($get_data){
            $respone = 'SUKSES';
            $return =  array('respone' => $respone ,'nrk' => $get_data->NRK ,'nama' => $get_data->NAMA, 'status' => $get_data->STATUS);
        }else{
            $respone = 'GAGAL';
            $return =  array('respone' => $respone ,'nrk' => '' ,'nama' => '', 'status' => '');
        }
        
        echo json_encode($return);
    }



    public function ajax_update_data()
    {        
        $id_user = $this->user['id'];
        $nrk = $this->input->post('nrk_update');
        $nama_update = $this->input->post('nama_update');
        $status_update = $this->input->post('status_update');
        $gambar = $this->input->post('gambar_update');
        $location = '/assets/img/ttd/';

        if($status_update=='on'){
            $status = 'Aktif';
        }else{
            $status = 'Tidak Aktif';
        }

        // echo $status;exit();

        if($status == 'Aktif'){

            date_default_timezone_set('Asia/Jakarta');
            $date = date('d-m-Y');

            // echo $status_input.' - '.$cek;
            
            
                // $this->libur->save_libur($id,$tgl,$ket);
                
                // $time = date('H-i-s');

                
                $config = array(
                    'allowed_types' => 'jpg|jpeg',
                    'upload_path' => realpath('./assets/img/ttd/'),
                    'max_size' => 5000000000000,
                    'overwrite' =>true,
                    'file_name' => $nrk
                );

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar_update')) {
                    $file1 = $this->upload->data();
                    $file2 = $file1['file_name'];
                    $gambar = $file2;
                }
                
                // echo $gambar.' ff';exit();
            if($gambar != ''){
                $this->ttd->update_ttd_gambar($id_user, $nrk, $status,$gambar,$location,$date);
                echo json_encode(array("response" => 'SUKSES','judul' => "Berhasil",'pesan' => "Data berhasil disimpan"));

            }else{
                $this->ttd->update_ttd($id_user, $nrk, $status,$date);
                echo json_encode(array("response" => 'SUKSES','judul' => "Berhasil",'pesan' => "Data berhasil disimpan"));
            }
        }else{
            echo json_encode(array("response" => 'GAGAL', 'judul' => "GAGAL",'pesan' => "Proses gagal"));
        }
    }    

            		
}
?>            
