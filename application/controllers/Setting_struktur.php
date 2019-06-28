<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_struktur extends CI_Controller {
	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper(array('form', 'url'));    	
    	$this->load->library('session');
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','vpeg');
        $this->load->model('model_setting_struktur','setting_struktur');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->library('format_uang');


        $this->ci =& get_instance();
        $this->ci->load->database(); 
        $this->ci->load->library('session'); 
        

        //$this->ekin = $this->ci->load->database('ekin234', TRUE);
        $this->ekine = $this->ci->load->database('ekinerja', TRUE);
        $this->ekine16 = $this->ci->load->database('ekinerja16', TRUE);
        $this->etkd = $this->ci->load->database('etkd', TRUE);
        

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

        // echo $nrk;exit();

        // $group = $this->user['user_group'];

        // echo $group;exit();

        // $kolok_kojab = $this->cuti->kolok_kojab($nrk);
        // $data['cek_pyb'] = $this->cuti->cek_pyb($kolok_kojab->KOLOK,$kolok_kojab->KOJAB);

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        // $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
                 

        // $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $user_id = $this->user['id'];
        $spmu = $this->setting_struktur->get_spmu($user_id);
        $unit = $this->setting_struktur->get_unit($user_id);
        $data['unit'] = $this->setting_struktur->get_unit($user_id);

        // echo $unit->KOLOK.' ddf';exit();

        $data['pimpinan'] = $this->setting_struktur->get_pimpinan($unit->KOLOK);
        $pimpinan = $this->setting_struktur->get_pimpinan($unit->KOLOK);

        $data['kabid'] = $this->setting_struktur->get_kabid($pimpinan->NIP18,$pimpinan->SPMU);
        // echo $spmu->KODE_SPM.' ddd';exit();

        // $pejtt = ""; 
        // $jencuti = "";
        // $data['listJenCuti'] = $this->cuti->getJenisCuti($jencuti);
        // $data['lokasi_cuti'] = $this->cuti->lokasi_cuti();
        // $data['listPejtt'] = $this->infopegawai->getMasterPejtt($pejtt);
        

        // $info_gaji = $this->riwayat->get_info_gaji($nrk);
        // // echo $info_pg->JML_PGW;exit();
        // $data['info_gaji'] = $info_gaji->JML;

        // $info_gr = $this->riwayat->get_info_tkd_gr($nrk);
        // $data['info_tkd_gr'] = $info_gr->JML_GR;  

        // $data['activemn'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'setting_struktur',0);
        $datam['inisial'] = 'setting_struktur';

        $menuid='30202';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']); 

        // echo $cekaksesmenu;exit();

        if($cekaksesmenu == '1')
        {
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('setting_struktur',$data);
                $this->load->view('head/footer');   
        }
        else
        {
            $this->load->view('403');
        }

    }

    public function table_wakil()
    {
        $this->setting_struktur->table_wakil();
    }

    public function pilih_wakil(){

        $user_id = $this->user['id'];

        $nip_kadis = $this->input->post('nip_kadis');
        $kolok_kadis = $this->input->post('kolok_kadis');
        $kojab_kadis = $this->input->post('kojab_kadis');
        $nrk_kadis = $this->input->post('nrk_kadis');
        $spmu_kadis = $this->input->post('spmu_kadis');

        $nip18_wakil = $this->input->post('nip18_wakil');
        $kolok_wakil = $this->input->post('kolok_wakil');
        $kojab_wakil = $this->input->post('kojab_wakil');
        $nrk_wakil = $this->input->post('nrk_wakil');
        $spmu_wakil = $this->input->post('spmu_wakil');

        // $id_status_baru = 4;

        $pilih_wakil = $this->setting_struktur->pilih_wakil($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_wakil,$kolok_wakil,$kojab_wakil,$nrk_wakil,$spmu_wakil);

        if($pilih_wakil){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }



    public function tabel_kabag()
    {
        $this->setting_struktur->tabel_kabag();
    }

    public function tabel_kabag_ubah()
    {
        $this->setting_struktur->tabel_kabag_ubah();
    }


    public function pilih_kabid(){

        $user_id = $this->user['id'];

        $nip_kadis = $this->input->post('nip_kadis');
        $kolok_kadis = $this->input->post('kolok_kadis');
        $kojab_kadis = $this->input->post('kojab_kadis');
        $nrk_kadis = $this->input->post('nrk_kadis');
        $spmu_kadis = $this->input->post('spmu_kadis');

        $nip18_kepala = $this->input->post('nip18_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');

        // $id_status_baru = 4;
        $cek_data = $this->setting_struktur->cek_data_kasi_kabid($nrk_kepala);

        if($cek_data->JML <= 0){

            $pilih_kabid = $this->setting_struktur->pilih_kabid($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala);

            if($pilih_kabid){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
            }
        }else{
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }
    }

    public function pilih_kabid_ubah(){

        $user_id = $this->user['id'];

        $nip18_kepala = $this->input->post('nip18_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');
        $nip_kabag_old = $this->input->post('nip_kabag_old');

        // (nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kepala,nip_kabag_old)

        // $id_status_baru = 4;
        $cek_data = $this->setting_struktur->cek_data_kasi_kabid($nrk_kepala);

        if($cek_data->JML <= 0){

            $pilih_kabid = $this->setting_struktur->pilih_kabid_ubah($user_id,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip_kabag_old);

            if($pilih_kabid){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
            }
        }else{
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }
    }



    public function tabel_kasubag()
    {
        $this->setting_struktur->tabel_kasubag();
    }

    public function pilih_kasi(){

        $user_id = $this->user['id'];

        $nip_kadis = $this->input->post('nip_kadis');
        $kolok_kadis = $this->input->post('kolok_kadis');
        $kojab_kadis = $this->input->post('kojab_kadis');
        $nrk_kadis = $this->input->post('nrk_kadis');
        $spmu_kadis = $this->input->post('spmu_kadis');

        $nip18_kepala = $this->input->post('nip18_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');

        // $id_status_baru = 4;

        $cek_data = $this->setting_struktur->cek_data_kasi_kabid($nrk_kepala);

        if($cek_data->JML <= 0){

            $pilih_kasi = $this->setting_struktur->pilih_kasi($user_id,$nip_kadis,$kolok_kadis,$kojab_kadis,$nrk_kadis,$spmu_kadis,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala);

            if($pilih_kasi){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
            }
        }else{
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }
    }

    public function pilih_kasi_from_kabid_ubah(){

        $user_id = $this->user['id'];

        $nip18_kepala = $this->input->post('nip18_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');
        $nip_kabag_old = $this->input->post('nip_kabag_old');

        // $id_status_baru = 4;

        $cek_data = $this->setting_struktur->cek_data_kasi_kabid($nrk_kepala);

        if($cek_data->JML <= 0){

            $pilih_kasi = $this->setting_struktur->pilih_kasi_from_kabid_ubah($user_id,$nip18_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip_kabag_old);

            if($pilih_kasi){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
            }
        }else{
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }
    }


    public function tabel_pegawai()
    {
        $this->setting_struktur->tabel_pegawai();
    }

    public function pilih_pegawai(){

        $user_id = $this->user['id'];

        $nip_kepala = $this->input->post('nip_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');

        $nip18_staff = $this->input->post('nip18_staff');
        $kolok_staff = $this->input->post('kolok_staff');
        $kojab_staff = $this->input->post('kojab_staff');
        $nrk_staff = $this->input->post('nrk_staff');
        $spmu_staff = $this->input->post('spmu_staff');

        // $id_status_baru = 4;
        $cek_data = $this->setting_struktur->cek_data_pegawai($nrk_staff);

        if($cek_data->JML <= 0){

            $pilih_pegawai = $this->setting_struktur->pilih_pegawai($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff);

            if($pilih_pegawai){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
            }
        }else{
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }
    }

    public function hapus_kepala(){

        $user_id = $this->user['id'];

        $nip_kadis = $this->input->post('nip_kadis');
        $nip_kepala = $this->input->post('nip_kepala');

        // $id_status_baru = 4;

        $hapus_kepala = $this->setting_struktur->hapus_kepala($user_id,$nip_kadis,$nip_kepala);

        if($hapus_kepala){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function hapus_staff(){

        $user_id = $this->user['id'];

        $nip_kepala = $this->input->post('nip_kadis');
        $nip = $this->input->post('nip_kepala');

        // $id_status_baru = 4;

        $hapus_staff = $this->setting_struktur->hapus_staff($user_id,$nip);

        if($hapus_staff){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function hapus_kasi(){

        $user_id = $this->user['id'];

        $nip = $this->input->post('nip');

        // $id_status_baru = 4;

        $hapus_kasi = $this->setting_struktur->hapus_kasi($nip);

        if($hapus_kasi){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function hapus_staff_from_kabid(){

        $user_id = $this->user['id'];

        $nip = $this->input->post('nip');

        // $id_status_baru = 4;

        $hapus_staff_from_kabid = $this->setting_struktur->hapus_staff($user_id,$nip);

        if($hapus_staff_from_kabid){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function hapus_staff_from_kasi(){

        $user_id = $this->user['id'];

        $nip = $this->input->post('nip');

        // $id_status_baru = 4;

        $hapus_staff_from_kabid = $this->setting_struktur->hapus_staff($user_id,$nip);

        if($hapus_staff_from_kabid){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }


    public function tampil_kasi(){
        $user_id = $this->user['id'];

        $nip18 = $this->input->post('nip18');
        $target_kabid = $this->input->post('target_kabid');
        $spmu_kadis = $this->input->post('spmu_kadis');
        $kolok = $this->input->post('kolok');

        // $msg = $this->load->view('setting_struktur/tampil_kasi', $data, true);
        // $msg = $this->load->view('setting_struktur/tampil_kasi', true);

        $unit = $this->setting_struktur->get_unit($user_id);
        $data['unit'] = $this->setting_struktur->get_unit($user_id);
        $data['data_kabid'] = $this->setting_struktur->get_pegawai1($nip18);
        $data_kabid = $this->setting_struktur->get_pegawai1($nip18);

        $data['kasi'] = $this->setting_struktur->get_bawahan($data_kabid->NIP18,$data_kabid->SPMU);

        // var_dump($data_kabid);
        // $data['pimpinan'] = $this->setting_struktur->get_pimpinan($unit->KOLOK);
        $data['spmu_kadis'] = $spmu_kadis;

        $msg ="";
        $msg = $this->load->view('setting_struktur/tampil_kasi', $data, TRUE);


        if($msg){
            $return = array('response' => 'SUKSES', 'result' => $msg, 'pesan' => '');
        }else{
            $return = array('response' => 'GAGAL', 'result' => '','pesan' => 'Gagal');
        }
        
        echo json_encode($return);
    }


    public function tabel_kasubag_form_kabid()
    {
        $this->setting_struktur->tabel_kasubag_form_kabid();
    }

    public function tabel_kasubag_form_kabid_ubah()
    {
        $this->setting_struktur->tabel_kasubag_form_kabid_ubah();
    }

    public function tabel_pegawai_from_kabid()
    {
        $this->setting_struktur->tabel_pegawai_from_kabid();
    }


    public function tampil_staff(){
        $user_id = $this->user['id'];

        $nip18 = $this->input->post('nip18');
        $target_kasi = $this->input->post('target_kasi');
        $spmu_kasi = $this->input->post('spmu_kasi');
        // $kolok = $this->input->post('kolok');

        // $msg = $this->load->view('setting_struktur/tampil_kasi', $data, true);
        // $msg = $this->load->view('setting_struktur/tampil_kasi', true);

        $unit = $this->setting_struktur->get_unit($user_id);
        $data['unit'] = $this->setting_struktur->get_unit($user_id);
        $data['data_kasi'] = $this->setting_struktur->get_pegawai1($nip18);
        $data_kasi = $this->setting_struktur->get_pegawai1($nip18);

        $data['staff'] = $this->setting_struktur->get_bawahan($data_kasi->NIP18,$data_kasi->SPMU);

        // var_dump($data_kabid);

        $data['spmu_kasi'] = $spmu_kasi;

        $msg ="";
        $msg = $this->load->view('setting_struktur/tampil_staff', $data, TRUE);


        if($msg){
            $return = array('response' => 'SUKSES', 'result' => $msg, 'pesan' => '');
        }else{
            $return = array('response' => 'GAGAL', 'result' => '','pesan' => 'Gagal');
        }
        
        echo json_encode($return);
    }

    public function cari_pegawai(){
        $user_id = $this->user['id'];

        $nip_kasi = $this->input->post('nip_kasi');
        $spmu_kasi = $this->input->post('spmu_kasi');
        $str_cari_pegawai = $this->input->post('str_cari_pegawai');

        $data['data_kasi2'] = $this->setting_struktur->get_pegawai1($nip_kasi);
        // $data_kasi2 = $this->setting_struktur->get_pegawai1($nip_kasi);
        $data['pegawai'] = $this->setting_struktur->get_pegawai_from_kasi($nip_kasi,$spmu_kasi,$str_cari_pegawai);

        $msg ="";
        $msg = $this->load->view('setting_struktur/cari_pegawai', $data, TRUE);


        if($msg){
            $return = array('response' => 'SUKSES', 'result' => $msg, 'pesan' => '');
        }else{
            $return = array('response' => 'GAGAL', 'result' => '','pesan' => 'Gagal');
        }
        
        echo json_encode($return);
    }

    public function pilih_pegawai_from_kasi(){

        $user_id = $this->user['id'];

        $nip_kepala = $this->input->post('nip_kepala');
        $kolok_kepala = $this->input->post('kolok_kepala');
        $kojab_kepala = $this->input->post('kojab_kepala');
        $nrk_kepala = $this->input->post('nrk_kepala');
        $spmu_kepala = $this->input->post('spmu_kepala');

        $nip18_staff = $this->input->post('nip18_staff');
        $kolok_staff = $this->input->post('kolok_staff');
        $kojab_staff = $this->input->post('kojab_staff');
        $nrk_staff = $this->input->post('nrk_staff');
        $spmu_staff = $this->input->post('spmu_staff');


        $cek_data = $this->setting_struktur->cek_data_pegawai($nrk_staff);

        if($cek_data->JML <= 0){
            $pilih_pegawai = $this->setting_struktur->pilih_pegawai_from_kasi($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff);

            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }

        // $id_status_baru = 4;

        // $pilih_pegawai = 'cccc';
        // echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal','tes' => $pilih_pegawai));

        // $pilih_pegawai = $this->setting_struktur->pilih_pegawai_from_kasi($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff);

        // $pilih_pegawai = $this->setting_struktur->pilih_pegawai_from_kasi($user_id,$nip_kepala,$kolok_kepala,$kojab_kepala,$nrk_kepala,$spmu_kepala,$nip18_staff,$kolok_staff,$kojab_staff,$nrk_staff,$spmu_staff);

        // echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));

        // if($pilih_pegawai){
        //     echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil','pesan' => $pilih_pegawai));
        // }else{
        //     echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        // }
    }
      

    
    
            		
}
?>            
