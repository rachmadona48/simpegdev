<style type="text/css">
    input, textarea{
        border-color: red;
    }
</style>
<?php     
    $is_done = false;
    $integritas = 0;
    $pelayanan = 0;
    $komitmen = 0;
    $disiplin = 0;
    $kerjasama = 0;
    $kepemimpinan = 0;    
    if (isset($nilai)) {         
        $is_done = ($nilai->perilaku_approvement == PERILAKU_DONE);
        $integritas = $nilai->integritas;
        $pelayanan = $nilai->pelayanan;
        $komitmen = $nilai->komitmen;
        $disiplin = $nilai->disiplin;
        $kerjasama = $nilai->kerjasama;
        $kepemimpinan = $nilai->kepemimpinan;
    }
?>

<?php 
  if (isset($mutasi_atasan)){
    echo "Keterangan";
  }else{
    echo "tidak ada keterangan";
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
                      <?php if (isset($infoUser)) { ?>
                    	<span>Nama</span>:<span><?=$infoUser->NAMA_ABS;?></span><br/>
                      <span>Nip</span>:<span><?=$infoUser->NIP18;?></span><br/>
                       <?php } ?>

                      </span>
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_cuti" class="table table-bordered table-striped table-hover dataTable">
                                  <tbody>
                                  </tbody>
                                </table>                                                         

 
  <table class="table table-bordered table-striped table-hover dataTable">
  <thead>
    <th>No</th> 
    <th>Tanggal</th>
    <th colspan="3">Uraian</th>
    <th>Nama/NIP dan Paraf Pejabat Penilai</th>
  </thead>
  <tr>
    <td>1</td>
    <td>2</td>
    <td colspan="3">3</td>
    <td>4</td>
  </tr>
  <tr>
    <td rowspan="10">1</td>
    <td rowspan="10">Januari s/d Desember 2018</td>
    <td colspan="3">Penilaian SKP sampai dengan akhir Desember 2018 = , sedangkan penilaian perilaku kerjanya adalah sebagai berikut :</td>
</tr>
<tr>
    <td width="54">Orientasi Pelayanan</td>
    <td>   
        <?php 
            if ($is_done) {
                echo $pelayanan;
            }else{
                echo '<input type="text" id="pelayanan" class="form-control"  style="border-color: red;" value="'.$pelayanan.'" />';
            }
        ?>   
        
    </td>
    <td><span id="span-pelayanan"><span></td>
  </tr>
  <tr>
    <td><p>Integritas</p>    </td>
    <td>      
        <?php 
            if ($is_done) {
                echo $integritas;
            }else{
                echo '<input type="text" id="integritas" class="form-control"  style="border-color: red;" value="'.$integritas.'" />';
            }
        ?>           
    </td>
    <td><span id="span-integritas"><span></td>
    <td align="center">Kasubbid Kinerja Pegawai</td>
  </tr>
  <tr>
    <td>Komitmen</td>
    <td>
        <?php 
            if ($is_done) {
                echo $komitmen;
            }else{
                echo '<input type="text" id="komitmen" class="form-control" style="border-color: red;" value="'.$komitmen.'" />';
            }
        ?>   

    </td>
    <td><span id="span-komitmen"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Disiplin</td>
    <td>
        <?php 
            if ($is_done) {
                echo $disiplin;
            }else{
                echo '<input type="text" id="disiplin" class="form-control" style="border-color: red;" value="'.$disiplin.'" />';
            }
        ?>        
  </td>
    <td><span id="span-disiplin"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kerjasama</td>
    <td>
        <?php 
            if ($is_done) {
                echo $kerjasama;
            }else{
                echo '<input type="text" id="kerjasama" style="border-color: red;" class="form-control" value="'.$kerjasama.'" />';
            }
        ?>         
      </td>
    <td><span id="span-kerjasama"><span></td>
    <td align="center">
      <div style="text-decoration: underline;"><?=$infoUserAtasan->NAMA_ABS;?></div><br/>
      <?=$infoUserAtasan->NIP18;?>
    </td>
  </tr>
  <tr>
    <td>Kepemimpinan</td>
    <td>
        <?php 
            if ($is_done) {
                echo $kepemimpinan;
            }else{
                echo '<input type="text" id="kepemimpinan" class="form-control" value="'.$kepemimpinan.'" value="'.$kepemimpinan.'"/>';
            }
        ?>           
    </td>
    <td><span id="span-kepemimpinan"><span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jumlah</td>
    <td><span id="span-jumlah"></span></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai Rata-rata</td>
    <td><span id="span-rata"><span></td>
    <td><p>(Baik)</p></td>
    <td>&nbsp;</td>
  </tr>
 
 
</tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="javascript:void(0)" class="btn btn-primary" onclick="onBack()">Back</a>                          
                          <?php if (!$is_done){ ?>
                              <a href="javascript:void(0)" class="btn btn-primary" onclick="onSave()">Simpan</a>
                              <a href="javascript:void(0)" class="btn btn-primary" onclick="onKirim()">Di Kirim</a>
                          <?php } ?>


</div>
</div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div>
