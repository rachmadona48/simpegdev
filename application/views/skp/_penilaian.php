<style type="text/css">
    input, textarea{
        border-color: red;
    }
</style>
<?php 
    $buat_penilaian = true;    
    $is_input_keberatan = false;
    $is_input_keberatan_atasan_penilai = false;
    $is_input_keberatan_penilai = false;
    $is_input_keputusan = false;
    $is_done_cetak = false;

    $integritas = 0;
    $pelayanan = 0;
    $komitmen = 0;
    $disiplin = 0;
    $kerjasama = 0;
    $kepemimpinan = 0;        
    if (isset($nilai->penilaian_approvement)) { 
        $buat_penilaian = ($nilai->penilaian_approvement == PENILAIAN_DIBUAT);
        $is_input_keberatan = ($nilai->penilaian_approvement == PENILAIAN_DIKIRIM) && ($nrk==$nilai->nrk);
        $is_input_keberatan_atasan_penilai =  ($nilai->penilaian_approvement == PENILAIAN_KEBERATAN) && ($nrk==$nilai->nrk_atasan_pejabat);
        $is_input_keberatan_penilai = ($nilai->penilaian_approvement == PENILAIAN_KEBERATAN_PENILAI)  && ($nrk==$nilai->nrk_atasan);
        $is_input_keputusan = ($nilai->penilaian_approvement == PENILAIAN_KEPUTUSAN) && ($nrk==$nilai->nrk_atasan_pejabat);
        $is_done_cetak = ($nilai->penilaian_approvement == PENILAIAN_DONE) && ($nrk==$nilai->nrk);

        
        $integritas = $nilai->integritas;
        $pelayanan = $nilai->pelayanan;
        $komitmen = $nilai->komitmen;
        $disiplin = $nilai->disiplin;
        $kerjasama = $nilai->kerjasama;
        $kepemimpinan = $nilai->kepemimpinan;     
    }    
?>

<div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="ibox-title">
                    	<span>Badan Kepegawaian Daerah</span><span style="float: right;">JANGKA WAKTU PENILAIAN<br>January s/d Desember 2018</span>
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_cuti" class="table table-bordered table-striped table-hover dataTable">
                                  <tbody>                                                         
  <tr bordercolor="#F0F0F0">
    <td width="8" rowspan="6">1</td>
    <td colspan="5">YANG DINILAI</td>
    <?php if (isset($infoUser)) { ?>
    <tr>    
      <td width="244">a. NAMA</td>
      <td colspan="4">&nbsp;<?=$infoUser->NAMA_ABS;?></td>
      </tr>
    <tr>
      <td>b. NIP</td>
      <td colspan="4">&nbsp;<?=$infoUser->NIP18;?></td>
      </tr>
    <tr>
      <td>c. Pangkat, golongan ruang</td>
      <td colspan="4">&nbsp;<?=$infoUser->NAPANG.'('.$infoUser->GOL.')';?></td>
      </tr>
    <tr>
      <td>d. Jabatan/Pekerjaan</td>
      <td colspan="4">&nbsp; <?=$infoUser->NAJABL;?></td>
      </tr>
    <tr>
      <td>e. Unit Organisasi</td>
      <td colspan="4">&nbsp;<?=$infoUser->NALOKL;?></td>
      </tr>
  <?php } ?>

    <tr bordercolor="#F0F0F0">
    <td rowspan="6">2</td>
    <td colspan="5">PEJABAT PENILAI</td>
<?php if (isset($infoUserAtasan)) { ?>
    <tr>
      <td>a. NAMA</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan->NAMA_ABS;?></td>
      </tr>
    <tr>
      <td>b. NIP</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan->NIP18;?></td>
      </tr>
    <tr>
      <td>c. Pangkat, golongan ruang</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan->NAPANG.'('.$infoUserAtasan->GOL.')';?></td>
      </tr>
    <tr>
      <td>d. Jabatan/Pekerjaan</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan->NAJABL;?></td>
      </tr>
    <tr>
      <td>e. Unit Organisasi</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan->NALOKL;?></td>
      </tr>
  <?php } ?>  
    <?php if (isset($infoUserAtasan_es3)) { ?>
    <tr bordercolor="#F0F0F0">
      <td rowspan="6">3</td>
      <td>ATASAN PEJABAT PENILAI</td>
      <td colspan="4">&nbsp;</td>
    </tr>
  
    <tr>
      <td>a. NAMA</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan_es3->NAMA_ABS;?></td>
      </tr>
    <tr>
      <td>b. NIP</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan_es3->NIP18;?></td>
      </tr>
    <tr>
      <td>c. Pangkat, golongan ruang</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan_es3->NAPANG.'('.$infoUserAtasan_es3->GOL.')';?></td>
      </tr>
    <tr>
      <td>d. Jabatan/Pekerjaan</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan_es3->NAJABL;?></td>
      </tr>
    <tr>
      <td>e. Unit Organisasi</td>
      <td colspan="4">&nbsp;<?=$infoUserAtasan_es3->NALOKL;?></td>
      </tr>
  <?php } ?>
    <tr bordercolor="#F0F0F0">
    <td rowspan="11">4</td>
    <td colspan="4"><table cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td colspan="8" height="45" width="484">UNSUR YANG DINILAI</td>
      </tr>
    </tbody></table></td>
    <td width="87">JUMLAH</td>
  </tr>
  <tr>
    <td colspan="2">a. Sasaran Kerja Pegawai (SKP)</td>
    <td width="28"><p><?= $skp_average ?></p> </td>
    <td width="82">x <?= $skp_persentage ?>%</td>
    <td id="skp-jumlah"><?= $skp_jumlah ?></td>
      
  </tr>
  <tr>
    <td rowspan="9">b. Perilaku Kerja</td>
    <td width="54">1. Orientasi Pelayanan</td>
    <td>   
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="pelayanan" class="form-control"  style="border-color: red;" value="'.$pelayanan.'" />';
            }else {
                echo $pelayanan;
            }
        ?>   
        
    </td>
    <td><span id="span-pelayanan"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>2. Integritas</p>    </td>
    <td>      
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="integritas" class="form-control"  style="border-color: red;" value="'.$integritas.'" />';
            }else {
                echo $integritas;
            }
        ?>           
    </td>
    <td><span id="span-integritas"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>3. Komitmen</td>
    <td>
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="komitmen" class="form-control" style="border-color: red;" value="'.$komitmen.'" />';
            }else {
                echo $komitmen;
            }
        ?>   

    </td>
    <td><span id="span-komitmen"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>4. Disiplin</td>
    <td>
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="disiplin" class="form-control" style="border-color: red;" value="'.$disiplin.'" />';
            }else{
                echo $disiplin;
            }
        ?>        
  </td>
    <td><span id="span-disiplin"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>5. Kerjasama</td>
    <td>
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="kerjasama" style="border-color: red;" class="form-control" value="'.$kerjasama.'" />';
            }else {
                echo $kerjasama;
            }
        ?>         
      </td>
    <td><span id="span-kerjasama"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>6. Kepemimpinan</td>
    <td>
        <?php 
            if ($buat_penilaian || $is_input_keputusan) {
                echo '<input type="text" id="kepemimpinan" class="form-control" value="'.$kepemimpinan.'" />';
            }else {
                echo $kepemimpinan;
            }
        ?>           
    </td>
    <td><span id="span-kepemimpinan"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jumlah</td>
    <td><span id="span-jumlah"></span></td>
    <td>0</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai Rata-rata</td>
    <td><span id="span-rata"><span></td>
    <td><p>(Baik)</p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai Perilaku kerja</td>
    <td><span id="span-perilaku"><span></td>
    <td>x 40 %</td>
    <td><span id="span-nilai-perilaku"><span></td>
  </tr>
  <tr bordercolor="#F0F0F0">
    <td colspan="5" rowspan="2">Nilai Prestasi kerja</td>
    <td><span id="span-nilai-total-perilaku">0</span></td>
  </tr>
  <tr>
    <td><span id="span-keterangan-total-perilaku"></span></td>
  </tr>
  <tr>
    <td>5</td>
    <td colspan="5">Keberatan Dari Pegawai Negeri Sipil yang dinilai (apabila ada)</td>
  </tr>
  <tr>    
    <?php if ($is_input_keberatan) { ?>
        <td>&nbsp;</td>
        <td colspan="5"><textarea id="keberatan" class="form-control"  style="border-color: red;"></textarea></td>        
    <?php } else {?>
        <td>&nbsp;</td>
        <td colspan="5"><?php echo isset($nilai->keberatan_bawahan) ? $nilai->keberatan_bawahan : ""; ?></td>
    <?php } ?>
  </tr>  
  <tr>    
        <td>&nbsp;</td>
        <td colspan="5"><span style="float: right;"><?php echo isset($nilai->tgl_keberatan) ?  $nilai->tgl_keberatan: ""; ?></span></td>    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>6</td>
    <td colspan="5">Keberatan Dari Atasan Penilai (apabila ada)</td>
  </tr>
  <tr>    
    <?php if ($is_input_keberatan_atasan_penilai) { ?>
        <td>&nbsp;</td>
        <td colspan="5"><textarea id="keberatan" class="form-control"  style="border-color: red;"></textarea></td>
    <?php } else {?>
        <td>&nbsp;</td>
        <td colspan="5"><span><?php echo isset($nilai->keberatan_atasan_penilai) ?  $nilai->keberatan_atasan_penilai: ""; ?></span></td>
    <?php } ?>     
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><span style="float: right;"><?php echo isset($nilai->tgl_keberatan_atasan_penilai) ?  $nilai->tgl_keberatan_atasan_penilai: ""; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <tr>
    <td>7</td>
    <td colspan="5">Keberatan Dari pejabat penilai (apabila ada)</td>
  </tr>
  <tr>
     <?php if ($is_input_keberatan_penilai) { ?>
        <td>&nbsp;</td>
        <td colspan="5"><textarea id="keberatan" class="form-control"  style="border-color: red;"></textarea></td>
    <?php } else {?>
        <td>&nbsp;</td>
        <td colspan="5"><span><?php echo isset($nilai->keberatan_penilai) ?  $nilai->keberatan_penilai: ""; ?></span></td>
    <?php } ?> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><span style="float: right;"><?php echo isset($nilai->tgl_keberatan_penilai) ?  $nilai->tgl_keberatan_penilai: ""; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>8</td>
    <td colspan="5">Keputusan Atasan Pejabat Penilai Atas Keberatan</td>
  </tr>
  <tr>     
    <?php if ($is_input_keputusan) { ?>
        <td>&nbsp;</td>
        <td colspan="5"><textarea id="keberatan" class="form-control"  style="border-color: red;"></textarea></td>
    <?php } else {?>
        <td>&nbsp;</td>
        <td colspan="5"><span><?php echo isset($nilai->keputusan) ?  $nilai->keputusan: ""; ?></span></td>
    <?php } ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><span style="float: right;"><?php echo isset($nilai->tgl_keputusan) ?  $nilai->tgl_keputusan: ""; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>9</td>
    <td colspan="5">Rekomendasi</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
</tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="javascript:void(0)" class="btn btn-primary" onclick="onBack()">Back</a>
                            <?php if ($buat_penilaian){ ?>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onSave()">Simpan</a>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onKirim('<?= PENILAIAN_DIBUAT ?>')">Di Kirim</a>
                            <?php } else if ($is_input_keberatan_atasan_penilai){ ?>                                
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onKirim('<?= PENILAIAN_KEBERATAN ?>')">Di Kirim</a>
                            <?php } else if ($is_input_keberatan_penilai){ ?>                                
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onKirim('<?= PENILAIAN_KEBERATAN_PENILAI ?>')">Di Kirim</a>                                
                            <?php } else if ($is_input_keputusan){ ?>                                
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onDone('<?= PENILAIAN_KEPUTUSAN ?>')">Di Kirim</a>
                            <?php } else if ($is_done_cetak){ ?>                                
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="onCetak('<?= PENILAIAN_KEPUTUSAN ?>')">Cetak</a>
                            <?php } else { ?>
                                <!-- <?php if ($is_has_not_nilai) { ?>
                                    <?php if (!$is_input_keberatan){ ?> 
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="onSave()">Simpan</a>
                                    <?php } ?>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="onKirim()">Di Kirim</a>
                                <?php } ?> -->
                            <?php } ?>


</div>
</div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div>