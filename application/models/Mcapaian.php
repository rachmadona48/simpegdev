<?php 

 class Mcapaian extends CI_Model {

    private $ci;
    private $ekin;

    // private $ci;
    // private $ekin;

    function __construct()
    {        
        $this->ci =& get_instance();
        $this->ci->load->database(); 
        $this->ci->load->library('session'); 
        

        //$this->ekin = $this->ci->load->database('ekin234', TRUE);
        $this->ekine = $this->ci->load->database('ekinerja', TRUE);
        $this->ekine16 = $this->ci->load->database('ekinerja16', TRUE);
        $this->etkd = $this->ci->load->database('etkd', TRUE);   
    }
    
    public function getDataPegawai($intBln,$user_id,$tahun){//new buatan Erwin
        $sql = "select p.nrk, p.nip18, p.nama, p.kolok_" . $intBln . " kolok, p.kojab_" . $intBln . " kojab, p.eselon_" . $intBln . " eselon,
                p.spmu_" . $intBln . " spmu, lok.nalokl, p.stapeg_" . $intBln . " stapeg
                from pegawai_new p
                left join pers_lokasi_tbl lok ON p.kolok_" . $intBln . " = lok.kolok
                where p.nrk='" . $user_id . "' and p.tahun = '" . $tahun . "'";
        
        if (intval($tahun) > 2015) {
            $db = $this->ekine16;     
        }else{
            $db = $this->ekine;     
        }  
        
        $query = $db->query($sql);

        $result = $query->row();
              

        return $result;
    }
    
    public function getDataJabatan($kolok,$kojab,$tahun){//new buatan Erwin
        $sql = "SELECT najabl FROM pers_kojab_tbl WHERE kolok = '" . $kolok . "' AND kojab = '" . $kojab . "'";
        
        if (intval($tahun) > 2015) {
            $db = $this->ekine16;     
        }else{
            $db = $this->ekine;     
        }  
        
        $query = $db->query($sql);
        $result = $query->row();
        $jabatan = "";
        
        if(isset($result)){
            $jabatan = $result->najabl;
        } else {
            $sql = "SELECT najabl FROM pers_kojabf_tbl WHERE kojab = '" . $kojab . "'";
            $query = $db->query($sql);
            $result = $query->row();
            if(isset($result)){
                $jabatan = $result->najabl;
            }
            
        }
              

        return $jabatan;
    }
    
    public function getDataAktifitas($tanggal_start,$tanggal_end,$nrk,$tahun){//new buatan Erwin
        $sql = "SELECT a.id, a.tanggal, a.kode_aktifitas, a.kode_kegiatan, a.keterangan, a.volume, a.status, b.waktu, b.status_aktif, a.jam_mulai,
                a.menit_mulai, a.jam_selesai, a.menit_selesai, a.note
                FROM isi_aktifitas a
                INNER JOIN ref_master_aktifitas b ON a.kode_aktifitas = b.kode_aktifitas
                WHERE a.tanggal BETWEEN '" . $tanggal_start . "' AND '" . $tanggal_end . "' AND a.nrk = '" . $nrk . "'";
        
        if (intval($tahun) > 2015) {
            $db = $this->ekine16;     
        }else{
            $db = $this->ekine;     
        }  
        
        $query = $db->query($sql);
        $result = $query;
        
        return $result;
    }
    
    public function getAlpaSetengah($rekaptelat, $nrk, $thbl){//new buatan Erwin
        $jlh = 0;
        $rekap = $rekaptelat;
        
        $sql = "SELECT count(*) jumlah FROM alpasetengah WHERE userid = '" . $nrk . "' AND to_char(rosterdate,'yyyymm') = '" . $thbl . "'  AND rosterdate <= now()";
    
        $db = $this->etkd;
        $query = $db->query($sql);
        $r = $query->row();
        
        if (isset($r)) {
            $jlh = $r->jumlah;
        }

        //POTONG REKAP TERLAMBAT - CEPAT PULANG
        $rekap = (($rekaptelat - ($jlh * 225)) + ($jlh * 150));

        return $rekap;
    }
    
    public function getAbsensi($nrk, $thbl){//new buatan Erwin
        $capaian = 0;
        $batasmax = 0;
        
        $sql = "SELECT sakit, alpa, ijin, late, early, ct, cb, cltn, cbs, cbs3, tb, cs, cap, dlp, dlaw,
            dlak, mn, ttp, ph, dk, pd, mpp, cap5, ttp, mpp, ijset, ctu
            FROM etkd WHERE userid = '" . $nrk . "' AND thbl = '" . $thbl . "'";
        
        $db = $this->etkd;
        $query = $db->query($sql);
        $r = $query->row();
        if(isset($r)){
            $totalsakit = 0;
            $sakit = intval($r->sakit);
            if ($sakit > 0) {
                $totalsakit = $sakit * 300;
                $batasmax += $totalsakit;
            }

            $totalalpa = 0;
            $alpa = intval($r->alpa);
            if ($alpa > 0) {
                $totalalpa = $alpa * 600;
                $batasmax += $totalalpa;
            }

            $totalijin = 0;
            $ijin = intval($r->ijin);
            if ($ijin > 0) {
                $totalijin = $ijin * 300;
                $batasmax += $totalijin;
            }

            $totalcsplus = 0;
            $totalcsminus = 0;
            $cs = intval($r->cs); //cuti sakit
            if ($cs > 0) {
                $totalcsminus = $cs * 240;
                $batasmax += $totalcsminus;

                $totalcsplus = $cs * 60;
                $capaian += $totalcsplus;
            }

            $totalcbsplus = 0;
            $totalcbsminus = 0;
            $cbs = intval($r->cbs); //cuti bersalin 1 & 2
            if ($cbs > 0) {
                $totalcbsplus = $cbs * 150;
                $capaian += $totalcbsplus;

                $totalcbsminus = $cbs * 150;
                $batasmax += $totalcbsminus;
            }

            $totalcbs3 = 0;
            $cbs3 = intval($r->cbs3); //cuti bersalin anak ke3
            if ($cbs3 > 0) {
                $totalcbs3 = $cbs3 * 300;
                $batasmax += $totalcbs3;
            }


            $totalcap = 0;
            $cap = intval($r->cap); //cuti alasan penting (<= 5 hari)
            if ($cap > 0) {
                $totalcap = $cap * 300;
                $capaian += $totalcap;
            }

            $totalcap5 = 0;
            $cap5 = intval($r->cap5); //cuti alasan penting (> 5 hari)
            if ($cap5 > 0) {
                $totalcap5 = $cap5 * 300;
                $batasmax += $totalcap5;
            }

            $totallateearky = 0;
            $tempalpasetengah = 0;
            $late = intval($r->late); //terlambat
            $early = intval($r->early); //pulang cepat
            if ($late > 0 || $early > 0) {
                $totallateearky = $late + $early;

                //GET ALPASETENGAH
                $tempalpasetengah = $this->getAlpaSetengah($totallateearky, $nrk, $thbl);

                if ($tempalpasetengah <= 0) {
                    $tempalpasetengah = 0;
                }

                $batasmax += $tempalpasetengah;
            }

            $totalct = 0;
            $ct = intval($r->ct); //cuti tahunan
            if ($ct > 0) {
                $totalct = $ct * 300;
                $capaian += $totalct;
            }

            $totalctu = 0;
            $ctu = intval($r->ctu); //cuti tunda
            if ($ctu > 0) {
                $totalctu = $ctu * 300;
                $capaian += $totalctu;
            }

            $totalph = 0;
            $ph = intval($r->ph); //petugas haji
            if ($ph > 0) {
                $totalph = $ph * 300;
                $capaian += $totalph;
            }

            $totaldk = 0;
            $dk = intval($r->dk); //diklat
            if ($dk > 0) {
                $totaldk = $dk * 300;
                $capaian += $totaldk;
            }

            $totalpd = 0;
            $pd = intval($r->pd); //perjalanan dinas
            if ($pd > 0) {
                $totalpd = $pd * 300;
                $capaian += $totalpd;
            }

            /* Start Tambahan Batas Max */
            $totaltitipan = 0;
            $titip = intval($r->ttp); //titipan
            if ($titip > 0) {
                $totaltitipan = $titip * 300;
                $batasmax += $totaltitipan;
            }

            $totalbantu = 0;
            $bantu = 0; //diperbantukan
            if ($bantu > 0) {
                $totalbantu = $bantu * 300;
                $batasmax += $totalbantu;
            }

            $totaltubel = 0;
            $tubel = intval($r->tb); //tubel
            if ($tubel > 0) {
                $totaltubel = $tubel * 300;
                $batasmax += $totaltubel;
            }

            $totaldpp = 0;
            $dpp = 0; //dpp
            if ($dpp > 0) {
                $totaldpp = $dpp * 300;
                $batasmax += $totaldpp;
            }

            $totalmpp = 0;
            $mpp = intval($r->mpp); //mpp
            if ($mpp > 0) {
                $totalmpp = $mpp * 300;
                $batasmax += $totalmpp;
            }

            $totalcb = 0;
            $cb = intval($r->cb); //Cuti Besar
            if ($cb > 0) {
                $totalcb = $cb * 300;
                $batasmax += $totalcb;
            }

            $totalcltn = 0;
            $cltn = intval($r->cltn); //Cuti Luar Tanggungan Negara
            if ($cltn > 0) {
                $totalcltn = $cltn * 300;
                $batasmax += $totalcltn;
            }

            $totalizinset = 0;
            $ijset = intval($r->ijset); //Cuti Luar Tanggungan Negara
            if ($ijset > 0) {
                $totalizinset = $ijset * 150;
                $batasmax += $totalizinset;
            }

            $totalmeninggal = 0;
            $meninggal = intval($r->mn); //Meninggal
            if ($meninggal > 0) {
                $totalmeninggal = $meninggal * 300;
                $batasmax += $totalmeninggal;
            }
            
            /* ============= */
            $tablecapaian = '<table class="table table-striped table-hover table_kpi" width="100%">';
            $tablecapaian .= '<thead>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<th>No. </th><th>Jenis Absensi</th><th>Jumlah Hari</th><th>Menit Penambah</th><th>Total Waktu Efektif</th><th>Input Aktifitas</th>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</thead>';
            $tablecapaian .= '<tbody>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>1. </td><td>Cuti Sakit</td><td><a>' . $cs . ' hari</a></td><td>60 menit</td><td>' . number_format($totalcsplus, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';

            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>2. </td><td>Cuti Alasan Penting < 6 hari</td><td><a>' . $cap . ' hari</a> </td><td>300 menit</td><td>' . number_format($totalcap, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';

            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>3. </td><td>Cuti Persalinan 1 & 2</td><td><a>' . $cbs . ' hari</a></td><td>150 menit</td><td>' . number_format($totalcbsplus, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>4. </td><td>Cuti Tahunan</td><td><a>' . $ct . ' hari</a></td><td>300 menit</td><td>' . number_format($totalct, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>5. </td><td>Diklat</td><td><a>' . $dk . ' hari</a></td><td>300 menit</td><td>' . number_format($totaldk, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>6. </td><td>Perjalanan Dinas (SPD)</td><td><a >' . $pd . ' hari</a></td><td>300 menit</td><td>' . number_format($totalpd, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>7. </td><td>Petugas Haji</td><td><a >' . $ph . ' hari</a></td><td>300 menit</td><td>' . number_format($totalph, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td>8. </td><td>Cuti Tunda</td><td><a>' . $ctu . ' hari</a></td><td>300 menit</td><td>' . number_format($totalctu, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</tbody>';
            $tablecapaian .= '</tfoot>';
            $tablecapaian .= '<tr>';
            $tablecapaian .= '<td colspan="4"><b>TOTAL </b></td><td><b>' . number_format($capaian, 0, ",", ".") . ' menit</b></td><td>&nbsp;</td>';
            $tablecapaian .= '</tr>';
            $tablecapaian .= '</tfoot>';
            $tablecapaian .= '</table>';
            /* ============= */
            /* ============= */
            $tablebatasmax = '<table class="table table-striped table-hover table_kpi" width="100%">';
            $tablebatasmax .= '<thead>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<th>No. </th><th>Jenis Absensi</th><th>Jumlah Hari/Menit</th><th>Menit Pengurang</th><th>Total Waktu Efektif</th><th>Input Aktifitas</th>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '</thead>';
            $tablebatasmax .= '<tbody>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>1. </td><td>Sakit</td><td><a>' . $sakit . ' hari </a></td><td>300 menit</td><td>' . number_format($totalsakit, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>2. </td><td>Ijin</td><td><a>' . $ijin . ' hari</a></td><td>300 menit</td><td>' . number_format($totalijin, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>3. </td><td>Alpa</td><td><a>' . $alpa . ' hari</a></td><td>600 menit</td><td>' . number_format($totalalpa, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>4. </td><td>Telat / Pulang Cepat</td><td>' . $tempalpasetengah . ' menit</td><td>' . $tempalpasetengah . ' menit</td><td>' . number_format($tempalpasetengah, 0, ",", ".") . ' menit</td><td><span class="text-success">Diperbolehkan input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>5. </td><td>Cuti Sakit</td><td><a>' . $cs . ' hari</a></td><td>240 menit</td><td>' . number_format($totalcsminus, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>6. </td><td>Cuti Alasan Penting >= 6 hari</td><td><a>' . $cap5 . ' hari</a></td><td>300 menit</td><td>' . number_format($totalcap5, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>7. </td><td>Cuti Persalinan 1 & 2</td><td><a>' . $cbs . ' hari</a></td><td>150 menit</td><td>' . number_format($totalcbsminus, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>8. </td><td>Pegawai Titipan</td><td><a>' . $titip . ' hari</a></td><td>300 menit</td><td>' . number_format($totaltitipan, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>9. </td><td>Pegawai Diperbantukan</td><td><a>' . $bantu . ' hari</a></td><td>300 menit</td><td>' . number_format($totalbantu, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>10. </td><td>Tugas Belajar (Tubel)</td><td><a>' . $tubel . ' hari</a></td><td>300 menit</td><td>' . number_format($totaltubel, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>11. </td><td>DPP</td><td>' . $dpp . ' hari</td><td>300 menit</td><td>' . number_format($totaldpp, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>12. </td><td>MPP</td><td><a>' . $mpp . ' hari</a></td><td>300 menit</td><td>' . number_format($totalmpp, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>13. </td><td>Cuti Besar</td><td><a>' . $cb . ' hari</a></td><td>300 menit</td><td>' . number_format($totalcb, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>14. </td><td>Cuti Luar Tanggungan Negara</td><td><a>' . $cltn . ' hari</a></td><td>300 menit</td><td>' . number_format($totalcltn, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>15. </td><td>Ijin Setengah Hari</td><td><a>' . $ijset . ' hari</a></td><td>150 menit</td><td>' . number_format($totalizinset, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>16. </td><td>Meninggal</td><td><a>' . $meninggal . ' hari</a></td><td>300 menit</td><td>' . number_format($totalmeninggal, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td>17. </td><td>Cuti Bersalin Anak ke 3 dst</td><td><a>' . $cbs3 . ' hari</a></td><td>300 menit</td><td>' . number_format($totalcbs3, 0, ",", ".") . ' menit</td><td><span class="text-danger">Dilarang input</span></td>';
            $tablebatasmax .= '</tr>';

            $tablebatasmax .= '</tbody>';
            $tablebatasmax .= '</tfoot>';
            $tablebatasmax .= '<tr>';
            $tablebatasmax .= '<td colspan="4"><b>TOTAL</b> </td><td><b>' . number_format($batasmax, 0, ",", ".") . ' menit</b></td><td>&nbsp;</td>';
            $tablebatasmax .= '</tr>';
            $tablebatasmax .= '</tfoot>';
            $tablebatasmax .= '</table>';
            /* ============= */

            $return = array('capaianefektif' => $capaian, 'capaianefektiftabel' => $tablecapaian, 'batasmaxefektif' => $batasmax, 'batasmaxefektiftabel' => $tablebatasmax);
            return $return;
        }
        
        return FALSE;
    }
    
    public function getCapaian($spmu, $thbl){//new buatan Erwin
        $sql = "SELECT kolok, klogad, unit_id, thbl, spmu, dpa, realisasi, persen_realisasi, capaian_persen, nama_skpd FROM
                capaian_perskpd WHERE spmu = '" . $spmu . "' AND thbl = '" . $thbl . "'";
        
        $tahun = substr($thbl, 0,4);

        if (intval($tahun) > 2015) {
            $db = $this->ekine16;     
        }else{
            $db = $this->ekine;     
        }  
        
        $query = $db->query($sql);
        
        $induk = "";
        $klogad_induk = "";
        $spm = "";
        $capai = "";
        $jdpa = "";
        $capai_prs = "";
        $real_prs = "";

        foreach ($query->result() as $rowspm) {

            $jdpa = floatval($rowspm->dpa);
            $capai = floatval($rowspm->realisasi);
            $real_prs = floatval($rowspm->persen_realisasi);
            $capai_prs = floatval($rowspm->capaian_persen);

            $klogad_induk = $rowspm->klogad;
            $spm = $rowspm->spmu;
            $induk = $rowspm->klogad;
        }

        $nalokl = "";

        $sql = "SELECT nalokl FROM pers_lokasi_tbl WHERE kolok = '" . $induk . "'";
        $query = $db->query($sql);
        $rl = $query->row();
        if(isset($rl)){
            $nalokl = $rl->nalokl;
        }
        //$jdpa = $jdpa;
        $jdpa = number_format(floatval($jdpa), 2, ",", ".");
        $jcapai = number_format(floatval($capai), 2, ",", ".");
        $prs_capaian = number_format(floatval($capai_prs), 2, ",", ".");

        $return = array('capai' => $capai, 'capai_prs' => $capai_prs, 'jdpa' => $jdpa, 'jcapai' => $jcapai, 'prs_capaian' => $prs_capaian,
            'spm' => $spm, 'klogad_induk' => $klogad_induk, 'induk' => $induk, 'nalokl_induk' => $nalokl);

        return $return;
    }
    
    public function getCountEtkd($nrk,$thbl){//new buatan Erwin
        $sql = "SELECT id FROM etkd WHERE userid = '" . $nrk . "' AND thbl ='" . $thbl . "'";
        $query = $this->etkd->query($sql);      

        $result = "";
        $num_row = $query->num_rows();
              

        return $num_row;
    }
    
    public function getDetailsEtkd($nrk,$thbl){//new buatan Erwin
        $sql = "SELECT a.*, (CASE WHEN b.atname IS NULL THEN
            (CASE WHEN c.abname IS NULL THEN a.attendance ELSE c.abname END) ELSE b.atname END) as keterangan,
            e.alias as lok_in, h.alias as lok_out
            FROM( SELECT userid, date_shift, date_in, date_out, shift_in, shift_out, check_in, check_out, late, early_departure, attendance
                  FROM process_prev
                  WHERE userid = '" . $nrk . "' AND to_char(date_shift, 'yyyymm') = '" . $thbl . "'
                  UNION
                  SELECT userid, date_shift, date_in, date_out, shift_in, shift_out, check_in, check_out, late, early_departure, attendance
                  FROM process
                  WHERE userid = '" . $nrk . "' AND to_char(date_shift, 'yyyymm') = '" . $thbl . "'
                  ) a
            LEFT JOIN attendance b ON a.attendance = b.atid
            LEFT JOIN absence c ON a.attendance = c.abid 
            LEFT JOIN checkinout d on(a.userid = d.userid and to_char(a.check_in,'HH24MISS') = to_char(d.checktime,'HH24MISS') and to_char(a.date_in,'yyyymmdd') = to_char(d.checktime,'yyyymmdd'))
            LEFT JOIN iclock e on(d.sn = e.sn)
            LEFT JOIN checkinout g on(a.userid = g.userid and to_char(a.check_out,'HH24MISS') = to_char(g.checktime,'HH24MISS') and to_char(a.date_out,'yyyymmdd') = to_char(g.checktime,'yyyymmdd'))
            LEFT JOIN iclock h on(g.sn = h.sn)
            GROUP BY a.userid, date_shift, date_in, date_out, shift_in, shift_out, check_in, check_out, late, early_departure, attendance, keterangan, lok_in, lok_out
            ORDER BY date_shift ASC";
        $query = $this->etkd->query($sql);      

        $result = "";
        $result = $query->result();
              

        return $result;
    }

}

?>
