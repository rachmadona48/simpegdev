<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
	private $user=array();

	public function __construct()
   	{
    	parent::__construct();
    	$this->load->helper(array('form', 'url','download'));    	
    	$this->load->library('session');
    	$this->load->model('mhome','home');
        $this->load->model('admin/v_pegawai','vpeg');
        $this->load->model('model_cuti','cuti');
        $this->load->library('infopegawai');
        $this->load->library('convert');
        $this->load->library('format_uang');
        $this->load->library('encrypt');  
        

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

	

    public function cuti_saya()
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



        $kolok_kojab = $this->cuti->kolok_kojab($nrk);
        $data['cek_pyb'] = $this->cuti->cek_pyb($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
        $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk);
                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        $data['user_id'] = $this->user['id'];
        $data['user_group'] = $this->user['user_group'];

        $data['atasan'] = $this->cuti->atasan_cuti($nrk);        

        // echo "<pre>";
        // print_r($this->db->last_query());
        // print_r($data['atasan']);
        // die();
        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

        $pejtt = ""; 
        $jencuti = "";
        $data['listJenCuti'] = $this->cuti->getJenisCuti($jencuti);
        $data['lokasi_cuti'] = $this->cuti->lokasi_cuti();
        // $data['listPejtt'] = $this->infopegawai->getMasterPejtt($pejtt);
        

        // $info_gaji = $this->riwayat->get_info_gaji($nrk);
        // // echo $info_pg->JML_PGW;exit();
        // $data['info_gaji'] = $info_gaji->JML;

        // $info_gr = $this->riwayat->get_info_tkd_gr($nrk);
        // $data['info_tkd_gr'] = $info_gr->JML_GR;  

        // $data['activemn'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'cuti_saya',0);
        $datam['inisial'] = 'cuti_saya';

        $menuid='29438';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        // echo $cekaksesmenu;exit();

        if($cekaksesmenu == '1')
        {
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('cuti_saya',$data);
                $this->load->view('head/footer');   
        }
        else
        {
            $this->load->view('403');
        }

    }

    public function act_cari_plt(){
        $nrk_user = $this->user['id'];
        $nrk_plt = $this->input->post('nrk');
        $option = "";
        $nrk = "";
        $cek_spmu = $this->cuti->pgw_cuti($nrk_user);
        $cari = $this->cuti->cari_plt($nrk_plt,$cek_spmu->SPMU,$nrk_user);
        if($cari){
            // $option .= "<option value='".$cari->NRK."' selected>".$cari->NIP18." - ".$cari->NAMA."</option>";
            $option .= $cari->NIP18." - ".$cari->NAMA;
            $nrk .= $cari->NRK;
            $array = array("respone" => 'SUKSES', 'pesan' => "NRK ditemukan", 'option' => $option, 'nrk' => $nrk);
        }else{
            $array = array("respone" => 'GAGAL', 'pesan' => "Data tidak valid", 'option' => $option, 'nrk' => $nrk);
        }

        // $array = array("respone" => 'GAGAL', 'pesan' => "Cuti harus pada tahun yang sama")
        echo json_encode($array);
    }

    public function cek_kolok(){
        $nrk = $this->user['id'];
        // echo $nrk;exit();
        // $cek_spmu = $this->cuti->pgw_cuti($nrk_user);

        // $kolok = $this->input->post('kolok_plt_plh');
        $kolok = $this->cuti->kolok_plt_plh($nrk);

        echo json_encode($kolok);
    }

    public function cek_kojab(){
        $kolok = $this->input->post('kolok_plt_plh');
        $kojab = $this->cuti->get_kojab_tbl($kolok);

        echo json_encode($kojab);
    }

    public function data_cuti_saya()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        // $this->cuti->get_data_cuti($nrk,$count_bawahan->jml,$tahun,$thbl);

        $this->cuti->get_data_cuti($nrk);
    }

    public function data_cuti_atasan()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_atasan($nrk,$tahun,$thbl);
    }

    public function data_cuti_atasan_sudah_validasi()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_atasan_sudah_validasi($nrk,$tahun,$thbl);
    }

    public function data_cuti_pyb()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();



        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pyb($nrk,$thbl);
    }

    public function data_cuti_pyb_2()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();



        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pyb_2($nrk,$thbl);
    }

    public function data_cuti_pyb_lokasi_luar_negeri()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();



        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pyb_lokasi_luar_negeri($nrk);
    }

    public function data_cuti_pyb_lokasi_luar_negeri_2()
    {
        
        $nrk = $this->user['id'];

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pyb_lokasi_luar_negeri_2($nrk);
    }

    public function cek_tmt_cuti_tahunan(){
    	$nrk = $this->user['id'];
    	$cek_masker = $this->cuti->cek_masker($nrk);

        $cek_rekap = $this->cuti->cek_rekap($nrk);
        if($cek_rekap->JML >= 2){
        	if($cek_masker->MASKER_BLN > 12){

                $thn_awal = date('Y');
                // echo $thn_awal;exit();
                $cek_sisa_cuti_n = $this->cek_sisa_cuti_n($nrk,$thn_awal);
                $cek_sisa_cuti_n_1 = $this->cek_sisa_cuti_n_1($nrk,$thn_awal);
                $cek_sisa_cuti_n_2 = $this->cek_sisa_cuti_n_2($nrk,$thn_awal);

                if($cek_sisa_cuti_n <= 0){
                    $sisa_n = 0;
                }else{
                    $sisa_n = $cek_sisa_cuti_n;
                }

                if($cek_sisa_cuti_n_1 <= 0){
                    $sisa_n_1 = 0;
                }else{
                    $sisa_n_1 = $cek_sisa_cuti_n_1;
                }

                if($cek_sisa_cuti_n_2 <= 0){
                    $sisa_n_2 = 0;
                }else{
                    $sisa_n_2 = $cek_sisa_cuti_n_2;
                }

                // echo $sisa_n.' : '.$sisa_n_1.' : '.$sisa_n_2;exit();


                $tahun_n = $sisa_n;
                $tahun_n_1 = $sisa_n_1 ;
                $tahun_n_2 = $sisa_n_2;

                    // echo $tahun_n.' : '.$tahun_n_1.' : '.$tahun_n_2;exit();

        		echo json_encode(array("respone" => 'SUKSES', 'tahun_n' => $tahun_n,'tahun_n_1' => $tahun_n_1 ,'tahun_n_2' => $tahun_n_2, 'pesan' => ""));
        	}else{
        		echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Masa kerja belum mencukupi"));
        	}
        }else{
            echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Rekap cuti tahun sebelumnya tidak lengkap, silakan hubungi Admin SKPD anda"));
        }
    }

    public function cek_jml_cuti(){
    	$nrk = $this->user['id'];
        $tmt = $this->input->post('tmt');
        $tgakhir = $this->input->post('tgakhir');
        $jencuti = $this->input->post('jencuti');

        $cek_masker = $this->cuti->cek_masker_dari_tmt($nrk,$tmt);
        // echo $cek_masker->MASKER_BLN;exit();

        if($jencuti == 1){
            if($cek_masker->MASKER_BLN > 12){
                $thn_awal = substr($tmt ,6,4); 
                $thn_akhir = substr($tgakhir ,6,4); 

                // echo $thn_awal.' - '.$thn_akhir;exit();
                if($thn_awal == $thn_akhir){
                    $this->cek_cuti_tahunan($nrk,$tmt,$tgakhir);
                }else{
                    echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Cuti harus pada tahun yang sama"));
                }
            }else{
                echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Tanggal awal belum memenuhi masa kerja"));
            }

        }

        
    }

    public function cek_cuti_tahunan($nrk,$tmt,$tgakhir){
        $jml_hari = $this->jml_hari_dua_tgl($tmt,$tgakhir);

        $cek_sabtu_minggu = $this->cek_sabtu_minggu($tmt,$tgakhir);
        // echo 'wekend '.$cek_sabtu_minggu;exit();
        $cek_libur_nas = $this->cuti->cek_libur_nas($tmt,$tgakhir);

        $hari_libur = $cek_sabtu_minggu + $cek_libur_nas->JML;

        $total_cuti = $jml_hari - $hari_libur;

        $thn_awal = substr($tmt ,6,4);
        $cek_sisa_cuti_n = $this->cek_sisa_cuti_n($nrk,$thn_awal);
        $cek_sisa_cuti_n_1 = $this->cek_sisa_cuti_n_1($nrk,$thn_awal);
        $cek_sisa_cuti_n_2 = $this->cek_sisa_cuti_n_2($nrk,$thn_awal);

        // echo $total_cuti.' - '.$hari_libur.' - '.$jml_hari.' - '.$cek_sisa_cuti_n.' _ '.$cek_sisa_cuti_n_1.' _ '.$cek_sisa_cuti_n_2.' = ';

        if($cek_sisa_cuti_n <= 0){
            $sisa_n = 0;
        }else{
            $sisa_n = $cek_sisa_cuti_n;
        }

        if($cek_sisa_cuti_n_1 <= 0){
            $sisa_n_1 = 0;
        }else{
            $sisa_n_1 = $cek_sisa_cuti_n_1;
        }

        if($cek_sisa_cuti_n_2 <= 0){
            $sisa_n_2 = 0;
        }else{
            $sisa_n_2 = $cek_sisa_cuti_n_2;
        }



        if($sisa_n >= $total_cuti){
            $tahun_n = 0;
            $tahun_n_1 = 0;
            $tahun_n_2 = 0;
            if($total_cuti <= $sisa_n_2){
                $tahun_n = 0;
                $tahun_n_1 = 0;
                $tahun_n_2 = $total_cuti;
            }else{
                $tambahan_n_1 = $total_cuti - $sisa_n_2;
                if($tambahan_n_1 <= $sisa_n_1){
                    $tahun_n = 0;
                    $tahun_n_1 = $tambahan_n_1 ;
                    $tahun_n_2 = $sisa_n_2;
                }else{
                    $tambahan_n = $tambahan_n_1 - $sisa_n_1;
                    if($tambahan_n <= $sisa_n){
                        $tahun_n = $tambahan_n;
                        $tahun_n_1 = $sisa_n_1 ;
                        $tahun_n_2 = $sisa_n_2;

                    }
                }
            }

            // echo $tahun_n.' - '.$tahun_n_1.' - '.$tahun_n_2;exit();

            echo json_encode(array("respone" => 'SUKSES','tahun_n' => $tahun_n,'tahun_n_1' => $tahun_n_1 ,'tahun_n_2' => $tahun_n_2 ,'total_cuti' => $total_cuti , 'pesan' => ""));

        }else{
            echo json_encode(array("respone" => 'GAGAL','tahun_n' => 0,'tahun_n_1' => 0 ,'tahun_n_2' => 0 ,'total_cuti' => 0, 'pesan' => "Sisa cuti tidak cukup"));
        }

    }

    public function cek_sabtu_minggu($tmt,$tgakhir){
        // echo $tmt.' - '.$tgakhir;


        // penanggalan Indonesia
        setlocale(LC_TIME, 'id_ID.UTF8');
         
        $awal_cuti = $tmt;
        $akhir_cuti = $tgakhir;
         
        // tanggalnya diubah formatnya ke Y-m-d 
        $awal_cuti = date_create_from_format('d-m-Y', $awal_cuti);
        $awal_cuti = date_format($awal_cuti, 'Y-m-d');
        $awal_cuti = strtotime($awal_cuti);
         
        $akhir_cuti = date_create_from_format('d-m-Y', $akhir_cuti);
        $akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
        $akhir_cuti = strtotime($akhir_cuti);
         
        $haricuti = array();
        $sabtuminggu = array();
         
        for ($i=$awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
            if (date('w', $i) !== '0' && date('w', $i) !== '6') {
                $haricuti[] = $i;
            } else {
                $sabtuminggu[] = $i;
            }
         
        }
        $jumlah_cuti = count($haricuti);
        $jumlah_sabtuminggu = count($sabtuminggu);

        // echo 'sabtu - mgu : '.$jumlah_sabtuminggu;exit();
        return $jumlah_sabtuminggu;
    }

    public function jml_hari_dua_tgl($tmt,$tgakhir)
    {
        $tmt = strtotime($tmt);
        $tgakhir = strtotime($tgakhir);
        $jml = (($tgakhir - $tmt)/ (24 *3600))+1;
        // echo $jml;exit();
        return $jml;
    }

    public function cek_sisa_cuti_n($nrk,$thn){
    	$cek_cuti_n = $this->cuti->cek_cuti_n($nrk,$thn);

        // echo $cek_cuti_n->JML;exit();

    	$sisa_cuti_n = 12 - $cek_cuti_n->JML;

        // echo $sisa_cuti_n; exit();

    	return $sisa_cuti_n;
    }

    public function cek_sisa_cuti_n_1($nrk,$thn){
    	// echo ($thn-1).'dd';exit();
    	$thn_n_1 = $thn-1;
    	// echo $thn_n_1;exit();
    	$cek_jml_cuti_n_1 = $this->cuti->cek_jml_cuti_n_1($nrk,$thn_n_1);
        $count_rekap = $this->cuti->count_rekap($nrk,$thn_n_1);

        if($count_rekap->JML > 0){
            $cek_rekap_cuti = $this->cuti->cek_rekap_cuti($nrk,$thn_n_1);
            $cek_rekap_cuti = $cek_rekap_cuti->JML;
        }else{
            $cek_rekap_cuti = 0;
        }
        
    	if($cek_jml_cuti_n_1->JML >= 0){
    		// $cek_cuti_n_1_ditangguhkan = $this->cuti->cek_cuti_n_1_ditangguhkan($nrk,$thn_n_1);
    		$count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
    		
    		if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
    			$count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
    			if(($count_cuti->JML + $cek_rekap_cuti) <= 0){ #jika tidak pernah ambil cuti
    				$sisa_n_1 = 6 - $cek_rekap_cuti;
    				$pesan = 'pesan 1';
    			}else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
    				$cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
    				if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
    					$sisa_n_1 = $cek_status_cuti->CUTI_N;
    					$pesan = 'pesan 2';
    				}else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
    					if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
    						$sisa_n_1 = 6 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
    						$pesan = 'pesan 3';
    					}else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
    						$sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
    						$pesan = 'pesan 4';
    					}
    				}
    			}else{ #jika telah disetujui cuti lebih dari 1 kali
    				$sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_1($nrk,$thn_n_1);
    				if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
    					$sisa_n_1_awal = 6 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti);
                        if($sisa_n_1_awal >= 6){
                            $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
    					$pesan = 'pesan 5';
    				}else{
    					$sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) ;
    					$pesan = 'pesan 6';
    				}
    			}
    		}else{
    			$sisa_n_1 = 0;
    			$pesan = 'pesan 7';
    		}
    	}else{
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if($count_cuti->JML <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - ($cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                    $pesan = 'pesan 8';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N - $cek_jml_cuti_n_1->JML;
                        $pesan = 'pesan 9';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 10';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            $pesan = 'pesan 11';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_1($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1_awal = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                        if($sisa_n_1_awal > 6){
                            $sisa_n_1 = 6;

                            $pesan_2 = '111';
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;

                            $pesan_2 = '222';
                        }
                        $pesan = 'pesan 12';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) ;
                        $pesan = 'pesan 13';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 14';
            }

    		
    	}

    	// echo $pesan.' - '.$sisa_n_1.' - '.$sum_cuti_n_1_exist->JML.' - '.$cek_rekap_cuti;exit();

    	return $sisa_n_1;
    }

    public function cek_sisa_cuti_n_2($nrk,$thn){
    	// echo ($thn-1).'dd';exit();
    	$thn_n_1 = $thn-2;
    	// echo $thn_n_1;exit();
    	$cek_jml_cuti_n_1 = $this->cuti->cek_jml_cuti_n_2($nrk,$thn_n_1);
        $count_rekap = $this->cuti->count_rekap($nrk,$thn_n_1);

        if($count_rekap->JML > 0){
            $cek_rekap_cuti = $this->cuti->cek_rekap_cuti($nrk,$thn_n_1);
            $cek_rekap_cuti = $cek_rekap_cuti->JML;
        }else{
            $cek_rekap_cuti = 0;
        }

        if($cek_jml_cuti_n_1->JML <= 0){
            // $cek_cuti_n_1_ditangguhkan = $this->cuti->cek_cuti_n_1_ditangguhkan($nrk,$thn_n_1);
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if(($count_cuti->JML + $cek_rekap_cuti) <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - $cek_rekap_cuti;
                    $pesan = 'pesan 1';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N;
                        $pesan = 'pesan 2';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 6 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 3';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            $pesan = 'pesan 4';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_2($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1_awal = 6 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti);
                        if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 5';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) ;
                        $pesan = 'pesan 6';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 7';
            }
        }else{
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if($count_cuti->JML <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - ($cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                    $pesan = 'pesan 8';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N - $cek_jml_cuti_n_1->JML;
                        $pesan = 'pesan 9';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti+$cek_jml_cuti_n_1->JML);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 10';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            $pesan = 'pesan 11';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_2($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti+$cek_jml_cuti_n_1->JML);
                        if($sisa_n_1_awal > 6){
                            $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 12';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) ;
                        $pesan = 'pesan 13';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 14';
            }

            
        }

    	// echo $pesan.' - '.$sisa_n_1;exit();

    	return $sisa_n_1;
    }

    public function save_ct_tahunan(){
        $nrk = $this->user['id'];
        $nrk_atasan = $this->input->post('atasan');
        $jencuti = $this->input->post('jencuti');
        $id_lokasi = $this->input->post('id_lokasi');
        $alasan_cuti = $this->input->post('alasan_cuti');
        $tmt = $this->input->post('tmt');
        $tgakhir = $this->input->post('tgakhir');
        $cuti_n_2 = $this->input->post('tahun_n_2');
        $cuti_n_1 = $this->input->post('tahun_n_1');
        $cuti_n = $this->input->post('tahun_n');
        $total_cuti = $this->input->post('total_cuti');
        $telp_cuti = $this->input->post('telp_cuti');
        $almt_cuti = $this->input->post('almt_cuti');

        $status_atasan = $this->input->post('status_atasan');
        $nrk_plt_plh = $this->input->post('nrk_atasan_plt_plh');
        $kolok_plt_plh = $this->input->post('kolok_plt_plh');
        $kojab_plt_plh = $this->input->post('kojab_plt_plh');
        // exit();

        $thn_awal = substr($tmt ,6,4);
        $tahun_n_1= $thn_awal-1;
        $tahun_n_2= $thn_awal-2;

        $cek_jarak_tanggal = $this->cuti->cek_jarak_tanggal($tmt);
        // echo $cek_jarak_tanggal->JML;exit();

        // if($cek_jarak_tanggal->JML >= 1){
            // echo 'oke';exit();

            $save = $this->cuti->save_ct_tahunan($nrk,$jencuti,$id_lokasi,$alasan_cuti,$tmt,$tgakhir,$tahun_n_1,$tahun_n_2,$cuti_n_2,$cuti_n_1,$cuti_n,$total_cuti,$telp_cuti,$almt_cuti,$nrk_atasan,$status_atasan,$nrk_plt_plh,$kolok_plt_plh,$kojab_plt_plh);

            if($save){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Data berhasil disimpan'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Data gagal disimpan'));
            }

        // }else{
        //     echo json_encode(array("respone" => 'GAGAL','pesan' => 'Pengajuan cuti tahunan minimal harus satu bulan sebelum tanggal mulai'));
        // }

    }

    public function detail_cuti(){
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');

        $widthForm = "two";

        if($jencuti == 1){
            $pesan = 'cuti 1';
            $data['detail'] = $this->cuti->detail_cuti_tahunan($id_hist);
            $form_detail = 'cuti_tahunan';
        }else{
            $pesan = 'cuti 1';
            $data['detail'] = '';
            $form_detail = 'belum_ada_form';
        }

        // echo $pesan;exit();

        $msg = $this->load->view('admin/form_detail_cuti/form_'.$form_detail, $data, true);
        // $msg = $this->load->view('admin/form_hist/form_cuti', $data, true);
        // var_dump($msg);exit;

        // $return = array('response' => 'SUKSES', 'result' => $msg, 'widthForm' => $widthForm);

        if($msg){
            $return = array('response' => 'SUKSES', 'result' => $msg, 'widthForm' => $widthForm, 'pesan' => '');
        }else{
            $return = array('response' => 'GAGAL', 'result' => '', 'widthForm' => $widthForm, 'pesan' => 'Gagal');
        }
        
        echo json_encode($return);
    }

    public function get_rubah_cuti(){
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');

        $widthForm = "two";

        if($jencuti == 1){
        	$id_lokasi = $this->input->post('id_lokasi');
        	$data['lokasi_cuti'] = $this->cuti->lokasi_cuti($id_lokasi);
            $pesan = 'cuti 1';
            $data['detail'] = $this->cuti->detail_cuti_tahunan($id_hist);
            $form_ubah = 'ubah_cuti_tahunan';
        }else{
            $pesan = 'cuti 1';
            $data['detail'] = '';
            $form_ubah = 'ubah_belum_ada_form';
        }

        // echo $pesan;exit();

        $msg = $this->load->view('admin/form_rubah_cuti/form_'.$form_ubah, $data, true);
        // $msg = $this->load->view('admin/form_hist/form_cuti', $data, true);
        // var_dump($msg);exit;

        // $return = array('response' => 'SUKSES', 'result' => $msg, 'widthForm' => $widthForm);

        if($msg){
            $return = array('response' => 'SUKSES', 'result' => $msg, 'widthForm' => $widthForm, 'pesan' => '');
        }else{
            $return = array('response' => 'GAGAL', 'result' => '', 'widthForm' => $widthForm, 'pesan' => 'Gagal');
        }
        
        echo json_encode($return);
    }

    public function hist_detail_cuti(){
        $this->cuti->hist_detail_cuti();
    }

    public function prinf_rs(){
        $dn     = $this->input->get('dn');
        $link     = base64_decode($dn);
        // $link     = $this->encrypt->decode($dn);

        force_download($link,NULL);

    }

    public function save_verif_batal(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $ket = $this->input->post('ket');

        $id_status_baru = 9;

        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function save_verif_perubahan(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $ket = $this->input->post('ket');

        $id_status_baru = 2;

        $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,'',$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN);
        // $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function save_verif_ditangguhkan(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $ket = $this->input->post('ket');

        $id_status_baru = 3;

        $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,'',$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN);

        // $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function save_verif_setujui_atasan(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $ket = $this->input->post('ket');

        $id_status_baru = 4;

        $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,'',$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }


    // start ubah/revisi cuti

    public function cek_jml_cuti_ubah(){
        $nrk = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $tmt = $this->input->post('tmt');
        $tgakhir = $this->input->post('tgakhir');
        $jencuti = $this->input->post('jencuti');

        $cek_masker = $this->cuti->cek_masker_dari_tmt($nrk,$tmt);
        // echo $cek_masker->MASKER_BLN;exit();

        if($jencuti == 1){
            if($cek_masker->MASKER_BLN > 12){
                $thn_awal = substr($tmt ,6,4); 
                $thn_akhir = substr($tgakhir ,6,4); 

                // echo $thn_awal.' - '.$thn_akhir;exit();
                if($thn_awal == $thn_akhir){
                    $this->cek_cuti_tahunan_ubah($id_hist,$nrk,$tmt,$tgakhir);
                }else{
                    echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Cuti harus pada tahun yang sama"));
                }
            }else{
                echo json_encode(array("respone" => 'GAGAL', 'pesan' => "Tanggal awal belum memenuhi masa kerja"));
            }

        }

        
    }


    public function cek_cuti_tahunan_ubah($id_hist,$nrk,$tmt,$tgakhir){
        $jml_hari = $this->jml_hari_dua_tgl($tmt,$tgakhir);

        $cek_sabtu_minggu = $this->cek_sabtu_minggu($tmt,$tgakhir);
        // echo 'wekend '.$cek_sabtu_minggu;exit();
        $cek_libur_nas = $this->cuti->cek_libur_nas($tmt,$tgakhir);

        $hari_libur = $cek_sabtu_minggu + $cek_libur_nas->JML;

        $total_cuti = $jml_hari - $hari_libur;

        $thn_awal = substr($tmt ,6,4);
        $cek_sisa_cuti_n = $this->cek_sisa_cuti_n_ubah($id_hist,$nrk,$thn_awal);
        $cek_sisa_cuti_n_1 = $this->cek_sisa_cuti_n_1_ubah($id_hist,$nrk,$thn_awal);
        $cek_sisa_cuti_n_2 = $this->cek_sisa_cuti_n_2_ubah($id_hist,$nrk,$thn_awal);

        // echo $total_cuti.' - '.$hari_libur.' - '.$jml_hari.' - '.$cek_sisa_cuti_n.' _ '.$cek_sisa_cuti_n_1.' _ '.$cek_sisa_cuti_n_2.' = ';

        if($cek_sisa_cuti_n <= 0){
            $sisa_n = 0;
        }else{
            $sisa_n = $cek_sisa_cuti_n;
        }

        if($cek_sisa_cuti_n_1 <= 0){
            $sisa_n_1 = 0;
        }else{
            $sisa_n_1 = $cek_sisa_cuti_n_1;
        }

        if($cek_sisa_cuti_n_2 <= 0){
            $sisa_n_2 = 0;
        }else{
            $sisa_n_2 = $cek_sisa_cuti_n_2;
        }



        if($sisa_n >= $total_cuti){
            $tahun_n = 0;
            $tahun_n_1 = 0;
            $tahun_n_2 = 0;
            if($total_cuti <= $sisa_n_2){
                $tahun_n = 0;
                $tahun_n_1 = 0;
                $tahun_n_2 = $total_cuti;
            }else{
                $tambahan_n_1 = $total_cuti - $sisa_n_2;
                if($tambahan_n_1 <= $sisa_n_1){
                    $tahun_n = 0;
                    $tahun_n_1 = $tambahan_n_1 ;
                    $tahun_n_2 = $sisa_n_2;
                }else{
                    $tambahan_n = $tambahan_n_1 - $sisa_n_1;
                    if($tambahan_n <= $sisa_n){
                        $tahun_n = $tambahan_n;
                        $tahun_n_1 = $sisa_n_1 ;
                        $tahun_n_2 = $sisa_n_2;

                    }
                }
            }

            // echo $tahun_n.' - '.$tahun_n_1.' - '.$tahun_n_2;exit();

            echo json_encode(array("respone" => 'SUKSES','tahun_n' => $tahun_n,'tahun_n_1' => $tahun_n_1 ,'tahun_n_2' => $tahun_n_2 ,'total_cuti' => $total_cuti , 'pesan' => ""));

        }else{
            echo json_encode(array("respone" => 'GAGAL','tahun_n' => 0,'tahun_n_1' => 0 ,'tahun_n_2' => 0 ,'total_cuti' => 0, 'pesan' => "Sisa cuti tidak cukup"));
        }

    }

    public function cek_sisa_cuti_n_ubah($id_hist,$nrk,$thn){
        $cek_cuti_n = $this->cuti->cek_cuti_n_ubah($id_hist,$nrk,$thn);

        $sisa_cuti_n = 12 - $cek_cuti_n->JML;

        // echo $sisa_cuti_n;exit();

        return $sisa_cuti_n;
    }

    public function cek_sisa_cuti_n_1_ubah($id_hist,$nrk,$thn){
        // echo ($thn-1).'dd';exit();
        $thn_n_1 = $thn-1;
        // echo $thn_n_1;exit();
        $cek_jml_cuti_n_1 = $this->cuti->cek_jml_cuti_n_1_ubah($id_hist,$nrk,$thn_n_1);
        $count_rekap = $this->cuti->count_rekap($nrk,$thn_n_1);

        if($count_rekap->JML > 0){
            $cek_rekap_cuti = $this->cuti->cek_rekap_cuti($nrk,$thn_n_1);
            $cek_rekap_cuti = $cek_rekap_cuti->JML;
        }else{
            $cek_rekap_cuti = 0;
        }
        
        if($cek_jml_cuti_n_1->JML <= 0){
            // $cek_cuti_n_1_ditangguhkan = $this->cuti->cek_cuti_n_1_ditangguhkan($nrk,$thn_n_1);
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if(($count_cuti->JML + $cek_rekap_cuti) <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - $cek_rekap_cuti;
                    $pesan = 'pesan 1';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N;
                        $pesan = 'pesan 2';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 6 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 3';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            $pesan = 'pesan 4';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_1($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1_awal = 6 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti);
                        if($sisa_n_1_awal > 6){
                            $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 5';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) ;
                        $pesan = 'pesan 6';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 7';
            }
        }else{
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if($count_cuti->JML <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - ($cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                    $pesan = 'pesan 8';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7 || $cek_status_cuti->STATUS_CUTI == 10 || $cek_status_cuti->STATUS_CUTI == 11){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N - $cek_jml_cuti_n_1->JML;
                        $pesan = 'pesan 9';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 10';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            $pesan = 'pesan 11';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_1($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1_awal = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                        if($sisa_n_1_awal > 6){
                            $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 12';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) ;
                        $pesan = 'pesan 13';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 14';
            }

            
        }

        // echo $pesan.' - '.$sisa_n_1;exit();

        return $sisa_n_1;
    }

    public function cek_sisa_cuti_n_2_ubah($id_hist,$nrk,$thn){
        // echo ($thn-1).'dd';exit();
        $thn_n_1 = $thn-2;
        // echo $thn_n_1;exit();
        $cek_jml_cuti_n_1 = $this->cuti->cek_jml_cuti_n_2_ubah($id_hist,$nrk,$thn_n_1);
        $count_rekap = $this->cuti->count_rekap($nrk,$thn_n_1);

        if($count_rekap->JML > 0){
            $cek_rekap_cuti = $this->cuti->cek_rekap_cuti($nrk,$thn_n_1);
            $cek_rekap_cuti = $cek_rekap_cuti->JML;
        }else{
            $cek_rekap_cuti = 0;
        }

        if($cek_jml_cuti_n_1->JML <= 0){
            // $cek_cuti_n_1_ditangguhkan = $this->cuti->cek_cuti_n_1_ditangguhkan($nrk,$thn_n_1);
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if(($count_cuti->JML + $cek_rekap_cuti) <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - $cek_rekap_cuti;
                    $pesan = 'pesan 1';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N;
                        $pesan = 'pesan 2';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1_awal = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 3';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti);
                            $pesan = 'pesan 4';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_2($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1_awal = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti);
                        if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 5';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti) ;
                        $pesan = 'pesan 6';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 7';
            }
        }else{
            $count_cuti_besar = $this->cuti->cek_count_cuti_besar($nrk,$thn_n_1);
            
            if($count_cuti_besar->JML <= 0){ #jika tidak ada cuti besar
                $count_cuti = $this->cuti->cek_count_cuti($nrk,$thn_n_1);
                if($count_cuti->JML <= 0){ #jika tidak pernah ambil cuti
                    $sisa_n_1 = 6 - ($cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                    $pesan = 'pesan 8';
                }else if($count_cuti->JML == 1){ #jika pernah ambil cuti 1 kali
                    $cek_status_cuti = $this->cuti->cek_status_cuti($nrk,$thn_n_1);
                    if($cek_status_cuti->STATUS_CUTI == 3 || $cek_status_cuti->STATUS_CUTI == 7){ #jika ada 1 cuti tapi ditangguhkan
                        $sisa_n_1 = $cek_status_cuti->CUTI_N - $cek_jml_cuti_n_1->JML;
                        $pesan = 'pesan 9';
                    }else{ #jika pernah cuti tapi tidak ditangguhkan
                        $sum_cuti_n_1 = $this->cuti->cek_cuti_setuju($nrk,$thn_n_1);
                        if(($sum_cuti_n_1->JML + $cek_rekap_cuti) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti+$cek_jml_cuti_n_1->JML);
                            if($sisa_n_1_awal > 6){
                                    $sisa_n_1 = 6;
                            }else{
                                $sisa_n_1 = $sisa_n_1_awal;
                            }
                            $pesan = 'pesan 10';
                        }else{  #jika pernah ambil cuti tapi kurang dari 6 hari
                            // ECHO $cek_status_cuti->CUTI_N + $cek_rekap_cuti->JML;exit();
                            $sisa_n_1 = 12 - ($sum_cuti_n_1->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML);
                            $pesan = 'pesan 11';
                        }
                    }
                }else{ #jika telah disetujui cuti lebih dari 1 kali
                    $sum_cuti_n_1_exist = $this->cuti->cek_cuti_setuju_n_2($nrk,$thn_n_1);
                    if(($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) < 6){ #jika pernah ambil cuti tapi kurang 6 hari
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti+$cek_jml_cuti_n_1->JML);
                        if($sisa_n_1_awal > 6){
                                $sisa_n_1 = 6;
                        }else{
                            $sisa_n_1 = $sisa_n_1_awal;
                        }
                        $pesan = 'pesan 12';
                    }else{
                        $sisa_n_1 = 12 - ($sum_cuti_n_1_exist->JML + $cek_rekap_cuti + $cek_jml_cuti_n_1->JML) ;
                        $pesan = 'pesan 13';
                    }
                }
            }else{
                $sisa_n_1 = 0;
                $pesan = 'pesan 14';
            }

            
        }

        // echo $pesan.' - '.$sisa_n_1;exit();

        return $sisa_n_1;
    }

    public function save_ct_tahunan_ubah(){
        $nrk = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $id_lokasi = $this->input->post('id_lokasi');
        // echo $id_lokasi;exit();
        $alasan_cuti = $this->input->post('alasan_cuti');
        $tmt = $this->input->post('tmt');
        $tgakhir = $this->input->post('tgakhir');
        $cuti_n_2 = $this->input->post('tahun_n_2');
        $cuti_n_1 = $this->input->post('tahun_n_1');
        $cuti_n = $this->input->post('tahun_n');
        $total_cuti = $this->input->post('total_cuti');
        $telp_cuti = $this->input->post('telp_cuti');
        $almt_cuti = $this->input->post('almt_cuti');
        $ket = $this->input->post('ket');

        $thn_awal = substr($tmt ,6,4);
        $tahun_n_1= $thn_awal-1;
        $tahun_n_2= $thn_awal-2;

        // $cek_jarak_tanggal = $this->cuti->cek_jarak_tanggal($tmt);
        // echo $cek_jarak_tanggal->JML;exit();

        // if($cek_jarak_tanggal->JML >= 1){
            // echo 'oke';exit();

            $save = $this->cuti->save_ct_tahunan_ubah($id_hist,$nrk,$jencuti,$id_lokasi,$alasan_cuti,$tmt,$tgakhir,$tahun_n_1,$tahun_n_2,$cuti_n_2,$cuti_n_1,$cuti_n,$total_cuti,$telp_cuti,$almt_cuti,$ket);

            if($save){
                echo json_encode(array("respone" => 'SUKSES','pesan' => 'Data berhasil disimpan'));
            }else{
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Data gagal disimpan'));
            }

        // }else{
        //     echo json_encode(array("respone" => 'GAGAL','pesan' => 'Pengajuan cuti tahunan minimal harus satu bulan sebelum tanggal mulai'));
        // }

    }

    // end ubah/revisi cuti

    // start act pyb

    public function save_verif_setujui_pyb(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $status_pyb = $this->input->post('status_pyb');
        $ket = $this->input->post('ket');

        // echo $status_pyb;exit();

        $id_status_baru = 5;

        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,$status_pyb);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function save_verif_ditangguhkan_pyb(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $status_pyb = $this->input->post('status_pyb');
        $ket = $this->input->post('ket');

        $id_status_baru = 7;

        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,$status_pyb);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    public function save_verif_setujui_penangguhan_pyb(){
        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist');
        $jencuti = $this->input->post('jencuti');
        $status_pyb = $this->input->post('status_pyb');
        $ket = $this->input->post('ket');

        $id_status_baru = 10;

        $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user,$status_pyb);

        if($update){
            echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
        }else{
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }
    }

    // end pyb


    //cetak SK Cuti

    public function cetak_sk($id_hist,$jencuti){
        // echo $id_hist.' c '.$jencuti;exit();

        if($jencuti == 1){
            $this->sk_cuti_tahunan($id_hist,$jencuti);
            // $this->sk_cuti_tahunan2($id_hist,$jencuti);
            
            // $this->pdfTest();
        }
    }

    public function sk_cuti_tahunan($id_hist,$jencuti){

        $this->load->library("pdf_cuti");
        $pdf_cuti = new pdf_cuti('P', 'mm', 'F5', true, 'UTF-8', false);

        // ob_start();

        $pdf_cuti->SetCreator(PDF_CREATOR);
        // Add a page
        // ob_start();
        $pdf_cuti->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-25, PDF_MARGIN_RIGHT);
        // $pdf_cuti->Output('name.pdf', 'D');
        $pdf_cuti->AddPage();

        $pdf_cuti->SetFont('helvetica', '', 8);

        // add a page
        // $this->pdf_cuti->AddPage();

        $pdf_cuti->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);

        $dt_cuti = $this->cuti->data_cuti($id_hist);
        $jab_pgw_cuti = $this->cuti->jab_pgw_cuti($dt_cuti->KOLOK,$dt_cuti->KOJAB,$dt_cuti->KD);
        $tahun_kerja = (date('Y', strtotime($dt_cuti->TMT))) - (date('Y', strtotime($dt_cuti->MUANG)));

        $stj_atasan = $this->cuti->stj_atasan($id_hist);
        $tangguh_atasan = $this->cuti->tangguh_atasan($id_hist);
        $sts_stj_atasan = '';
        $sts_tgh_atasan = '';
        if($stj_atasan->JML >= 1){
            $sts_stj_atasan = 'V';
            $sts_tgh_atasan = '';
        }elseif ($tangguh_atasan->JML >= 1){
            $sts_stj_atasan = '';
            $sts_tgh_atasan = 'V';
        }


        $stj_pejabat = $this->cuti->stj_pejabat($id_hist);
        $tangguh_pejabat = $this->cuti->tangguh_pejabat($id_hist);
        $sts_stj_pejabat = '';
        $sts_tgh_pejabat = '';
        if($stj_pejabat->JML >= 1){
            $sts_stj_pejabat = 'V';
            $sts_tgh_pejabat = '';
        }elseif ($tangguh_pejabat->JML >= 1){
            $sts_stj_pejabat = '';
            $sts_tgh_pejabat = 'V';
        }


        $dt_atasan = $this->cuti->dt_atasan($id_hist);
        if($dt_atasan->NRK_ATS == '000000'){
            $nm_ats = $dt_atasan->NAMA;
            $nip_ats = '';
            $jbt_ats = '<br/><br/>';
        }else{
            $nm_ats = $dt_atasan->NAMA;
            $nip_ats = 'NIP '.$dt_atasan->NIP18;

            $jab_ats_cuti = $this->cuti->jab_pgw_cuti($dt_atasan->KOLOK_ATS,$dt_atasan->KOJAB_ATS,$dt_atasan->KD_ATS);
            // $lokasi = $this->cuti->lokasi_tbl($dt_pejabat->KOLOK_PJB);
            $jbt_ats = $jab_ats_cuti->NAJABL;
        }

        


        $dt_pejabat = $this->cuti->dt_pejabat($id_hist);
        if($dt_pejabat->NRK_PJB == '000000'){
            $nm_pjb = $dt_pejabat->NAMA;
            $nip_pjb = '';
            $jbt_pjb = '<br/><br/>';
        }else{
            $nm_pjb = $dt_pejabat->NAMA;
            $nip_pjb = 'NIP '.$dt_pejabat->NIP18;

            $jab_pjb_cuti = $this->cuti->jab_pgw_cuti($dt_pejabat->KOLOK_PJB,$dt_pejabat->KOJAB_PJB,$dt_pejabat->KD_PJB);
            $lokasi = $this->cuti->lokasi_tbl($dt_pejabat->KOLOK_PJB);
            // echo $dt_pejabat->KOLOK_PJB;exit();
            if($dt_pejabat->KOLOK_PJB == '000001102' && $dt_pejabat->KOJAB_PJB == '000000'){
            	$jbt_pjb = $jab_pjb_cuti->NAJABL;
            	// echo 'satu';
            }else{
            	$jbt_pjb = $jab_pjb_cuti->NAJABL.', '.$lokasi->NALOKL;
            	// echo 'dua';
            }
            // exit();
        }

        // echo $nm_pjb.' - '.$nip_pjb.' - '.$jbt_pjb;
        // exit();
        // $pgw_cuti = $this->cuti->pgw_cuti($dt_cuti->NRK);
        // echo (date('Y', strtotime($dt_cuti->TMT))) - (date('Y', strtotime($dt_cuti->MUANG))); echo date('Y-m-d', strtotime($dt_cuti->MUANG)).'<br/>';
        // echo $this->tanggal_indo(date('Y-m', strtotime($dt_cuti->TMT)));
        // echo $dt_cuti->TMT; 
        // $thbl_cuti = date('F Y', strtotime($dt_cuti->TMT));
        // echo $date;

        
        // echo $tahun_kerja;
        $stat_cuti1='';
        $stat_cuti2='';
        $stat_cuti3='';
        $stat_cuti4='';
        $stat_cuti5='';
        $stat_cuti6='';

        if($jencuti==1){
            $stat_cuti1='V'; 
        }elseif ($jencuti==2) {
            $stat_cuti2='V'; 
        }elseif ($jencuti==3) {
            $stat_cuti3='V'; 
        }elseif ($jencuti==4) {
            $stat_cuti4='V'; 
        }elseif ($jencuti==5) {
            $stat_cuti5='V'; 
        }elseif ($jencuti==6) {
            $stat_cuti6='V'; 
        }
        // exit();

        $html = '


		<html>
		    <head>
		        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		        <meta http-equiv="Content-Style-Type" content="text/css" /> 
		        <meta name="generator" content="Aspose.Words for .NET 17.1.0.0" />
		        <title></title>
		    </head>
		    <body>
		    <table  border="0" cellpadding="1" width="100%" style="margin-top:0pt; margin-left:348px; margin-bottom:0pt; line-height:115%; font-size:8pt;font-family:Arial">
		        <tr>
		            <td width="50%"></td>
		            <td width="55%">
		            <table  border="0" cellpadding="1" width="100%" >
		                <tr>
		                    <td width="8%"></td>
		                    <td width="8%"></td>
		                    <td width="80%"><br>Jakarta, '.$this->tanggal_indo(date('Y-m-d', strtotime($dt_cuti->TMT))).'</td>
		                </tr>
		                <tr>
		                    <td width="8%"></td>
		                    <td width="90%" colspan="2">Kepada</td>
		                </tr>
		                <tr>
		                    <td width="8%">Yth. </td>
		                    <td width="90%" colspan="2">Kepala '.ucwords(strtolower($dt_cuti->NAMA_SPMU)).' Provinsi DKI Jakarta</td>
		                </tr>
		                <tr>
		                    <td width="8%"> </td>
		                    <td width="90%" colspan="2">c.q Kasubag Kepegawaian</td>
		                </tr>
		                 <tr>
		                    <td width="8%"> </td>
		                    <td width="90%" colspan="2">di <br>&nbsp;&nbsp;&nbsp;&nbsp; Jakarta</td>
		                </tr>
		            </table>
		            </td>
		        </tr>
		    </table>
		    
		                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:9pt"><span style="font-family:Arial; font-weight:bold">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</span></p>
		                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:9pt"><span style="font-family:Arial; font-weight:bold">Nomor : '.$dt_cuti->NOSK.'</span></p>

		               
		                        
		        <br>
		    	<br>
		        <table border="1" cellpadding="1" width="100%" style="font-size:8px">
		            <tbody>
		                <tr>
		                   <td colspan="6" style="height:15x">
		                        <b style="font-size:8px;margin-bottom:30%">I. DATA PEGAWAI</b>
		                    </td>
		                </tr>
		                <tr >
		                    <td width="15%">&nbsp; Nama</td>
		                    <td width="2%" align="center">:</td>
		                    <td width="40%">&nbsp; '.ucwords(strtolower($dt_cuti->NAMA_PGW)).'</td>
		                    <td width="15%">&nbsp; NIP</td>
		                    <td width="2%" align="center">:</td>
		                    <td width="26%">&nbsp; '.$dt_cuti->NIP18.'</td>
		                </tr>
		                <tr>
		                    <td width="15%">&nbsp; Jabatan</td>
		                    <td width="2%" align="center">:</td>
		                    <td width="40%">&nbsp; '.ucwords(strtolower($jab_pgw_cuti->NAJABL)).'</td>
		                    <td width="15%">&nbsp; Masa Kerja</td>
		                    <td width="2%" align="center">:</td>
		                    <td width="26%">&nbsp; '.$tahun_kerja.' Tahun</td> 
		                </tr>
		                <tr>
		                    <td width="15%">&nbsp; Unit Kerja</td>
		                    <td width="2%" align="center">:</td>
		                    <td colspan="6">&nbsp; '.ucwords(strtolower($dt_cuti->NAMA_SPMU)).'</td>
		                </tr>
		            </tbody>
		        </table>
		        <br>
		        <br>
		        <table border="1" cellpadding="1" width="100%" style="font-size:8px">
		            <tbody>
		                <tr>
		                    <td colspan="4" style="height:15x">
		                        <b style="font-size:8px;margin-bottom:30%">II. JENIS CUTI YANG DIAMBIL**</b>
		                    </td>
		                </tr>
		                <tr>
		                    <td width="40%">&nbsp; 1. Cuti Tahunan</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti1.'</td>
		                    <td width="40%">&nbsp; 2. Cuti Besar</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti2.'</td>
		                </tr>
		                <tr>
		                    <td width="40%">&nbsp; 3. Cuti Sakit</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti3.'</td>
		                    <td width="40%">&nbsp; 4. Cuti Melahirkan</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti4.'</td>
		                </tr>
		                <tr>
		                    <td width="40%">&nbsp; 5. Cuti Karena Alasan Penting</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti5.'</td>
		                    <td width="40%">&nbsp; 6. Cuti di Luar Tanggungan Negara</td>
		                    <td width="10%" align="center">&nbsp; '.$stat_cuti6.'</td>
		                </tr>
		            </tbody>
		        </table>

		     	<br> <br>
		        <table border="1" cellpadding="2" width="100%"  style="font-size:8px">
		            <tbody>
		                <tr>
		                    <td colspan="4" style="height:15x">
		                        <b style="font-size:8px;margin-bottom:30%">III. ALASAN CUTI</b>
		                    </td>
		                </tr>
		                   
		                <tr>
		                    <td width="100%">&nbsp; '.$dt_cuti->ALSN_CUTI.'</td>
		                </tr>
		            </tbody>
		        </table>
		    	<br> <br>
		         <table border="1" cellpadding="2" width="100%"  style="font-size:8px">
		            <tbody>
		                <tr>
		                    <td colspan="4" style="height:15x">
		                        <b style="font-size:8px;margin-bottom:30%">IV. LAMANYA CUTI</b>
		                    </td>
		                   
		                </tr>
		                <tr>
		                    <td width="10%">&nbsp; Selama</td>
		                    <td width="20%" align="center">&nbsp; '.$dt_cuti->TOTAL_CUTI.' hari</td>
		                    <td width="15%">&nbsp; Mulai tanggal </td>
		                    <td width="25%" align="center">&nbsp; '.$this->tanggal_indo(date('Y-m-d', strtotime($dt_cuti->TMT))).'</td>
		                    <td width="5%" align="center">&nbsp; s/d</td>
		                    <td width="25%" align="center">&nbsp; '.$this->tanggal_indo(date('Y-m-d', strtotime($dt_cuti->TGAKHIR))).'</td>
		                </tr>
		            </tbody>
		        </table>
		     	<br> <br>
		        <table border="1" cellpadding="2" width="100%"  style="font-size:8px">
		            <tbody> 
		                <tr>
		                    <td colspan="4" style="height:15x">
		                        <b style="font-size:8px;margin-bottom:30%">V. CATATAN CUTI</b>
		                    </td>
		                </tr>
		                <tr>
		                    <td width="35%" colspan="3">&nbsp; 1. Cuti Tahunan</td>
		                    <td width="45%">&nbsp; 2. CUTI BESAR</td>
		                    <td width="20%"></td>
		                </tr>
		                <tr>
		                    <td width="10%" align="center">Tahun</td>
		                    <td width="10%" align="center">Jumlah</td>
		                    <td width="15%" align="center">Keterangan</td>
		                    <td width="45%">&nbsp; 3. CUTI SAKIT</td>
		                    <td width="20%"></td>
		                </tr>
		                <tr>
		                    <td width="10%" align="center">N-2</td>
		                    <td width="10%" align="center">'.$dt_cuti->CUTI_N_2.'</td>
		                    <td width="15%" align="center"></td>
		                    <td width="45%">&nbsp; 4. CUTI MELAHIRKAN</td>
		                    <td width="20%"></td>
		                </tr>
		                <tr>
		                    <td width="10%" align="center">N-1</td>
		                    <td width="10%" align="center">'.$dt_cuti->CUTI_N_1.'</td>
		                    <td width="15%" align="center"></td>
		                    <td width="45%">&nbsp; 5. CUTI KARENA ALASAN PENTING</td>
		                    <td width="20%"></td>
		                </tr>
		                <tr>
		                    <td width="10%" align="center">N</td>
		                    <td width="10%" align="center">'.$dt_cuti->CUTI_N.'</td>
		                    <td width="15%" align="center"></td>
		                    <td width="45%">&nbsp; 6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
		                    <td width="20%"></td>
		                </tr>
		            </tbody>
		        </table>
			 	<br> <br>
			    <table border="1" cellpadding="2" width="100%"  style="font-size:8px">
			        <tbody>
			            <tr>
			                <td colspan="4" style="height:15x">
			                    <b style="font-size:8px;margin-bottom:30%">VI. ALAMAT SELAMA MENJALANKAN CUTI</b>
			                </td>
			            </tr>
			            <tr>
			                <td width="50%"></td>
			                <td width="50%">&nbsp; Telepon :   '.$dt_cuti->TELP_CUTI.'</td>
			            </tr>
			            <tr>
			                <td width="50%"  >
			                    '.$dt_cuti->ALMT_CUTI.'
			                    
			                </td>
			                <td width="50%"  align="center">
			                    Hormat Saya,<br/><br/><br/>
			                    '.$dt_cuti->NAMA_PGW.'<br/>
			                    NIP '.$dt_cuti->NIP18.'
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br> <br>
			 	<table border="1" cellpadding="1" width="100%"  style="font-size:8px">
			        <tbody>
			            <tr>
			             <td colspan="4" style="height:15x">
			                    <b style="font-size:8px;margin-bottom:30%">VII. PERTIMBANGAN ATASAN LANGSUNG**</b>
			                </td>
			            </tr>
			            <tr>
			                <td width="25%" align="center">DISETUJUI</td>
			                <td width="25%" align="center">PERUBAHAN****</td>
			                <td width="25%" align="center">DITANGGUHKAN****</td>
			                <td width="25%" align="center">TIDAK DI SETUJUI****</td>
			            </tr>
			            <tr>
			                <td width="25%" align="center" style="font-size:8px;vertical-align: top;">'.$sts_stj_atasan.'</td>
			                <td width="25%" align="center"></td>
			                <td width="25%" align="center" style="font-size:8px">'.$sts_tgh_atasan.'</td>
			                <td width="25%" align="center"></td>
			            </tr>
			        </tbody>
			    </table>
			    <table cellpadding="2" width="100%" align="right" style="width: 100px;">
			        <tbody>
			            <tr>
			                <td width="25%"></td>
			                <td width="25%"></td>
			                <td width="25%"></td>
			                <td width="25%" align="center" style="font-size:8px;vertical-align: top;border:1px solid black">
			                    '.ucwords(strtolower($jbt_ats)).'<br/> <br/> 


			                    '.ucwords(strtolower($nm_ats)).'<br/> 
			                    '.ucwords(strtolower($nip_ats)).'
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br> <br>
			 	<table border="1" cellpadding="1" width="100%"  style="font-size:8px">
			        <tbody>
			            <tr>
			            <td colspan="4" style="height:15x">
			                <b style="font-size:8px;margin-bottom:30%">VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</b>
			            </td>
			               
			            </tr>
			            <tr>
			                <td width="25%" align="center">DISETUJUI</td>
			                <td width="25%" align="center">PERUBAHAN****</td>
			                <td width="25%" align="center">DITANGGUHKAN****</td>
			                <td width="25%" align="center">TIDAK DI SETUJUI****</td>
			            </tr>
			            <tr>
			                <td width="25%" align="center" style="font-size:8px;vertical-align: top;height:14px">'.$sts_stj_pejabat.'</td>
			                <td width="25%" align="center"></td>
			                <td width="25%" align="center" style="font-size:8px">'.$sts_tgh_pejabat.'</td>
			                <td width="25%" align="center"></td>
			            </tr>
			        </tbody>
			    </table>
			    <table cellpadding="2" width="100%" align="right" style="width: 100px;">
			        <tbody>
			            <tr>
			                <td width="25%"  ></td>
			                <td width="25%"  ></td>
			                <td width="25%" ></td>
			                <td width="25%" align="center" style="font-size:8px" style="border:1px solid black">
		                     	'.ucwords(strtolower($jbt_pjb)).'<br/> <br/> 


			                    '.ucwords(strtolower($nm_pjb)).'<br/>
			                    '.ucwords(strtolower($nip_pjb)).'
			                </td>
			            </tr>
			        </tbody>
			    </table>

			 	
		        
			                
			</body>
		</html>';
		// <p style="font-size: 7pt">
  //           Catatan:<br/>
  //           * &nbsp;&nbsp;&nbsp;&nbsp;Coret yang tidak perlu<br/>
  //           **   &nbsp;&nbsp; Pilih salah satu dengan memberi tanda centang (V)<br/>
  //           ***  &nbsp;diisi oleh Pejabat yang menangani bidang kepewawaian sebelum PNS mengajukan cuti<br/>
  //           **** diberi tanda centang dan alasannya.<br/>
  //           n &nbsp;&nbsp;   = Cuti tahun berjalan<br/>
  //           n-1 = Sisa cuti 1 tahun sebelumnya<br/>
  //           n-2 = Sisa cuti 2 tahun sebelumnya
  //       </p>
        $pdf_cuti->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf_cuti->Output('Cuti Tahunan.pdf', 'I');
    }

    public function tanggal_indo($tanggal, $cetak_hari = false)
    {
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }

    public function sk_cuti_tahunan2($id_hist,$jencuti){
        // echo $id_hist.' c2 '.$jencuti;exit();
        $this->load->library('pdf_cuti');

        // if (isset($_POST['nrk'])) {
        //     $nrk = $_POST['nrk'];
        // } elseif (isset($_POST['nrkP'])) {
        //     //Pencarian NRK Untuk Admin/BKD
        //     $nrk = $_POST['nrkP'];
        // } else {
        //     $nrk = $this->user['id'];

        //     if ($this->user['user_group'] > 1) {
        //         $nrk = "";
        //     }
        // }

        

        // $data['nrk'] = $nrk;
        // $datam['nrk'] = $nrk;
        // $datam['user_group'] = $this->user['user_group'];
        // $data['user_id'] = $this->user['id'];
        // $data['user_group'] = $this->user['user_group'];

        // $infoGaji = $this->listing->queryBatchingGajiPerPegawai($nrkparam, $thbl);

        // $data['infoGaji'] = $infoGaji;

        // $dt_cuti = $this->cuti->data_cuti($id_hist);
        // $pgw_cuti = $this->cuti->pgw_cuti($dt_cuti->NRK);
        // echo $pgw_cuti->NAMA; echo $pgw_cuti->NIP18; exit();


        ob_start();

        // $this->pdf->SetTitle('' . $infoGaji->NRK . ' ' . $infoGaji->BULAN . ' ' . $infoGaji->TAHUN);

        // $this->pdf->SetTitle('Cuti Tahunan');
        // definisikan judul dokumen

        // $this->pdf_cuti->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // set header and footer fonts
        $this->pdf_cuti->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf_cuti->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->pdf_cuti->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->pdf_cuti->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-25, PDF_MARGIN_RIGHT);
        $this->pdf_cuti->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf_cuti->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $this->pdf_cuti->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->pdf_cuti->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once dirname(__FILE__) . '/lang/eng.php';
            $pdf_cuti->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $this->pdf_cuti->SetFont('helvetica', '', 8);

        // add a page
        $this->pdf_cuti->AddPage();

        $this->pdf_cuti->Cell(0, 0, '', 2, 1, 'C', 0, '', 0);

        $html = '


                <html>
                    <head>
                        <title></title>
                    </head>
                    <body>
                        <div>
                            <table border="0" cellpadding="1" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="50%"></td>
                                        <td width="50%">
                                            <p>Jakarta, September 2018<br/>
                                            Kepada<br/>
                                            Yth. Plt. Kepala Dinas Komunikasi, Informatika dan Statistik Provinsi DKI Jakarta<br/>
                                            c.q Kasubag Kepegawaian<br/>
                                            di<br/>
                                            Jakarta</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="center">
                                            <h3>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>
                                        </td>
                                    </tr>
                                 
                                </tbody>
                            </table>    
                        </div>
                        
                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="100%" colspan="6">
                                            <h3>I. DATA PEGAWAI</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama</td>
                                        <td width="2%" align="center">:</td>
                                        <td width="40%">tes</td>
                                        <td width="15%">NIP</td>
                                        <td width="2%" align="center">:</td>
                                        <td width="26%">nip</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jabatan</td>
                                        <td width="2%" align="center">:</td>
                                        <td width="40%">Staff</td>
                                        <td width="15%">Masa Kerja</td>
                                        <td width="2%" align="center">:</td>
                                        <td width="26%">13 (tigabelas) tahun</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Unit Kerja</td>
                                        <td width="2%" align="center">:</td>
                                        <td colspan="6">Dinas Komunikasi, Informatika dan Statistik Provinsi DKI Jakarta</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h3>II. JENIS CUTI YANG DIAMBIL**</h3>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="35%">1. Cuti Tahunan</td>
                                        <td width="15%" align="center">V</td>
                                        <td width="35%">2. Cuti Besar</td>
                                        <td width="15%"></td>
                                    </tr>
                                    <tr>
                                        <td width="35%">3. Cuti Sakit</td>
                                        <td width="15%" align="center"></td>
                                        <td width="35%">4. Cuti Melahirkan</td>
                                        <td width="15%"></td>
                                    </tr>
                                    <tr>
                                        <td width="35%">5. Cuti Karena Alasan Penting</td>
                                        <td width="15%" align="center"></td>
                                        <td width="35%">6. Cuti di Luar Tanggungan Negara</td>
                                        <td width="15%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="100%">
                                            <h3>III. ALASAN CUTI</h3>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="100%">Sakit</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="100%" colspan="6">
                                            <h3>IV. LAMANYA CUTI</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Selama</td>
                                        <td width="20%" align="center">1 (satu) hari</td>
                                        <td width="15%">Mulai tanggal </td>
                                        <td width="25%" align="center">03 September 2018</td>
                                        <td width="5%" align="center">s/d</td>
                                        <td width="25%" align="center">03 September 2018</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <h3>V. CATATAN CUTI</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" colspan="3">1. Cuti Tahunan</td>
                                        <td width="45%">2. CUTI BESAR</td>
                                        <td width="20%"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" align="center">Tahun</td>
                                        <td width="10%" align="center">Sisa</td>
                                        <td width="15%" align="center">Keterangan</td>
                                        <td width="45%">3. CUTI SAKIT</td>
                                        <td width="20%"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" align="center">N-2</td>
                                        <td width="10%" align="center"></td>
                                        <td width="15%" align="center"></td>
                                        <td width="45%">4. CUTI MELAHIRKAN</td>
                                        <td width="20%"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" align="center">N-1</td>
                                        <td width="10%" align="center"></td>
                                        <td width="15%" align="center"></td>
                                        <td width="45%">5. CUTI KARENA ALASAN PENTING</td>
                                        <td width="20%"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" align="center">N</td>
                                        <td width="10%" align="center"></td>
                                        <td width="15%" align="center"></td>
                                        <td width="45%">6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
                                        <td width="20%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <h3>VI. ALAMAT SELAMA MENJALANKAN CUTI</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%"></td>
                                        <td width="50%">Telepon :   08129525693</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            Jalan Kavling Setiabudi No.29 RT04/04<br/> 
                                            Kelurahan Cipadu<br/>
                                            Kecamatan Larangan<br/>
                                            Kota Tangerang<br/>
                                            Banten, Indonesia.
                                            
                                        </td>
                                        <td width="50%" rowspan="5" align="center">
                                            Hormat Saya,<br/><br/><br/>
                                            Sri Wahyuni<br/>
                                            NIP 197506262006042041
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br/><br/><br/><br/><br/><br/><br/><br/><br/> 

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h3>VII. PERTIMBANGAN ATASAN LANGSUNG**</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="center">DISETUJUI</td>
                                        <td width="25%" align="center">PERUBAHAN****</td>
                                        <td width="25%" align="center">DITANGGUHKAN****</td>
                                        <td width="25%" align="center">TIDAK DI SETUJUI****</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="1" cellpadding="2" width="100%" align="right" style="width: 100px;">
                                <tbody>
                                    <tr>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%" align="center">
                                            Kepala Seksi SIM PKM,<br/><br/><br/>


                                            Rachmat Setiawan<br/>
                                            NIP 198102022006041009
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="1" cellpadding="2" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h3>VII. KEPUTUSAN PEJABAT YANG BERWENANG MEBERIKAN CUTI**</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="center">DISETUJUI</td>
                                        <td width="25%" align="center">PERUBAHAN****</td>
                                        <td width="25%" align="center">DITANGGUHKAN****</td>
                                        <td width="25%" align="center">TIDAK DI SETUJUI****</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                        <td width="25%" align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="1" cellpadding="2" width="100%" align="right" style="width: 100px;">
                                <tbody>
                                    <tr>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%" align="center">
                                            Sekretaris Dinas Kominfotik,<br/><br/><br/>


                                            Netti Herawati<br/>
                                            NIP 196810241993032004
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table border="0" cellpadding="1" width="100%">
                                <tbody>
                                    <tr>
                                        
                                        <td width="50%">
                                            <p style="font-size: 90%;">
                                                Catatan:<br/>
                                                *     Coret yang tidak perlu<br/>
                                                **    Pilih salah satu dengan memberi tanda centang V)<br/>
                                                ***  diisi oleh Pejabat yang menangani bidang kepewawaian sebelum PNS mengajukan cuti<br/>
                                                **** diberi tanda centang dan alasannya.<br/>
                                                n    = Cuti tahun berjalan<br/>
                                                n-1 = Sisa cuti 1 tahun sebelumnya<br/>
                                                n-2 = Sisa cuti 2 tahun sebelumnya
                                            </p>
                                        </td>
                                        <td width="50%"></td>
                                    </tr>
                                </tbody>
                            </table>    
                        </div>

                    </body>
                 </html>';

        // $html = '<html>
        //             <head>
        //                 <title></title>
        //             </head>
        //             <body>
        //                 <h3 align="center">CUTI TAHUNAN</h3>
        //                 <table border="0" cellpadding="1" cellspacing="1" width="40%">
        //                     <tbody>
        //                         <tr>
        //                             <td width="20%"><strong>BULAN:</strong></td>
        //                             <td width="20%"><strong>TAHUN:</strong></td>
        //                         </tr>
        //                         <tr>
        //                             <td><strong>SKPD:</strong></td>
        //                         </tr>
        //                         <tr>
        //                             <td><strong>UKPD:</strong></td>
        //                         </tr>
        //                     </tbody>
        //                 </table>
                        
        //             </body>
        //         </html>
        // ';

        // $html = '<html>
                    
        //             <body>
        //                 <h3 align="center">CUTI TAHUNAN</h3>
                        
                        
        //             </body>
        //         </html>
        // ';

        // $url = 'http:pegawai.jakarta.go.id/validasi/qr_gajipegawai?nrk=' . $nrkparam . '&thbl=' . $thbl;
        // $style = array(
        //     'border' => 2,
        //     'vpadding' => 'auto',
        //     'hpadding' => 'auto',
        //     'fgcolor' => array(0, 0, 0),
        //     'bgcolor' => false, //array(255,255,255)
        //     'module_width' => 1, // width of a single module in points
        //     'module_height' => 1, // height of a single module in points
        // );

        $this->pdf_cuti->writeHTML($html, true, false, true, false, '');
        // $this->pdf_cuti->writeHTML('tes', true, false, true, false, '');
        // $this->pdf->writeHTML('Contoh Laporan PDF dengan CodeIgniter + tcpdf', true, false, true, false, '');
        // $this->pdf->write2DBarcode($url, 'QRCODE,H', 20, 110, 20, 20, $style, 'N');
        // $this->pdf->Text(20, 205, 'QRCODE H');
        ob_clean();

        $this->pdf_cuti->Output('Cuti Tahunan.pdf', 'I');

    } 



    // ================== akses user bkd kesra ==============================
    public function cuti_bkd()
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
        // $data['cek_pyb'] = $this->cuti->cek_pyb($nrk,$kolok_kojab->KOLOK,$kolok_kojab->KOJAB);

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        // $thbl = '201803'; //sementara
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);
        // $data['cek_bawahan'] = $this->cuti->count_getStrukturPegawai($nrk);
                 

        $data['nrk'] = $nrk;
        $datam['nrk'] = $nrk;
        $datam['user_group'] = $this->user['user_group'];
        // $data['user_id'] = $this->user['id'];
        // $data['user_group'] = $this->user['user_group'];

        // $data['atasan'] = $this->cuti->atasan_cuti($nrk);
        // $data['kolok_plt_plh'] = $this->cuti->kolok_plt_plh($nrk);

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
        
        
        $datam['activemn'] = $this->infopegawai->initialMenu($this->user['user_group'],'cuti_saya',0);
        $datam['inisial'] = 'cuti_saya';

        $menuid='30312';  
        $cekaksesmenu = $this->infopegawai->cekaksesmenu($menuid,$this->user['user_group']);

        // echo $cekaksesmenu;exit();

        if($cekaksesmenu == '1')
        {
                $this->load->view('head/header',$this->user);
                $this->load->view('head/menu',$datam);
                $this->load->view('cuti_bkd',$data);
                $this->load->view('head/footer');   
        }
        else
        {
            $this->load->view('403');
        }

    }



    public function data_cuti_pimpinan()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pimpinan($nrk);
    }

    public function data_cuti_pimpinan_sudah_validasi()
    {
        
        $nrk = $this->user['id'];

        $tahun = date('Y');
        // $thbl = date('Ym'); //real
        $thbl = '201803'; //sementara
        // echo $thbl;exit();

        // $count_bawahan = $this->cuti->count_getStrukturPegawai($nrk,$tahun,$thbl);

        $this->cuti->get_data_cuti_pimpinan_sudah_validasi($nrk);
    }


    // public function save_verif_perubahan_pimpinan_old(){
    //     $user = $this->user['id'];
    //     $id_hist = $this->input->post('id_hist');
    //     $jencuti = $this->input->post('jencuti');
    //     $ket = $this->input->post('ket');
    //     // $base64_file = $this->input->post('base64');


    //     // $data = base64_decode($base64_file);
    //     // file_get_contents('./public/file_cuti/image.png', $data);
        
    //     exit();

    //     $id_status_baru = 2;

    //     $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
    //     $update = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN,$base64_file);
    //     // $update = $this->cuti->update_cuti_tahunan($id_hist,$jencuti,$ket,$id_status_baru,$user);

    //     if($update){
    //         echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
    //     }else{
    //         echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
    //     }
        
    // }

    public function save_verif_perubahan_pimpinan(){
        

        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist_verif_perubahan');
        $jencuti = $this->input->post('jencuti_verif_perubahan');
        $ket = $this->input->post('ket_verif_perubahan');

        $gambar = $this->input->post('gambar_verif_perubahan');

        $data_cuti = $this->cuti->get_cuti_exist($id_hist);
        $nrk_pgw = $data_cuti->NRK;

        if($id_hist ==''){
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($jencuti =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($ket =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Keterangan tidak boleh kosong'));
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $date  = date('Y-m-d');
            $time  = date('H-i-s');

            // ECHO 'upload_file_pegawai/'.$nrk.'/KATEGORI/'.$kategori;

            if(!file_exists('public/file_cuti/'.$nrk_pgw)){
                mkdir('public/file_cuti/'.$nrk_pgw, 0777, true);
            }

            $config = array(
                   'allowed_types' => '*',
                   'upload_path' => realpath('./public/file_cuti/'.$nrk_pgw.'/'),
                   'max_size' => 5000000000000,
                   'file_name' => $nrk_pgw.'_'.$date.'_'.$time
               );

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $file = $this->upload->file_name;

            if($this->upload->do_upload('gambar_verif_perubahan'))
            {
                $file1  = $this->upload->data();
                $file2  = $file1['file_name'];
                $gambar = $file2;
            }

            $location_file = 'public/file_cuti/'.$nrk_pgw.'/'.$gambar;
            // echo $location_file;exit();

            if($gambar == ''){
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Nota dinas belum dipilih'));
            }else{
                $id_status_baru = 2;

                $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
                $update = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN,$location_file);

                if($update){
                    echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
                }else{
                    echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
                }
                
            }
        }
     
	}


	public function save_verif_ditangguhkan_pimpinan(){
        

        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist_verif_ditangguhkan');
        $jencuti = $this->input->post('jencuti_verif_ditangguhkan');
        $ket = $this->input->post('ket_verif_ditangguhkan');

        $gambar = $this->input->post('gambar_verif_ditangguhkan');


        // echo $gambar.' ket: '.$ket;

        $data_cuti = $this->cuti->get_cuti_exist($id_hist);
        $nrk_pgw = $data_cuti->NRK;

        if($id_hist ==''){
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($jencuti =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($ket =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Keterangan tidak boleh kosong'));
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $date  = date('Y-m-d');
            $time  = date('H-i-s');

            // ECHO 'upload_file_pegawai/'.$nrk.'/KATEGORI/'.$kategori;

            if(!file_exists('public/file_cuti/'.$nrk_pgw)){
                mkdir('public/file_cuti/'.$nrk_pgw, 0777, true);
            }

            $config = array(
                   'allowed_types' => '*',
                   'upload_path' => realpath('./public/file_cuti/'.$nrk_pgw.'/'),
                   'max_size' => 5000000000000,
                   'file_name' => $nrk_pgw.'_'.$date.'_'.$time
               );

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $file = $this->upload->file_name;

            if($this->upload->do_upload('gambar_verif_ditangguhkan'))
            {
                $file1  = $this->upload->data();
                $file2  = $file1['file_name'];
                $gambar = $file2;
            }

            $location_file = 'public/file_cuti/'.$nrk_pgw.'/'.$gambar;
            // echo $location_file;exit();

            if($gambar == ''){
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Nota dinas belum dipilih'));
            }else{
                $id_status_baru = 3;

                $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
                $update = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN,$location_file);

                #untuk input data pejabat pada cuti pimpinan
                $id_status_baru_pjb = 10;
                $update2 = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru_pjb,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN);

                if($update2){
                    echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
                }else{
                    echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
                }
                
            }
        }
     
	}

    public function save_verif_setujui_atasan_pimpinan(){
        

        $user = $this->user['id'];
        $id_hist = $this->input->post('id_hist_verif_setujui_atasan');
        $jencuti = $this->input->post('jencuti_verif_setujui_atasan');
        $ket = $this->input->post('ket_verif_setujui_atasan');

        $gambar = $this->input->post('gambar_verif_setujui_atasan');


        // echo $gambar.' ket: '.$ket;

        $data_cuti = $this->cuti->get_cuti_exist($id_hist);
        $nrk_pgw = $data_cuti->NRK;

        if($id_hist ==''){
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($jencuti =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
        }elseif ($ket =='') {
            echo json_encode(array("respone" => 'GAGAL','pesan' => 'Keterangan tidak boleh kosong'));
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $date  = date('Y-m-d');
            $time  = date('H-i-s');

            // ECHO 'upload_file_pegawai/'.$nrk.'/KATEGORI/'.$kategori;

            if(!file_exists('public/file_cuti/'.$nrk_pgw)){
                mkdir('public/file_cuti/'.$nrk_pgw, 0777, true);
            }

            $config = array(
                   'allowed_types' => '*',
                   'upload_path' => realpath('./public/file_cuti/'.$nrk_pgw.'/'),
                   'max_size' => 5000000000000,
                   'file_name' => $nrk_pgw.'_'.$date.'_'.$time
               );

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $file = $this->upload->file_name;

            if($this->upload->do_upload('gambar_verif_setujui_atasan'))
            {
                $file1  = $this->upload->data();
                $file2  = $file1['file_name'];
                $gambar = $file2;
            }

            $location_file = 'public/file_cuti/'.$nrk_pgw.'/'.$gambar;
            // echo $location_file;exit();

            if($gambar == ''){
                echo json_encode(array("respone" => 'GAGAL','pesan' => 'Nota dinas belum dipilih'));
            }else{
                $id_status_baru = 4;

                $cuti_exist = $this->cuti->get_cuti_exist($id_hist);
                $update = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN,$location_file);

                #untuk input data pejabat pada cuti pimpinan
                $id_status_baru_pjb = 5;
                $update2 = $this->cuti->update_cuti_tahunan_pimpinan($id_hist,$jencuti,$ket,$id_status_baru_pjb,$user,$cuti_exist->NRK_ATASAN,$cuti_exist->KOLOK_ATASAN,$cuti_exist->KOJAB_ATASAN,$cuti_exist->STATUS_ATASAN);

                if($update2){
                    echo json_encode(array("respone" => 'SUKSES','pesan' => 'Proses berhasil'));
                }else{
                    echo json_encode(array("respone" => 'GAGAL','pesan' => 'Proses gagal'));
                }
                
            }
        }
     
    }


    // ================== akses user bkd kesra ==============================
    
            		
}
?>            
