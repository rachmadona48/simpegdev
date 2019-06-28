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

    input, select {
        border-color: red !important;
    }

    .fileUpload {
            position: relative;
            overflow: hidden;
            margin: 10px;
        }
        .fileUpload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        } 

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>
<?php if ($this->session->flashdata('info')) { ?>
    <div id="notifications">
        <?php echo $this->session->flashdata('info');?>
    </div>
<?php } ?>
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
                <h5 style="color:#ffffff">List SKP -> INPUT USULAN REALISASI</h5>
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
                        foreach ($skp_h as $key) {
                            # code...
                                echo $key->startdate;
                                echo "&nbsp; s/d &nbsp;";
                                echo $key->enddate;
                                echo "&nbsp; s/d &nbsp;";
                                echo $key->status_approvement;
                        }
                        ?>
                    <hr>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" >
                    <thead>
                    <tr >
                        <th rowspan="2">NO</th>
                        <th rowspan="2">I. KEGIATAN TUGAS POKOK JABATAN</th>
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
                    
                     <tbody class="existing-body">
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
                    <tr class="gradeX existing" height="20" id="row-<?php echo $value->id?>" >
                        <td height="10" class="center no"><?=$no_utama?></td>
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
                            <input type="text" class="form-control" id="ak_realisasi" name="ak_realisasi" value='<?=$value->ak_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="qty_realisasi" name="qty_realisasi" value='<?=$value->qty_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td width="10%">
                        <?php
                            $arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                            echo '<select class="form-control" id="output_realisasi" name="output_realisasi">';
                            foreach ($doc_type as $key => $values) {
                                if($values->id==$value->output_realisasi){
                                     echo '<option value="'.$values->id.'" selected>'.$values->name.'</option>';
                                }
                                else {
                                     echo '<option value="'.$values->id.'">'.$values->name.'</option>';
                                }
                            }
                            echo '</select>';
                           
                        ?>  
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="quality_realisasi" name="quality_realisasi" value='<?=$value->quality_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right" width="6%">
                            <?php
                            echo '<select class="form-control" id="waktu_realisasi" name="waktu_realisasi">';
                            for ($x = 1; $x <= 12; $x++) {
                                if ($x==$value->waktu_realisasi) {
                                 echo '<option value="'.$value->waktu_realisasi.'" selected>'.$value->waktu_realisasi.'</option>';
                                }
                                else {
                                    echo '<option value="'.$x.'">'.$x.'</option>';
                                }
                            } 
                            echo "</select>";
                            ?>
                            <!-- <input type="text" class="form-control" id="waktu_realisasi" name="waktu_realisasi" value='<?=$value->waktu_realisasi?>'> -->
                        </td>
                        <td>Bulan</td>
                        <td>
                            <input type="text" class="form-control" id="biaya_realisasi" name="biaya_realisasi" value='<?=$value->biaya_realisasi?>' onkeypress="allowNumbersOnly(event)">
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
                        $penghitungan = 0;
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
                        $capaian_skp = 0;
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

                        if ($penghitungan>0){
                            $penghitungan = number_format($penghitungan,2);
                        }
                        else {
                            $penghitungan = "-";
                        }
                        if ($capaian_skp>0){
                            $capaian_skp = number_format($capaian_skp,2);
                        }
                        else {
                            $capaian_skp = "-";
                        }
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
                    </tbody>
                     <tr height="20">
                        <td height="20" align="right">&nbsp;</td>
                        <td colspan="17"><b>II. UNSUR PENUNJANG <br/>TUGAS TAMBAHAN DAN KREATIVITAS :</b></td>
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
                     if ($value->type_kegiatan==$kegiatan_tambahan){ 
                        foreach ($skp_h as $key) {
                            # code...
                            if($key->status_approvement==STATUS_REALISASI_DITERIMA){
                        ?>
                  
                    <tr class="gradeX tambahan tambahan-existing" height="20" id="row-<?php echo $value->id?>" >
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
                        <td><?=$value->biayashow?></td>
                        <td align="right">
                            <input type="text" class="form-control" id="ak_realisasi" name="ak_realisasi" value='<?=$value->ak_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="qty_realisasi" name="qty_realisasi" value='<?=$value->qty_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td width="10%">
                          <?php
                            $arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                            echo '<select class="form-control" id="output_realisasi" name="output_realisasi">';
                            foreach ($doc_type as $key => $values) {
                                if($values->id==$value->output_realisasi){
                                     echo '<option value="'.$values->id.'" selected>'.$values->name.'</option>';
                                }
                                else {
                                     echo '<option value="'.$values->id.'">'.$values->name.'</option>';
                                }
                            }
                            echo '</select>';
                           
                        ?>  
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="quality_realisasi" name="quality_realisasi" value='<?=$value->quality_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right" width="6%">
                            <?php
                            echo '<select class="form-control" id="waktu_realisasi" name="waktu_realisasi">';
                            for ($x = 1; $x <= 12; $x++) {
                                if ($x==$value->waktu_realisasi) {
                                 echo '<option value=$value->waktu_realisasi selected>'.$value->waktu_realisasi.'</option>';
                                }
                                else {
                                    echo '<option value="'.$x.'">'.$x.'</option>';
                                }
                            } 
                            echo "</select>";
                            ?>
                            <!-- <input type="text" class="form-control" id="waktu_realisasi" name="waktu_realisasi" value='<?=$value->waktu_realisasi?>'> -->
                        </td>
                        <td>Bulan</td>
                        <td>
                            <input type="text" class="form-control" id="biaya_realisasi" name="biaya_realisasi" value='<?=$value->biaya_realisasi?>' onkeypress="allowNumbersOnly(event)">
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

                        $capaian_skp = number_format($capaian_skp,2);

                        ?>
                        <td align="right"><?=$penghitungan?></td>
                        <td align="right"><?=$capaian_skp?></td>
                    </tr>
                    <?php 
                        $no_tambahan++;
                        $count_tambahan++;
                        } }
                    } } // CEK STATUS REALISASI DITERIMA
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
                            <input type="text" class="form-control" id="ak_realisasi" name="ak_realisasi" value='<?=$value->ak_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="qty_realisasi" name="qty_realisasi" value='<?=$value->qty_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td width="10%">
                        <?php
                            $arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                            echo '<select class="form-control" id="output_realisasi" name="output_realisasi">';
                            foreach ($doc_type as $key => $values) {
                                if($values->id==$value->output_realisasi){
                                     echo '<option value="'.$values->id.'" selected>'.$values->name.'</option>';
                                }
                                else {
                                     echo '<option value="'.$values->id.'">'.$values->name.'</option>';
                                }
                            }
                            echo '</select>';
                           
                        ?>  
                        </td>
                        <td align="right">
                            <input type="text" class="form-control" id="quality_realisasi" name="quality_realisasi" value='<?=$value->quality_realisasi?>' onkeypress="allowNumbersOnly(event)">
                        </td>
                        <td align="right" width="6%">
                            <?php
                            echo '<select class="form-control" id="waktu_realisasi" name="waktu_realisasi">';
                            for ($x = 1; $x <= 12; $x++) {
                                if ($x==$value->waktu_realisasi) {
                                 echo '<option value=$value->waktu_realisasi selected>'.$value->waktu_realisasi.'</option>';
                                }
                                else {
                                    echo '<option value="'.$x.'">'.$x.'</option>';
                                }
                            } 
                            echo "</select>";
                            ?>
                            <!-- <input type="text" class="form-control" id="waktu_realisasi" name="waktu_realisasi" value='<?=$value->waktu_realisasi?>'> -->
                        </td>
                        <td>Bulan</td>
                        <td>
                            <input type="text" class="form-control" id="biaya_realisasi" name="biaya_realisasi" value='<?=$value->biaya_realisasi?>' onkeypress="allowNumbersOnly(event)">
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

                        $capaian_skp = number_format($capaian_skp,2);



                        ?>
                        <td align="right"><?=$penghitungan?></td>
                        <td align="right"><?=$capaian_skp?></td>
                    </tr>
                    <?php 
                        $no_kreatifitas++;
                        $count_kreatifitas++;
                        } }
                    } } // CEK STATUS REALISASI DITERIMA
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
                    <!-- <tfoot>
                
                    </tfoot> -->
                    </table>
                    <button type="button" class="btn btn-success btn-simpan">Kirim Usulan Realisasi</button>
                    
                    <!-- <button type="button" class="btn btn-info btn-ditolak" target="_blank">Ditolak</button> -->
                    <!-- <a href="<?php echo base_url() ?>index.php/skp/cetak_pengukuran?skp_id=<?=$skp_id?>&nrk=" class="btn btn-warning btn-cetak" target="_blank">Cetak</a> -->
                    
                    <?php
                     	//var_dump($infoUser);
    					//var_dump($_SESSION);
    				?>
                        </div> <!-- div table responsive-->           
                                
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



<!-- <?php echo $user_id; ?> -->

        
    <!-- Mainly scripts -->
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

    <!-- Data Tables -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Boostrap Validator -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>

    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/select2/select2.full.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Jquery Validate -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/validate/jquery.validate.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>
    <!-- DROPZONE -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dropzone/dropzone.js"></script>
   
    <script type="text/javascript">
       $(document).ready(function() {            
            $(".btn-simpan").click(function(){
                //alert('a');
                var arr_data = [];
                $(".gradeX").each(function(i,obj){
                    var el =$(obj).children();
                    var arr_id = $(obj).attr("id").split("-");
                    var id = arr_id[1];
                    console.log(id);
                    var arr_child = [];
                    $(el).each(function(j,objchld){
                        var elchild =$(objchld).children();
                        if ($(objchld).children()){
                            var inputel = $(objchld).find("input");
                            if ($(inputel).hasClass("form-control")){
                                newValue  = $(inputel).val();                                
                                arr_child.push(newValue);
                            }

                            var inputel = $(objchld).find("select");
                            if ($(inputel).hasClass("form-control")){
                                newValue  = $(inputel).val();                                
                                arr_child.push(newValue);
                            }
                        }                        
                    });
                    arr_data.push({id: id, values:arr_child});
                });

                // console.log(arr_data);
                $.ajax({
                    type: "POST",
                    data: {data:arr_data, skp_id: '<?php echo $skp_id ?>'},
                    url: "<?php echo base_url(); ?>index.php/skp/submit_pengukuran_realisasi_usulan",
                    success: function(msg){                    
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){
                            displayTable(json.data);
                            status_crud = "";
                            alert("Berhasil diupdate");
                            window.location.replace("<?php echo base_url()?>index.php/skp/list_pengukuran");
                        }
                    }
                });      
            });        
       });
   </script>
   <!-- Ditolak -->
   <script type="text/javascript">
       $(document).ready(function() {            
            $(".btn-ditolak").click(function(){
                //alert('test');
                $.ajax({
                    type: "POST",
                    data: {skp_id: '<?php echo $skp_id ?>',nrk_bawahan:'<?php echo $nrk_bawahan ?>'},
                    url: "<?php echo base_url(); ?>index.php/skp/tolak_pengukuran_realisasi",
                    success: function(msg){                    
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){
                            //displayTable(json.data);
                            status_crud = "";
                        }
                    }
                });      
            });        
       });
   </script>

   <script type="text/javascript">
//alert('tes');
   function fnClickAddRow(){
            var eltblbody =$(".contains-body").text();  
            var contain_body = eltblbody.replace(/\s+/g, '');            
            var el = $(".gradeX ").last();   
            //alert(el);         
            //var no = $("table .no").last().text();
            //alert(no);
            // var number= parseInt(no)+1;
            // if (isNaN(number)){
            //     number = 1;
            // }

            var html = '<tr class="gradeX tambahan tambahan-new">';
                html = html + '<td class="no"></td>';
                html = html + '<td><input type="text" name="kegiatan[]" class="form-control" /></td>';
                html = html + '<td><input type="text" name="ak[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                html = html + '<td><input type="text" name="quantity[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                var arr_select = ["Laporan","Dokumen","Surat","Berkas"];
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
                html = html + '<td><input id="uploadFile" placeholder="Choose File" disabled="disabled" class="form-control" /><div class="input-group-addon fileUpload btn btn-primary" style="background-color:#1ab394;color: #ffffff;"><span>Upload</span><input style="border:none!important" type="file" class="upload" name="lampiran[]"></div></td>';
                html = html + '<td class="action"><a href="javascript:void(0)" onclick="onDelete(this)">Delete</a></td>';
                html = html + '</tr>';
                        
            if (contain_body==""){
                $('.contains-body').html(html);
            }else{
                $(html).insertAfter(el);
            }
            $( ".dtpicker" ).datepicker();
            $("input,select").css("border-color","red");
            //$('.clockpicker').clockpicker();
            //$(".btn-submit").show();

             $(".btn-simpan").attr("disabled",true);
             $(".btn-ditolak").attr("disabled",true);
             $(".btn-cetak").attr("disabled",true);
             $(".btn-submit").attr("disabled",false);
             reSortNumber('.gradeX.tambahan');
    }

     function fnClickAddRow_kreatifitas(){
            var eltblbody =$(".contains-body_kreatifitas").text();  
            var contain_body = eltblbody.replace(/\s+/g, '');            
            var el = $(".gradeY ").last();   
            //alert(el);         
            // var no = $("table .gradeY .no").last().text();
            // //alert(no);
            // var number= parseInt(no)+1;
            // if (isNaN(number)){
            //     number = 1;
            // }

            console.log("===================1");
            var html = '<tr class="gradeY tambahan-new-kreatifitas">';
                html = html + '<td class="no"></td>';
                html = html + '<td><input type="text" name="kegiatan[]" class="form-control" /></td>';
                html = html + '<td><input type="text" name="ak[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                html = html + '<td><input type="text" name="quantity[]" class="form-control" onkeypress="allowNumbersOnly(event)"/></td>';
                var arr_select = ["Laporan","Dokumen","Surat","Berkas"];
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
                html = html + '<td><input id="uploadFile" placeholder="Choose File" disabled="disabled" class="form-control" /><div class="input-group-addon fileUpload btn btn-primary" style="background-color:#1ab394;color: #ffffff;"><span>Upload</span><input style="border:none!important" type="file" class="upload" name="lampiran[]"></div></td>';
                html = html + '<td class="action"><a href="javascript:void(0)" onclick="onDelete(this)">Delete</a></td>';
                html = html + '</tr>';            
            if (contain_body==""){
                console.log("===================3");
                $('.contains-body_kreatifitas').html(html);
            }else{
                console.log("===================4");
                $(html).insertAfter(el);
            }
            $( ".dtpicker" ).datepicker();
            $("input,select").css("border-color","red");
            //$('.clockpicker').clockpicker();
            //$(".btn-submit").show();

             $(".btn-simpan").attr("disabled",true);
             $(".btn-ditolak").attr("disabled",true);
             $(".btn-cetak").attr("disabled",true);
             $(".btn-submit").attr("disabled",false);

              reSortNumber('.gradeY');
    }
    function onSelectOutput(arr_data, val){            
            var str_html = '<select class="form-control">';
            $(arr_data).each(function(key,value){
                if (val==value){
                    str_html = str_html + '<option value="'+ value +'" selected>'+ value +'</option>';
                }else{
                    str_html = str_html + '<option value="'+ value +'">'+ value +'</option>';
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
            reSortNumber(".gradeY");                            
        }

        //Simpan Tugas Tambahan
        var status_crud = "";  
        $(document).ready(function() {            
            $(".btn-submit").click(function(){   
             // var el = $(".existing").last();
             // $("<tr><td colspan='18'>aaa</td></tr>").insertAfter(el);
                // if (status_crud=="edit"){                    
                //     alert('pastikan tidak sedang mengedit data');
                // }else{
                  //  $(".btn").attr("disabled",true);
                    save(this);
                //}
            })
        });

        function save(btn){
            // ambil data dari setiap class tr
            var arr_existing = getArrTable($(".existing"));
            var arr_add_existing = getArrTable($(".tambahan-existing"));
            var arr_add_new = getArrTable($(".tambahan-new"));
            var arr_add_existing_kreatifitas = getArrTable($(".tambahan-existing-kreatifitas"));
            var arr_add_new_kreatifitas = getArrTable($(".tambahan-new-kreatifitas"));

            // menampilkan nomor terakhir 
            reSortNumber($(".existing"));
            reSortNumber($(".tambahan"));
            reSortNumber(".gradeY"); 
            // console.log("===existing===");
            // console.log(arr_existing);
            // console.log("===tambahan-existing===");
            // console.log(arr_add_existing);
            // console.log("===tambahan-new===");
            // console.log("===tambahan-new-kreatifitas===");
            // console.log(arr_add_new_kreatifitas);
            // console.log("===tambahan-existing-kreatifitas===");
            // console.log(arr_add_existing_kreatifitas);

            // return;


                                      
            $.ajax({
                type: "POST",
                data: {existing:arr_existing, add_existing:arr_add_existing, add_new:arr_add_new, existing_kreatifitas:arr_add_existing_kreatifitas,new_kreatifitas:arr_add_new_kreatifitas, id:'<?php echo $skp_id ?>' },
                //url: "<?php echo base_url(); ?>index.php/skp/submit_skp",
                url: "<?php echo base_url(); ?>index.php/skp/add_skp_inisialisasi",
                success: function(msg){                                                                               
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){                        
                        displayTable(json.data);
                        status_crud = "";
                        $(".btn").attr("disabled",false);    
                        $(".new").remove();
                       //$(".btn-simpan").attr("disabled",true);
                        //$(".btn-ditolak").attr("disabled",true);
                        //$(".btn-cetak").attr("disabled",true);
                        $(".btn-submit").attr("disabled",true);
                                            
                    }
                }
            });      
        }

        function getArrTable(element){
            var arr_data = [];
             $(element).each(function(i,obj){
                var elchild = $(obj).children();
                elchild
                var arr_child = [];
                $(elchild).each(function(j,objchl){                        
                    var newValue = "";
                    if ($(objchl).children()){
                        var inputel = $(objchl).find("input");
                        if ($(inputel).hasClass("form-control")){
                            newValue  = $(inputel).val();                                
                            arr_child.push(newValue);
                        }

                        var inpute2 = $(objchl).find("select");
                        if ($(inpute2).hasClass("form-control")){
                            newValue  = $(inpute2).val();                                
                            arr_child.push(newValue);
                        }
                    }                         
                 });

                arr_data.push(arr_child);
            });    
            return arr_data;
        }

        function displayTable(data){

            var tambahanhtml = "";
            var kreatifitashtml = "";

            $(data).each(function(i,obj){ 
             //alert('test');die;
            
                var ak = (obj.ak == null) ? '' : obj.ak;
                var qty = (obj.quantityshow == null) ? '' : obj.quantityshow;
                var output = (obj.outputshow == null) ? '' : obj.outputshow;
                var quantity = (obj.quantityshow == null) ? '' : obj.quantityshow;
                var total_month = (obj.total_monthshow == null) ? '' : obj.total_monthshow;
                var biaya = (obj.biayashow == null) ? '' : obj.biayashow;
                var ak_realisasi = (obj.ak_realisasi == null) ? '' : obj.ak_realisasi;
                var qty_realisasi = (obj.qty_realisasi == null) ? '' : obj.qty_realisasi;
                var quality_realisasi = (obj.quality_realisasi == null) ? '' : obj.quality_realisasi;
                var waktu_realisasi = (obj.waktu_realisasi == null) ? '' : obj.waktu_realisasi;
                var biaya_realisasi = (obj.biaya_realisasi == null) ? '' : obj.biaya_realisasi;
                var type_kegiatan = (obj.type_kegiatan == null) ? '' : obj.type_kegiatan;                
                var strhtml = "";
                if (type_kegiatan==2){
                    strhtml = strhtml + '<tr class="gradeX" id="row-' + obj.id + '">';
                }else{
                    strhtml = strhtml + '<tr class="gradeY" id="row-' + obj.id + '">';
                }
                strhtml = strhtml + '<td class="no"></td>';
                strhtml = strhtml + '<td>' + obj.kegiatan  + '</td>';
                strhtml = strhtml + '<td>' + ak + '</td>';
                strhtml = strhtml + '<td>' + qty  + '</td>';
                strhtml = strhtml + '<td width="10%">' + output  + '</td>';
                strhtml = strhtml + '<td>' + quantity  + '</td>';
                strhtml = strhtml + '<td>' + total_month  + '</td>';
                strhtml = strhtml + '<td width="10%">Bulan</td>';
                strhtml = strhtml + '<td>' + biaya  + '</td>';
                strhtml = strhtml + '<td><input type="text" class="form-control" id="ak_realisasi" name="ak_realisasi" value='+ ak_realisasi +'></td>';
                strhtml = strhtml + '<td><input type="text" class="form-control" id="qty_realisasi" name="qty_realisasi" value='+ qty_realisasi +'></td>';
                strhtml = strhtml + '<td>Laporan</td>';
                strhtml = strhtml + '<td><input type="text" class="form-control" id="quality_realisasi" name="quality_realisasi" value='+ quality_realisasi +'></td>';
                strhtml = strhtml + '<td><input type="text" class="form-control" id="waktu_realisasi" name="waktu_realisasi" value='+ waktu_realisasi +'></td>';
               
                strhtml = strhtml + '<td>Bulan</td>';
                strhtml = strhtml + '<td><input type="text" class="form-control" id="biaya_realisasi" name="biaya_realisasi" value='+ biaya_realisasi +'></td>';
                strhtml = strhtml + '<td>264</td>';
                strhtml = strhtml + '<td>type kegiatan' + type_kegiatan + '</td>';

                // strhtml = strhtml + '<td><a href="javascript:void(0)" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" onclick="onDelete(this)">delete</a><td>';


                strhtml = strhtml + '</tr>';                
                if (type_kegiatan==2){
                    tambahanhtml = tambahanhtml+strhtml;
                }else if (type_kegiatan==3){
                    kreatifitashtml = kreatifitashtml+strhtml;
                }
            });            
            $(".contains-body").html("");
            $(".contains-body").html(tambahanhtml);

            $(".contains-body_kreatifitas").html("");
            $(".contains-body_kreatifitas").html(kreatifitashtml);
            reSortNumber('.gradeX');
            reSortNumber('.gradeY');
            
        }

        function allowNumbersOnly(e) {
        var code = (e.which) ? e.which : e.keyCode;
            if (code > 31 && (code < 48 || code > 57)) {
                e.preventDefault();
            }
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

   </script>
   <?php
    //var_dump($_SESSION);
    ?>