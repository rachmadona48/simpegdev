<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_absensi extends CI_Controller {

    private $user = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('mhome', 'home');
        $this->load->model('admin/v_pegawai', 'vpeg');
        $this->load->model('model_riwayat', 'riwayat');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->library('format_uang');


        if ($this->session->userdata('logged_in')) {

            $session_data = $this->session->userdata('logged_in');
            $this->user['id'] = $session_data['id'];
            $this->user['username'] = $session_data['username'];
            $this->user['user_group'] = $session_data['user_group'];
        } else {
            // redirect(base_url().'login/logout', 'refresh');
            redirect(base_url() . 'login', 'refresh');
        }
    }
    
    public function index() {
        // START GET NRK                
        if (isset($_POST['nrk'])) {
            $nrk = $_POST['nrk'];
        } elseif (isset($_POST['nrkP'])) { //Pencarian NRK Untuk Admin/BKD
            $nrk = $_POST['nrkP'];
        } else {
            $nrk = $this->user['id'];

            if ($this->user['user_group'] > 1) {
                $nrk = "";
            }
        }
        
        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'], 'rekap_absensi', 0);
        $datam['inisial'] = 'rekap_absensi';

        $menuid = '29330';
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid, $this->user['user_group']);

        if ($cekaksesmenu == '1') {
            $this->load->view('head/header', $this->user);
            $this->load->view('head/menu', $datam);
            $this->load->view('rekap_absensi', $data);
            $this->load->view('head/footer');
        } else {
            $this->load->view('403');
        }
    }
    
    public function rekap_absensi_detail() {
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('M');
        $bln = intval($bulan);

        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $tgl = isset($_GET['bulan']) ? $_GET['bulan'] . " " . $_GET['tahun'] : date('M Y');
        
        switch ($bulan) {
            case 'Jan':
                $bln = '01';
                break;
            case 'Feb':
                $bln = '02';
                break;
            case 'Mar':
                $bln = '03';
                break;
            case 'Apr':
                $bln = '04';
                break;
            case 'May':
                $bln = '05';
                break;
            case 'Jun':
                $bln = '06';
                break;
            case 'Jul':
                $bln = '07';
                break;
            case 'Aug':
                $bln = '08';
                break;
            case 'Sep':
                $bln = '09';
                break;
            case 'Oct':
                $bln = '10';
                break;
            case 'Nov':
                $bln = '11';
                break;
            case 'Dec':
                $bln = '12';
                break;
            default:
                $bln = date('m');
                break;
        }

        $intBln = intval($bln);

        $GetBulan = $bln;
        $GetTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        
        $dt['bulan'] = $bulan;
        $dt['bln'] = $GetBulan;
        $dt['tahun'] = $tahun;
        $dt['thbl'] = $GetTahun . $GetBulan;

        $bulantahun = $GetBulan . $GetTahun;
        $dt['days'] = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        
        $dt['jumlahAbsen'] = $this->infopegawai->getCountEtkd($this->user['id'], $dt['thbl']);
        $dt['rows'] = $this->infopegawai->getDataEtkd($this->user['id'], $dt['thbl']);
        $dt['isStaff'] = $this->infopegawai->cekIsAtasan($this->user['id'], $dt['thbl']);
        $result_groupUser = $this->infopegawai->getEkinUser($this->user['id'], $dt['thbl']);
        $dt['groupUser'] = $result_groupUser->user_group_id;
        $dt['resultx'] = $this->infopegawai->getDetailsEtkd($this->user['id'], $dt['thbl']);
        
        $this->load->view('rekap_absensi_detail',$dt);
//        echo $data; 
    }

}
?>            
