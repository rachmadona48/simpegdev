<style type="text/css">
    .col-lg-4 .ibox .ibox-title{
        background-color: rgba(0,0,0,0.1);
    }
    .col-lg-4 .ibox .ibox-content{
        background-color: rgba(10,0,0,0.07);
    }
    #addMenu .modal-content .modal-header {
        padding: 10px 15px; 
        text-align: center;
    }
    #addMenu .ibox-content {
        background-color: #ffffff;
        color: inherit;
        padding: 0px 0px 0px 0px !important; 
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0px;
    }

    .dd-item .pull-right button{
        margin-top: 5px;
        margin-right: 2px;
    }

    .sk-spinner-circle.sk-spinner {
            height: 22px;
            margin: 0 !important;
            position: relative;
            width: 22px;
        }

    .sk-spinner-three-bounce.sk-spinner {
            margin: 0 auto;
            text-align: center;
            width: 140px !important;
        }

    .dataTables_scroll .dataTables_scrollHeadInner{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollHeadInner table{
        width: 100% !important;   
    }

    .dataTables_scroll .dataTables_scrollBody{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollBody table{
        width: 100% !important;
    }

    .datepicker, .datepicker-dropdown{
        z-index: 999999999 !important;        
    }
    .pickerpicker .form-control-feedback {
        right: 55px !important;      
    }

    .pickerpicker .form-control-feedback {
        top: 0px !important;
    }

    .input-group[class*="col-"] {
        float: none;
        padding-left: -1px !important;
        padding-right: -1px !important;
    }

    .has-success .chosen-container{
   border: 1px solid #1ab394;
    }
 
  .has-error .chosen-container{
   border: 1px solid #ed5565;
    } 

    .kegiatan{
        float:left;
        width: 70%;
    }

    .sel-kegiatan{     
        float:left;
        width: 29%;    
    }

     .tr-kegiatan{
        cursor: pointer;
    }

    .tr-exist{
        background-color: yellow !important;
    }


    input{
        border-color: red !important;
    }

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Sasaran Kinerja Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">
                <strong>Skp</strong>
            </li>
            <li>
                <strong>Pengukuran</strong>
            </li>
        </ol>
         <!-- <small><i>(Menu untuk pengajuan dan proses cuti)</i></small> -->
    </div>
</div>


<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP</h5>
                 <?php 
                    foreach ($skp as $key => $value) {
                       // echo 'idnya'.$value->id.'<br/>';
                    }
                 ?>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>

            <div class="ibox-content">
            	<div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content text-center p-md">
                                    <h2><span class="text-navy">PENILAIAN CAPAIAN SASARAN KERJA <br/>PEGAWAI NEGERI SIPIL</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row" >
                     Jangka Waktu Penilaian <br/>
                        <?php
                        if ($skp_mutasi == null ){
                            foreach ($skp_h as $key) {
                            # code...
                                echo $key->startdate;
                                echo "&nbsp; s/d &nbsp;";
                                echo $key->enddate;
                            }
                        }
                        else {
                            echo "tes date";
                        }
                        
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                
                                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr >
                        <th rowspan="2">NO</th>
                        <th rowspan="2">I. KEGIATAN TUGAS TAMBAHAN</th>
                        <th rowspan="2">AK</th>
                        <th colspan="6">TARGET</th>
                        <th rowspan="2">AK</th>
                        <th colspan="6">REALISASI</th>
                        <th rowspan="2">PENGHITUNGAN</th>
                        <th rowspan="2">NILAI CAPAIAN SKP</th>                        
                    </tr>
                    <tr>
                        <th colspan="2">Kuant/ Output</th>
                        <th>Kual/ Mutu</th>
                        <th colspan="2">Waktu</th>
                        <th>Biaya</th>
                        <th colspan="2">Kuant/ Output</th>
                        <th>Kual/ Mutu</th>
                        <th colspan="2">Waktu</th>
                        <th>Biaya</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th colspan="2">4</th>
                        <th>5</th>
                        <th colspan="2">6</th>
                        <th>7</th>
                        <th>8</th>
                        <th colspan="2">9</th>
                        <th>10</th>
                        <th colspan="2">11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                    </tr>
                    </thead>
                    
                    <tbody>
                <?php
                    $kegiatan_utama = 1;
                    $kegiatan_tambahan =2;
                    $kegiatan_kreatifitas =3;   
                    $no_utama=1;
                    $no_tambahan=1;
                    $no_kreatifitas=1;
                    $count_utama=0;
                    $count_tambahan=0;
                    $count_kreatifitas=0;
                    foreach ($skp as $key => $value) { 
                         if($value->type_kegiatan==$kegiatan_utama){ 
                ?>
                    <tr class="gradeX" height="20" id="row-<?php echo $value->id?>" id-kegiatan="<?php echo $value->id_kegiatan ?>" type-kegiatan="<?php echo $value->jenis_kegiatan ?>">
                        <td height="10" class="center"><?=$no_utama?></td>
                        <td><?=$value->kegiatan?></td>
                        <td align="right"><?=$value->ak?></td>
                        <td align="right"><?=$value->quantityshow?></td>
                        <td><?=$value->outputshow?></td>
                        <td align="right"><?=$value->qualityshow?></td>
                        <td align="right"><?=$value->waktushow?></td>
                        <td>Bulan</td>
                        <td><?=$value->biaya?></td>
                        <td align="right" class="bg-danger">
                            
                            <label><?=$value->ak_realisasi?></label>
                        </td>
                        <td align="right" class="bg-danger">
                           
                            <label><?=$value->qty_realisasi?></label>
                        </td>
                        <td class="bg-danger">
                        <?php
                        foreach ($doc_type as $key => $values) {
                                if($values->id==$value->output_realisasi){
                                     echo $values->name;
                                }
                            }
                        ?>
                        </td>
                        <td align="right" class="bg-danger">
                           
                            <label><?=$value->quality_realisasi?></label>
                        </td>
                        <td align="right" class="bg-danger">
                            <label><?=$value->waktu_realisasi?></label>
                        </td>
                        <td class="bg-danger">Bulan</td>
                        <td class="bg-danger">
                            <label><?=$value->biaya_realisasi?></label>
                        </td>
                        <?php
                        // Get Kuantitas
                        $qty_target = $value->quantityshow;
                        $qty_realisasi = $value->qty_realisasi;

                        if($qty_realisasi>=1){
                            $kuantitas= @($qty_realisasi/$qty_target)*100;
                        }
                        else {
                            $kuantitas = "";
                            $kuantitas = 0;
                        }
                        // Get Kualitas
                        $k_target = $value->qualityshow;
                        $k_realisasi = $value->quality_realisasi;

                        if($k_target>1){
                            $kualitas= @($k_realisasi/$k_target)*100;
                        }
                        else {
                            $kualitas = "";
                            $kualitas = 0;
                        }

                        // Get Waktu
                        $w_target = $value->waktushow;
                        $w_realisasi = $value->waktu_realisasi;
                        // ef %
                        if ($w_realisasi<=1){
                            $ef = "";
                        }
                        else {
                            $ef = 100-@($w_realisasi/$w_target)*100;
                        }
                        // <= 24 %
                        if ($w_realisasi<1){
                            $duaempat_min = "";
                        }
                        else {
                            $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                        }
                         // > 24 %
                        if ($w_realisasi<1){
                            $duaempat_plus = "";
                        }
                        else {
                            $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                        }
                        // waktu
                        if ($w_realisasi<1){
                            $waktu ="";
                        }
                        else {
                            if($ef>24){
                                $waktu = $duaempat_plus;
                            }
                            else {
                                $waktu = $duaempat_min;
                            }
                        }
                        // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                        // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                        // kolom penghitungan
                        $b_realisasi = $value->biaya_realisasi;
                        $penghitungan=0;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $penghitungan = $kuantitas + $kualitas;
                            }
                            else {
                                $penghitungan = $kuantitas + $kualitas + $waktu;
                            }
                        }
                        // kolom nilai capaian skp
                        $capaian_skp=0;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $capaian_skp = $penghitungan / 4;
                            }
                            else {
                                $capaian_skp = $penghitungan / 3;
                            }
                        }

                        //$penghitungan = number_format($penghitungan,2);
                        $capaian_skp = number_format($capaian_skp,2);

                        $avg_skp = count($capaian_skp);
                        //echo 'rata-rata'.$avg_skp;

                        $count_utama;

                        ?>
                        <td align="right"><?=$penghitungan?></td>
                        <td align="right"><?=$capaian_skp?></td>
                    </tr> 
                    <?php 
                        $no_utama++;
                        $count_utama++; 
                            } 

                        }
                        //echo 'count utama ='.$count_utama;
                    ?>
                    <tr height="20">
                        <td height="20" align="right">&nbsp;</td>
                        <td colspan="17"><b>II. UNSUR PENUNJANG <br/>
                        TUGAS TAMBAHAN DAN KREATIVITAS :</b></td>
                    </tr>
                    <tr>
                        <td height="20" align="right">&nbsp;</td>
                        <td colspan="17">Tugas Tambahan :</td>
                    </tr>

                   <tbody class="contains-body">
                    <?php
                    $no=1;
                    // echo "<pre>";
                    // var_dump($skp); 

                    foreach ($skp as $key => $value) {
                     if ($value->type_kegiatan==$kegiatan_tambahan){ ?>
                  
                        <tr class="gradeX tambahan tambahan-existing" height="20" id="row-<?php echo $value->id?>" id-kegiatan="<?php echo $value->id_kegiatan ?>" type-kegiatan="<?php echo $value->jenis_kegiatan ?>">
                            <td height="10" class="center no">
                                <?=$no_tambahan?>
                            </td>
                            <td>
                                <?=$value->kegiatan?>

                            </td>
                            <td align="right">
                               <?=$value->ak?>
                            </td>
                            <td align="right">
                               <?=$value->quantityshow?>      
                            </td>
                            <td width="10%">
                                <?=$value->outputshow?>
                            </td>
                            <td align="right">
                                 <?=$value->qualityshow?>
                            </td>
                            <td align="right" width="6%">
                                <?=$value->waktushow?>                                
                            </td>
                            <td>Bulan</td>
                            <td>
                                <?=$value->biayashow?>
                            </td>
                            <td align="right">
                               <?=$value->ak_realisasi?>
                            </td>
                            <td align="right">
                                <?=$value->qty_realisasi?>
                            </td>
                            <td width="10%">
                            <?php
                            foreach ($doc_type as $key => $values) {
                                    if($values->id==$value->output_realisasi){
                                         echo $values->name;
                                    }
                                }
                            ?>
                            </td>
                            <td align="right">
                               <?=$value->quality_realisasi?>
                            </td>
                            <td align="right" width="6%">
                                <?=$value->waktu_realisasi?>
                            </td>
                            <td>Bulan</td>
                            <td>
                               <?=$value->biaya_realisasi?>
                            </td>
                            <?php
                            // Get Kuantitas
                            $qty_target = $value->quantityshow;
                            $qty_realisasi = $value->qty_realisasi;

                            if($qty_realisasi>=1){
                                $kuantitas= @($qty_realisasi/$qty_target)*100;
                            }
                            else {
                                $kuantitas = "";
                                $kuantitas = 0;
                            }
                            // Get Kualitas
                            $k_target = $value->qualityshow;
                            $k_realisasi = $value->quality_realisasi;

                            if($k_target>1){
                                $kualitas= @($k_realisasi/$k_target)*100;
                            }
                            else {
                                $kualitas = "";
                                $kualitas = 0;
                            }

                            // Get Waktu
                            $w_target = $value->waktushow;
                            $w_realisasi = $value->waktu_realisasi;
                            // ef %
                            if ($w_realisasi<=1){
                                $ef = "";
                            }
                            else {
                                $ef = 100-@($w_realisasi/$w_target)*100;
                            }
                            // <= 24 %
                            if ($w_realisasi<1){
                                $duaempat_min = "";
                            }
                            else {
                                $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                            }
                             // > 24 %
                            if ($w_realisasi<1){
                                $duaempat_plus = "";
                            }
                            else {
                                $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                            }
                            // waktu
                            if ($w_realisasi<1){
                                $waktu ="";
                            }
                            else {
                                if($ef>24){
                                    $waktu = $duaempat_plus;
                                }
                                else {
                                    $waktu = $duaempat_min;
                                }
                            }
                            // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                            // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                            // kolom penghitungan
                            $b_realisasi = $value->biaya_realisasi;
                            if ($b_realisasi==$w_realisasi) {
                                $penghitungan = "";    
                            }
                            else {
                                if ($b_realisasi>1){
                                    $penghitungan = $kuantitas + $kualitas;
                                }
                                else {
                                    $penghitungan = $kuantitas + $kualitas + $waktu;
                                }
                            }
                            // kolom nilai capaian skp
                            $capaian_skp=0;
                            if ($b_realisasi==$w_realisasi) {
                                $penghitungan = "";    
                            }
                            else {
                                if ($b_realisasi>1){
                                    $capaian_skp = $penghitungan / 4;
                                }
                                else {
                                    $capaian_skp = $penghitungan / 3;
                                }
                            }

                            //$penghitungan = number_format($penghitungan,2);
                            $capaian_skp = number_format($capaian_skp,2);

                            $avg_skp = count($capaian_skp);
                            //echo 'rata-rata'.$avg_skp;

                            $count_utama;

                            ?>
                            <td align="right"><?=$penghitungan?></td>
                            <td align="right"><?=$capaian_skp?></td>
                        </tr> 
                    <?php 
                        $no_tambahan++;
                        $count_tambahan++; 
                        } 
                    } 
                    ?>
                    </tbody>
                     <tr>
                        <td height="20" align="right">&nbsp;</td>
                        <td colspan="17">Kreatifitas :</td>
                     </tr>
                      <tbody class="contains-body_kreatifitas">
                    <?php
                    $no=1;
                    // echo "<pre>";
                    // var_dump($skp); 

                    foreach ($skp as $key => $value) {
                     if ($value->type_kegiatan==$kegiatan_kreatifitas){ 
                        foreach ($skp_h as $key) {
                            # code...
                            if($key->status_approvement==STATUS_REALISASI_DITERIMA){
                        ?>
                  
                    <tr class="gradeY tambahan tambahan-existing-kreatifitas" height="20" id="row-<?php echo $value->id?>" >
                        <td height="10" class="center no"><?=$no_kreatifitas?></td>
                        <td>
                            <?=$value->kegiatan?>

                        </td>
                        <td align="right">
                           <?=$value->ak?>
                        </td>
                        <td align="right">
                           <?=$value->quantityshow?>      
                        </td>
                        <td width="10%">

                            <?=$value->outputshow?>
                        </td>
                        <td align="right">
                             <?=$value->qualityshow?>
                        </td>
                        <td align="right" width="6%">
                            <?=$value->waktushow?>                                
                        </td>
                        <td>Bulan</td>
                        <td><?=$value->biayashow?></td>
                        <td align="right">
                            <?=$value->ak_realisasi?>
                        </td>
                        <td align="right">
                           <?=$value->qty_realisasi?>
                        </td>
                        <td width="10%">
                        <?php
                        foreach ($doc_type as $key => $values) {
                                if($values->id==$value->output_realisasi){
                                     echo $values->name;
                                }
                            }
                        ?>
                        </td>
                        <td align="right">
                            <?=$value->quality_realisasi?>
                        </td>
                        <td align="right" width="6%">
                            <?=$value->waktu_realisasi?>    
                        </td>
                        <td>Bulan</td>
                        <td>
                            <?=$value->biaya_realisasi?>
                        </td>
                       <?php
                        // Get Kuantitas
                        $qty_target = $value->quantityshow;
                        $qty_realisasi = $value->qty_realisasi;

                        if($qty_realisasi>=1){
                            $kuantitas= @($qty_realisasi/$qty_target)*100;
                        }
                        else {
                            $kuantitas = "";
                            $kuantitas = 0;
                        }
                        // Get Kualitas
                        $k_target = $value->qualityshow;
                        $k_realisasi = $value->quality_realisasi;

                        if($k_target>1){
                            $kualitas= @($k_realisasi/$k_target)*100;
                        }
                        else {
                            $kualitas = "";
                            $kualitas = 0;
                        }

                        // Get Waktu
                        $w_target = $value->waktushow;
                        $w_realisasi = $value->waktu_realisasi;
                        // ef %
                        if ($w_realisasi<=1){
                            $ef = "";
                        }
                        else {
                            $ef = 100-@($w_realisasi/$w_target)*100;
                        }
                        // <= 24 %
                        if ($w_realisasi<1){
                            $duaempat_min = "";
                        }
                        else {
                            $duaempat_min = @((1.76*$w_target-$w_realisasi)/$w_target)*100;
                        }
                         // > 24 %
                        if ($w_realisasi<1){
                            $duaempat_plus = "";
                        }
                        else {
                            $duaempat_plus = 76-@((((1.76*$w_target-$w_realisasi)/$w_target)*100)-100);
                        }
                        // waktu
                        if ($w_realisasi<1){
                            $waktu ="";
                        }
                        else {
                            if($ef>24){
                                $waktu = $duaempat_plus;
                            }
                            else {
                                $waktu = $duaempat_min;
                            }
                        }
                        // echo 'kuantitas ='.$kuantitas.'kualitas ='.$kualitas;
                        // echo 'ef ='.$ef.'&nbsp <24 =;'.$duaempat_min.'&nbsp; >24%'.$duaempat_plus;

                        // kolom penghitungan
                        $b_realisasi = $value->biaya_realisasi;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $penghitungan = $kuantitas + $kualitas;
                            }
                            else {
                                $penghitungan = $kuantitas + $kualitas + $waktu;
                            }
                        }
                        // kolom nilai capaian skp
                        $capaian_skp=0;
                        if ($b_realisasi==$w_realisasi) {
                            $penghitungan = "";    
                        }
                        else {
                            if ($b_realisasi>1){
                                $capaian_skp = $penghitungan / 4;
                            }
                            else {
                                $capaian_skp = $penghitungan / 3;
                            }
                        }

                        //$penghitungan = number_format($penghitungan,2);
                        $capaian_skp = number_format($capaian_skp,2);

                        $avg_skp = count($capaian_skp);
                        //echo 'rata-rata'.$avg_skp;

                        $count_kreatifitas;

                        ?>
                        <td align="right"><?=$penghitungan?></td>
                        <td align="right"><?=$capaian_skp?></td>
                    </tr> 
                    <?php 
                        $no_kreatifitas++;
                        $count_kreatifitas++; 
                        } }
                    } }
                    ?>
                     <tr height="20">
                        <td height="20" align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td align="right">&nbsp;</td>
                        <td rowspan="2" align="right">&nbsp;</td>
                     </tr>
                     
                    </tbody>
                   
                    </table>                    
                    

                    <?php
                    foreach ($skp_h as $key => $row) {
                        # code...
                        if ($row->status_approvement==STATUS_REALISASI_DITERIMA){?>
                             <a href="<?php echo base_url() ?>index.php/skp/cetak_pengukuran?skp_id=<?=$skp_id?>&nrk=" class="btn btn-warning" target="_blank">Cetak</a>
                        <?php
                        }
                    }
                    ?>
                   
                    <?php
                     	//var_dump($infoUser);
    					//var_dump($_SESSION);
    				?>
                        </div> <!-- div table responsive-->           
                            
                            </div>
                            <div class="row" style="margin-left: 15px;">                            
                        <button type='button' class='btn btn-primary btn-tambah' onclick="fnClickAddRow()">Tambah Tugas</button>
                        <button type='button' class='btn btn-primary btn-simpan'><i class='fa'></i>Kirim Tugas Tambahan</button>
                    </div>
                        </div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->

</div>
<?php } ?>



<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <!-- <form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form"> -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Form SKP (KEGIATAN TUGAS JABATAN)</h3>
        </div>
        <div class="modal-body">
            <div style="overflow-y: scroll;height: 457px;">
            <table id="tbl-popup-kegiatan" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">Kegiatan</th>
                    </tr>
                </thead>
                <tbody class="kegiatan-body">
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">            
            <button type="button" class="btn btn-danger btn-popup tutup" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary btn-popup ok">OK</button>
        </div>
    <!-- </form> -->
        
    </div>
  </div>
</div>

    <script src="<?php echo base_url() ?>assets/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url() ?>assets/inspinia/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Nestable List -->
    <script src="<?php echo base_url() ?>assets/js/plugins/nestable/jquery.nestable.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url() ?>assets/inspinia/js/inspinia.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/pace/pace.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>


   <script type="text/javascript">

        var m_element = "";
        var doc_master = [];
        $(document).ready(function() {            
            $(".btn-simpan").click(function(){
                var arr_data = getArrData(".tambahan-new");                
                $.ajax({
                    type: "POST",
                    data: {data:arr_data, skp_id:'<?php echo $skp_id ?>'},
                    url: "<?php echo base_url(); ?>index.php/skp/submit_tugas_tambahan",
                    success: function(msg){                    
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){
                             $(json.doc_master).each(function(i,obj){
                                doc_master[obj.id] = obj.name;
                            });
                            displayTable(json.data);                            
                        }
                    }
                });      
            });

            $(".tutup").click(function(){
                $(m_element.element).val("");
                $(m_element.element).attr("attr-id-keg", "");
                $(m_element.el).prop("selectedIndex", 0);
                m_element  = "";
            });

            $(".ok").click(function(){                
                if (m_element.id!=''){                      
                    var el_tr = $(m_element.element).parent().parent();
                        $(el_tr).attr("id-kegiatan", m_element.id);
                        $(el_tr).attr("type-kegiatan", m_element.type);
                        $(m_element.element).attr("attr-id-keg", m_element.id);
                        $(m_element.element).val(m_element.val);       
                        $('#modal').modal('toggle');
                    }

            });

            $(".close").click(function(){
                    $(m_element.element).val("");                                
                    $(m_element.element).attr("attr-id-keg", "");
                    $(m_element.el).prop("selectedIndex", 0);
                    m_element  = ""; 
            });               
       });
   
        function getArrData(el){
            var arr_data = [];
            $(el).each(function(i,obj){
                var elchild = $(obj).children();                
                var arr_child = [];
                $(elchild).each(function(j,objchl){                                            
                    var newValue = "";
                    if ($(objchl).children()){
                        var inputel = $(objchl).find("input");
                        if ($(inputel).hasClass("form-control")){
                            newValue  = $(inputel).val();
                            arr_child.push(newValue);                            
                            if($(inputel).attr('attr-id-keg')) {  
                                var newValue = $(inputel).attr('attr-id-keg');
                                arr_child.push(newValue);
                            }
                        }
                        var inpute2 = $(objchl).find("select");
                        if ($(inpute2).hasClass("form-control")){
                            newValue  = $(inpute2).val();                                
                            if(typeof newValue !== undefined && newValue !== false) {  
                                arr_child.push(newValue);
                            }
                        }
                    }                         
                 });                
                arr_data.push(arr_child);
            });
            return arr_data;
        }
        function fnClickAddRow(){
            var eltblbody =$(".contains-body").text();  
            var contain_body = eltblbody.replace(/\s+/g, '');            
            var el = $(".gradeX").last();   
            //alert(el);         
            //var no = $("table .no").last().text();
            //alert(no);
            // var number= parseInt(no)+1;
            // if (isNaN(number)){
            //     number = 1;
            // }

            var html = '<tr class="gradeX tambahan tambahan-new" id-kegiatan="" type-kegiatan="">';
                html = html + '<td class="no"></td>';
                html = html + '<td><input type="text" attr-id-keg="" name="kegiatan[]" class="form-control kegiatan" />' + getTypeSelect("") + '</td>';
                html = html + '<td><input type="text" name="ak[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                html = html + '<td><input type="text" name="quantity[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
               var arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                var arr_select = [];
                    <?php foreach ($doc_type as $key => $value) { ?>
                        arr_select.push({key: "<?php echo $value->id; ?>", value: "<?php echo $value->name; ?>"});
                    <?php } ?>
                var str_html = onSelectOutput(arr_select, "");  
                html = html + '<td width="10%">' + str_html + '</td>';                  
                html = html + '<td><input type="text" name="kual[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                html = html + '<td>';
                html = html + '<select class="form-control" id="time" name="time[]">';
                html = html + '<?php for ($x = 1; $x <= 12; $x++) { ?>';
                html = html + '<?php echo "<option value=".$x." selected>".$x."</option>"?>';
                html = html + '<?php } ?>';
                html = html + '</select>'; 
                html = html + '</td>';                 
                html = html + '<td>bulan</td>';                
                html = html + '<td><input type="text" class="form-control" name="date[]" onkeypress="allowNumbersOnly(event)"></td>';
                
                html = html + '<td colspan="10" class="action"><a href="javascript:void(0)" onclick="onDelete(this)">Delete.</a></td>';
                html = html + '</tr>';
                        
            if (contain_body==""){
                $('.contains-body').html(html);
            }else{
                $(html).insertAfter(el);
            }
            // $( ".dtpicker" ).datepicker();
            $("input,select").css("border-color","red");
            //$('.clockpicker').clockpicker();
            //$(".btn-submit").show();

             //$(".btn-simpan").attr("disabled",false);
             reSortNumber('.gradeX.tambahan');
        }

        function onSelectOutput(arr_data, val){            
            var str_html = '<select class="form-control">';
            $(arr_data).each(function(key,value){
                if (val==value){
                    str_html = str_html + '<option value="'+ value.key +'" selected>'+ value.value +'</option>';
                }else{
                    str_html = str_html + '<option value="'+ value.key +'">'+ value.value +'</option>';
                }
            });
            str_html = str_html + '</select>';
            return str_html;            
        }

        function onDelete(elm){              
            if (!confirm('Apakah mau dihapus?')){                
                return;
            }
            $(".btn").attr("disabled",true);
            var el_add_row = $(".new");
            if (!el_add_row){
                $(".btn-submit").hide();
            }
            var el = $(elm).parent().parent();                        
            var arr_id = $(el).attr("id");
            var is_exist = false;
            if (arr_id){
                is_exist = true;
                var arr_id = $(el).attr("id").split("-");
            }
            if (is_exist){
                $.ajax({
                    type: "POST",
                    data: {id:arr_id[1]},
                    url: "<?php echo base_url(); ?>index.php/skp/delete_skp",
                    success: function(msg){                    
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){
                            $(el).remove();  
                            $(".btn").attr("disabled",false);
                        }
                    }
                }); 
            }else{
                $(el).remove();  
                $(".btn").attr("disabled",false);
                $(".btn-submit").attr("disabled",true);
            }
            reSortNumber(".tambahan");                                        
        }

        function getTypeSelect(val){
            var arr_data = [                
                {key:"", value:"Tanpa referensi"},
                {key:"program", value:"Program atau Aggaran"},
                {key:"tupoksi", value:"Tupoksi"}
            ]
            var str_html = '<select class="form-control sel-kegiatan" onchange="onChangeTypeKegiatan(this)">';
            $(arr_data).each(function(key,value){
                if (val==value.key){
                    str_html = str_html + '<option value="'+value.key +'" selected>' + value.value + '</option>';
                }else{
                    str_html = str_html + '<option value="'+value.key +'">' + value.value + '</option>';
                }
            });
            str_html = str_html + '</select>';
            return str_html;
        }                
   
        function reSortNumber(element){
            var number = 1;
            $(element).each(function(i,obj){
                var elchild = $(obj).children();
                $(elchild).each(function(j,objchl){
                    if ($(objchl).hasClass("no")){ //no pada <tr> 
                        $(objchl).text(number++);
                    }
                });
            });
        }

        function onChangeTypeKegiatan(el){
            var val = $(el).val();            
            if (val==""){
                var el_tr = $(el).parent().parent();                
                var element = $(el).prev();
                $(element).val("");
                $(element).attr("attr-id-keg","");
                $(el_tr).attr("id-kegiatan","");
                $(el_tr).attr("type-kegiatan","");
            } else if (val=="empty"){
                var element = $(el).prev();
                $(element).val("");                
                $(element).attr("attr-id-keg","");
            } else {
                $('#modal').modal('toggle');
                $(".kegiatan-body").html('<tr><td colspan="2">loading....</td></tr>');                
                $.ajax({
                    type: "POST",
                    data: {type:val,skp_nrk: '<?php echo $skp_h[0]->nrk; ?>'},
                    url: "<?php echo base_url(); ?>index.php/skp/list_popup_kegiatan",
                    success: function(msg){                                                                                
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){                        
                            displayTableKegiatan(el,json);                                                    
                        }                                    
                    }
                });                   
            }            
        }


        function displayTableKegiatan(el, json_root){
            var json = json_root.data;
            var type = json_root.type;
            var str_html = "";
            var ids =  getIds(el, type);
            $.each(json, function( index, value ) {                            
                if (isExistIds(ids, value.id)){
                    str_html = str_html + "<tr class='tr-exist tr-kegiatan-" + value.id + "' attr-id='' attr-value=''><td>"+ (index+1) +"</td><td>" + value.name + "</td></tr>";                
                }else{
                    str_html = str_html + "<tr class='tr-kegiatan tr-kegiatan-" + value.id + "' attr-id='" + value.id + "' attr-value='" + value.name +"'><td>"+ (index+1) +"</td><td>" + value.name + "</td></tr>";                
                }                
            });
            $(".kegiatan-body").html(str_html);
            $(".btn-popup").attr("disabled",false);
            $(".kegiatan-body tr").css("background-color","#F5F5F6");            
            var element = $(el).prev();
            m_element = {el:el, element:element, id: "", val: "", type: type};
            $(".kegiatan-body .tr-kegiatan").click(function() {                  
                $(".kegiatan-body .tr-kegiatan").css("background-color","#F5F5F6");
                $(this).css("background-color","red");
                var id = $(this).attr("attr-id");
                var val = $(this).attr("attr-value");    
                m_element = {el:el, element:element, id: id, val: val, type: type};
            });
        }

        function displayTable(data){

            var strhtml = "";
            
            $(data).each(function(i,obj){ 
             //alert('test');die;
                if (obj.type_kegiatan == <?php echo TYPE_KEGIATAN_TAMBAHAN; ?>){
                    var ak = (obj.ak == null) ? '' : obj.ak;
                    var qty = (obj.quantityshow == null) ? '' : obj.quantityshow;
                    var output = (obj.outputshow == null) ? '' : obj.outputshow;
                    var quantity = (obj.quantityshow == null) ? '' : obj.quantityshow;
                    var total_month = (obj.total_monthshow == null) ? '' : obj.total_monthshow;
                    var biaya = (obj.biayashow == null) ? '-' : obj.biayashow;
                    var ak_realisasi = (obj.ak_realisasi == null) ? '' : obj.ak_realisasi;
                    var qty_realisasi = (obj.qty_realisasi == null) ? '' : obj.qty_realisasi;
                    var output_realisasi = (obj.output_realisasi == null) ? '' : obj.output_realisasi;
                    var quality_realisasi = (obj.quality_realisasi == null) ? '' : obj.quality_realisasi;
                    var waktu_realisasi = (obj.waktu_realisasi == null) ? '' : obj.waktu_realisasi;
                    var biaya_realisasi = (obj.biaya_realisasi == null) ? '' : obj.biaya_realisasi;
                    var type_kegiatan = (obj.type_kegiatan == null) ? '' : obj.type_kegiatan;                                
                    
                    strhtml = strhtml + '<tr class="gradeX tambahan tambahan-new" id="row-' + obj.id + '">';
                    
                    strhtml = strhtml + '<td class="no"></td>';
                    strhtml = strhtml + '<td>' + obj.kegiatan  + '</td>';
                    strhtml = strhtml + '<td>' + ak + '</td>';
                    strhtml = strhtml + '<td>' + qty  + '</td>';
                    strhtml = strhtml + '<td width="10%">' + output  + '</td>';
                    strhtml = strhtml + '<td>' + quantity  + '</td>';
                    strhtml = strhtml + '<td>' + total_month  + '</td>';
                    strhtml = strhtml + '<td width="10%">Bulan</td>';
                    strhtml = strhtml + '<td>' + biaya  + '</td>';
                    strhtml = strhtml + '<td></td><td></td><td></td><td></td><td></td><td>Bulan</td><td></td><td></td><td>0.00</td>';
                   
                    // strhtml = strhtml + '<td><input type="text" class="form-control" id="biaya_realisasi" name="biaya_realisasi" value='+ biaya_realisasi +'></td>';
                    // strhtml = strhtml + '<td>264</td>';
                    // strhtml = strhtml + '<td>type kegiatan' + type_kegiatan + '</td>';

                    // strhtml = strhtml + '<td><a href="javascript:void(0)" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" onclick="onDelete(this)">delete</a><td>';


                    strhtml = strhtml + '</tr>';                            
                }
            });            
            $(".contains-body").html("");
            $(".contains-body").html(strhtml);
            reSortNumber('.tambahan-new');                        
        }

        function getIds(el, type){
            var ids = [];            
            //var el_tbody = $(el).parent().parent().parent();
            //var el_tr = $(el_tbody).children();
            var el_tr = $("table tr");
            console.log(el_tr);
            if (type = "tupoksi"){                                
                $(el_tr).each(function(i,obj){                
                    var attr_type_kegiatan = $(obj).attr("type-kegiatan");
                    if (attr_type_kegiatan == "tupoksi"){
                        var id_kegiatan = $(obj).attr("id-kegiatan");
                        ids.push(id_kegiatan);
                    }                       
                });
            }
            console.log(ids);
            return ids;
        }

        function isExistIds(ids, val){
            var is_exist = false;                
            if (ids.includes(val)) {                    
                is_exist = true;
            }            
            return is_exist;
        }

    </script>