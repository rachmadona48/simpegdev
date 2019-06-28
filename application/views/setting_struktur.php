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

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setting Struktur</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Setting Struktur</strong>
            </li>
        </ol>
         <small><i>(Menu untuk setting struktur pegawai)</i></small>
    </div>
</div>




<!-- <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            
        </div> 
      </div> 
    </div>
</div> -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" id="headerBox2">
                                         
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-sitemap"></i>
                            Struktur Kepegawaian <?php echo $unit->NAMA_SKPD; ?>                                                                                        
                        </div>
                        <div class="tools">
                            <a class="collapse" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="portlet-body" >

            <!-- <?php                
                    $query="SELECT  p.* 
                            from pegawai_new p 
                            where kolok_".$fieldn." = '".$kolok."' AND (kojab_".$fieldn." ilike '000000' OR bko_".$fieldn." = 'PLT') and p.tahun = '".$tahun."'";   

                            // echo $query;exit();          
                            // echo 'dddddddd';exit();

                            $result = @pg_query($con,$query);
                            $rows = @pg_fetch_array($result);
                            $nip_kadis=$rows['nip18'];
                            $nrk_kadis=$rows['nrk'];
                            $kolok_kadis=$rows['kolok_'.$fieldn];
                            $kojab_kadis=$rows['kojab_'.$fieldn];
                            $spmu_kadis=$rows['spmu_'.$fieldn];
            ?> -->
                    <div class="alert alert-info">
                        <div class="row">

             <?php               
             // if($pimpinan->STATUS != 'KEPALA'){
             //    $sts='-'.$pimpinan->STATUS;
             // }else{
             //    $sts='';
             // }
                            echo '<div class="col-md-12"><u>'.$unit->LEVEL1.'</u> : 
                                    <ul>
                                        <li id="kepala_'.$pimpinan->NIP18.'">
                                            <b>'.$pimpinan->NAMA.'</b> &nbsp; ('.$pimpinan->NIP18.')
                                        </li>
                                    </ul>
                                </div>';
            ?>
                    
<!--
            <?php                                   
                            $query2 = "SELECT
                                            P .nama, P. nip18,  P. jabatan
                                        FROM
                                            vw_kepala_bawahan K,
                                            pegawai_new P
                                        WHERE
                                            P .nip18 = K .nip_bawahan
                                        AND nip_atasan = '".$nip_kadis ."'
                                        AND K. thbl = '".$tahunbulan."'
                                        AND K. tabel = 'kadis_wakil'
                                        and P. tahun = '".$tahun."'";
                                                    
                                        // echo $query2;exit();

                                        
                                        $result2 = @pg_query($con,$query2);
                                        if(pg_num_rows($result2))
                                        {
                                            
                                                echo '<div class="col-md-12"><u>Wakil/Sekretaris</u></div>';
                                                echo '<div class="col-md-12">';
                                                    echo "<ul>";
                                                        $string = "Anda yakin menghapus data pegawai tersebut?";
                                                        while($rows2 = @pg_fetch_array($result2))
                                                        {                                               
                                                            $hapus = '<a class="btn btn-danger btn-xs black" onclick="confirm(\''.$string.'\') ? hapus_wakil(\''.$_GET['token'].'\',\''.$nip_kadis.'\',\''.$rows2['nip18'].'\', \''.$tahunbulan.'\') : 0 "><i class="fa fa-trash-o"></i></a>';
                                                            echo "<li id='wakil_".$rows2['nip18']."'>
                                                                    <b>".$rows2['nama']."</b>(".$rows2['nip18'] .") &nbsp; : &nbsp; ".$rows2['jabatan']."  ".$hapus."
                                                                </li>";
                                                        }
                                                    echo "</ul>";
                                                echo '</div>';
                                            
                                        } 
                                         
            ?> -->
                            <div class="col-md-12">                 
                                <a type="button" data-toggle="modal" class="btn btn-xs btn-primary" onclick="myModalWakil()"><i class="fa fa-plus"></i>Tambah Wakil/Asisten</a>
                            </div>
                        </div>          
                    </div>
                                    
                                            
                    <div class="table-responsive">
                        <table class="table  table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th colspan="3"><?php echo $unit->LEVEL2; ?></th>
                                <th>Jabatan</th>
                                <th>                    
                                    <!-- <a type="button" data-toggle="modal" data-target="#myModalLevel2" class="btn btn-xs btn-primary" onclick="$('#kabid_old').html('');$('#nip_old').html('');$('.ubah').hide();$('.tambah').show();"><i class="fa fa-plus"></i>Tambah <?php echo $unit->LEVEL2; ?></a> -->
                                    <!-- <input type="text" class="form-control" id="action_kabid" name="action_kabid" readonly="" value="insert"> -->
                                    <a type="button" data-toggle="modal" class="btn btn-xs btn-primary" onclick="myModalLevel2()"></i>Tambah <?php echo $unit->LEVEL2; ?></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        <!-- <?php var_dump($kabid); ?> -->

                        <?php foreach ($kabid as $ka_bid) { ?>
                            <tr id="3kadis_<?php echo $ka_bid->TABEL.'_'.$ka_bid->NIP18 ?>">
                                <td class="hidden-xs" colspan="5">&nbsp;</td>
                            </tr>
                            <tr style="background-color:#c1ffe3" id="kadis_<?php echo $ka_bid->TABEL.'_'.$ka_bid->NIP18 ?>">
                                <td colspan="3" ><b><?php echo $ka_bid->NAMA ?></b><br><?php echo $ka_bid->NIP18 ?></td>
                                <td><b><?php echo $ka_bid->JABATAN?></b></td>
                                <td>        
                                <?php if($ka_bid->TABEL == 'kepala_kadis'){ ?>
                                     <a type="button" data-toggle="modal" class="btn btn-xs btn-warning" onclick="myModalLevel2Ubah('<?php echo $ka_bid->NIP18 ?>','<?php echo $ka_bid->NAMA ?>')"><i class="fa fa-pencil"></i>Ubah</a>  
                                    &nbsp;
                                    <a class="btn btn-danger btn-xs black"  onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_kepala('<?php echo $pimpinan->NIP18 ?>','<?php echo $ka_bid->NIP18 ?>') : ''"><i class="fa fa-trash-o"></i> Delete</a> 
                                <?php } elseif ($ka_bid->TABEL == 'kepala_staff') { ?>
                                    <a class="btn btn-danger btn-xs black"  onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_staff('<?php echo $pimpinan->NIP18 ?>','<?php echo $ka_bid->NIP18 ?>') : ''"><i class="fa fa-trash-o"></i> Delete</a>
                                <?php }?>
                            </td>
                            </tr>

                            <?php if($ka_bid->TABEL == 'kepala_kadis'){ ?>      
                                <tr id="2kadis_<?php echo $ka_bid->TABEL.'_'.$ka_bid->NIP18  ?>">
                                    <td colspan="5">
                                        <a  class="btn btn-info btn-xs black" onclick="tampil_kasi('<?php echo $ka_bid->NIP18;  ?>','td_kabid_<?php echo $ka_bid->NIP18;  ?>','<?php echo $pimpinan->SPMU; ?>','<?php echo $ka_bid->KOLOK; ?>')"><i class="fa fa-sitemap"></i> Tampilkan <?php echo $unit->LEVEL3; ?> </a>

                                        <a  class="btn btn-danger btn-xs black" onclick="tutup_kasi('td_kabid_<?php echo $ka_bid->NIP18;  ?>')"><i class="fa fa-times"></i> Tutup </a>

                                        <div id="td_kabid_<?php echo $ka_bid->NIP18 ?>"></div>
                                    </td>
                                </tr>
                            <?php }else{ ?>
                                <tr id="2kadis_<?php echo $ka_bid->TABEL.'_'.$ka_bid->NIP18 ?>"><td colspan="5">&nbsp;</td></tr>
                            <?php } ?>

                        <?php   } ?>
                        
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>


<!-- WAKIL -->
<div class="modal inmodal" id="myModalWakil" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 75%;">
        <div class="modal-content animated fadeIn">       
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                            
                <h4 class="modal-title">Pilih Asisten <?php echo $unit->LEVEL1 ?>.</h4>                                            
            </div>                                 
            <div class="modal-body">

                    <input type="hidden" class="form-control" id="nip_kadis" name="nip_kadis" readonly="" value="<?php echo $pimpinan->NIP18; ?>">

                    <input type="hidden" class="form-control" id="kolok_kadis" name="kolok_kadis" readonly="" value="<?php echo $pimpinan->KOLOK; ?>">

                    <input type="hidden" class="form-control" id="kojab_kadis" name="kojab_kadis" readonly="" value="<?php echo $pimpinan->KOJAB; ?>">

                    <input type="hidden" class="form-control" id="nrk_kadis" name="nrk_kadis" readonly="" value="<?php echo $pimpinan->NRK; ?>">

                    <input type="hidden" class="form-control" id="spmu_pimpinan" name="spmu_pimpinan" readonly="" value="<?php echo $pimpinan->SPMU; ?>">

                    <input type="hidden" class="form-control" id="kolok1" name="kolok1" readonly="" value="<?php echo $unit->KOLOK; ?>">                                                                                        
                    <!-- <table class="table table-striped table-bordered table-advance table-hover dataTables-wakil"> -->
                    <table id="table_Wakil" class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <th>NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="spinner_table_Wakil"></div>
                                                                                                                     
                    </tbody>
                    </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- WAKIL -->


<!-- LEVEL 2 -->
<div class="modal inmodal" id="myModalLevel2" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 75%;">
        <div class="modal-content animated fadeIn">                                        
            <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                             
                <div class="panel blank-panel">
                    <div class="panel-heading">                                                 
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Kabag</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Kasubag</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3">Staff</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <center>
                                    <h4>Pilih <?php echo $unit->LEVEL2 ?></h4>
                                </center>
                                <br>
                                <div>

                                    <input type="hidden" class="form-control" id="nip_kadis2" name="nip_kadis2" readonly="" value="<?php echo $pimpinan->NIP18; ?>">

                                    <input type="hidden" class="form-control" id="kolok_kadis2" name="kolok_kadis2" readonly="" value="<?php echo $pimpinan->KOLOK; ?>">

                                    <input type="hidden" class="form-control" id="kojab_kadis2" name="kojab_kadis2" readonly="" value="<?php echo $pimpinan->KOJAB; ?>">

                                    <input type="hidden" class="form-control" id="nrk_kadis2" name="nrk_kadis2" readonly="" value="<?php echo $pimpinan->NRK; ?>">

                                    <input type="hidden" class="form-control" id="spmu_pimpinan2" name="spmu_pimpinan2" readonly="" value="<?php echo $pimpinan->SPMU; ?>">

                                    <input type="hidden" class="form-control" id="kolok2" name="kolok2" readonly="" value="<?php echo $unit->KOLOK; ?>">

                                    <table id="tabel_kabag" class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tabel_kabag"></div>
                                    </tbody>
                                    </table>
                                </div>                                                          
                            </div>

                            <div id="tab-2" class="tab-pane">
                                <center><h4>Pilih <?php echo $unit->LEVEL3 ?></h4></center>


                                <input type="hidden" class="form-control" id="nip_kadis3" name="nip_kadis3" readonly="" value="<?php echo $pimpinan->NIP18; ?>">

                                <input type="hidden" class="form-control" id="kolok_kadis3" name="kolok_kadis3" readonly="" value="<?php echo $pimpinan->KOLOK; ?>">

                                <input type="hidden" class="form-control" id="kojab_kadis3" name="kojab_kadis3" readonly="" value="<?php echo $pimpinan->KOJAB; ?>">

                                <input type="hidden" class="form-control" id="nrk_kadis3" name="nrk_kadis3" readonly="" value="<?php echo $pimpinan->NRK; ?>">

                                <input type="hidden" class="form-control" id="spmu_pimpinan3" name="spmu_pimpinan3" readonly="" value="<?php echo $pimpinan->SPMU; ?>">

                                <input type="hidden" class="form-control" id="kolok3" name="kolok3" readonly="" value="<?php echo $unit->KOLOK; ?>">


                                <table id="tabel_kasubag" class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs">NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div id="spinner_tabel_kasubag"></div>
                                
                                </tbody>
                                </table>
                                

                            </div>

                            <div id="tab-3" class="tab-pane">
                                <center><h4>Pilih Staff</h4></center>

                                <input type="hidden" class="form-control" id="nip_kadis4" name="nip_kadis4" readonly="" value="<?php echo $pimpinan->NIP18; ?>">

                                <input type="hidden" class="form-control" id="kolok_kadis4" name="kolok_kadis4" readonly="" value="<?php echo $pimpinan->KOLOK; ?>">

                                <input type="hidden" class="form-control" id="kojab_kadis4" name="kojab_kadis4" readonly="" value="<?php echo $pimpinan->KOJAB; ?>">

                                <input type="hidden" class="form-control" id="nrk_kadis4" name="nrk_kadis4" readonly="" value="<?php echo $pimpinan->NRK; ?>">

                                <input type="hidden" class="form-control" id="spmu_pimpinan4" name="spmu_pimpinan4" readonly="" value="<?php echo $pimpinan->SPMU; ?>">

                                <input type="hidden" class="form-control" id="kolok4" name="kolok4" readonly="" value="<?php echo $unit->KOLOK; ?>">


                                <table id="tabel_pegawai" class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs">NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <div id="spinner_tabel_pegawai"></div>
                                
                                </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
                
                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- LEVEL 2 -->


<!-- LEVEL 2 UBAH -->
<div class="modal inmodal" id="myModalLevel2Ubah" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 75%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                            
                <h4 class="modal-title">Pilih <?php echo $unit->LEVEL2 ?></h4>
                <strong id="kabid_old"></strong>
                <input type="hidden" name="nip_kabag_old" id="nip_kabag_old" value="">
            </div>
            <div class="modal-body" id="td_pilih_kabag">
            	<div class="panel-body">

                    <input type="hidden" class="form-control" id="spmu_pimpinan2_ubah_kabag" name="spmu_pimpinan2_ubah_kabag" readonly="" value="<?php echo $pimpinan->SPMU; ?>">

	            	<table id="tabel_kabag_ubah" class="table table-striped table-bordered table-advance table-hover">
	                    <thead>
	                        <tr>
	                            <th>NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <div id="spinner_tabel_kabag_ubah"></div>
	                    </tbody>
	                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- LEVEL 2 UBAH-->







<!-- END WRAPPER CONTENT -->
    
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

    <script>
        $(document).ready(function(){

            $('.dataTables-example').dataTable({      
                "lengthMenu": [ 5, 10, 25, 50, 75, 100 ],
                "displayLength": 5,
            });

            $('.dataTables-level3').dataTable({      
                "lengthMenu": [ 5, 10, 25, 50, 75, 100 ],
                "displayLength": 5,
            });    

            $('.dataTables-wakil').dataTable({      
                "lengthMenu": [ 5, 10, 25, 50, 75, 100 ],
                "displayLength": 5,
            }); 

            $('#data_8 .input-group.date').datepicker({
                viewMode: "years", 
                minViewMode: "years",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy",
                endDate : 'y'
            });

            $('#data_1 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
            });

            $('#data_2 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
            });

           // tabel_cuti();
           // tabel_atasan();
           // tabel_pyb();
           // tabel_pyb_lokasi_luar_negeri();


           /*START CHOSEN*/
            var config = {
              // '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              // '.chosen-pejtt'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
              // '.chosen-jensk'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"}

              '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            /*END CHOSEN*/

       });
    </script>
   

    <script type="text/javascript">

        function myModalWakil(){
            tabelWakil();
            $('#myModalWakil').modal('show');
        }

        function tabelWakil(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#table_Wakil').DataTable( {
                // "columns": [
                //           null,
                //           null,
                //           null,
                //           null,
                //           null,
                //           null
                //           ],
                responsive: false,
                bAutoWidth: true, 
                destroy: true,
                // "bProcessing": true,
                "scrollX": true,
                "serverSide": true,
                "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                "ajax":{
                    url :"<?php echo site_url('index.php/Setting_struktur/table_wakil')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_pimpinan = $('#spmu_pimpinan').val();
                        d.kolok1 = $('#kolok1').val();
                        d.nip_kadis = $('#nip_kadis').val();
                        d.kolok_kadis = $('#kolok_kadis').val();
                        d.kojab_kadis = $('#kojab_kadis').val();
                        d.nrk_kadis = $('#nrk_kadis').val();

                    },
                    beforeSend: function(){
                        $('#spinner_table_Wakil').html(spinner);
                    },complete: function(){
                             $("#spinner_table_Wakil").html('');
                    },
                    error: function(){  // error handling
                        $(".table_Wakil-error").html("");
                        $("#table_Wakil").append('<tbody class="table_Wakil-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#table_Wakil_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#table_Wakil input').unbind();
            $('#table_Wakil input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_wakil(nip_kadis,kolok_kadis,kojab_kadis,nrk_kadis,nip18_wakil,kolok_wakil,kojab_wakil,nrk_wakil,spmu_kadis,spmu_wakil){
        // alert('pilih wakil : '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_wakil')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,kolok_kadis:kolok_kadis,kojab_kadis:kojab_kadis ,nrk_kadis:nrk_kadis,nip18_wakil:nip18_wakil,kolok_wakil:kolok_wakil,kojab_wakil:kojab_wakil,nrk_wakil:nrk_wakil,spmu_kadis:spmu_kadis,spmu_wakil:spmu_wakil},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });

    }

    // function pilih_wakil(nip_kadis,kolok_kadis){
    //     alert(nip_kadis+':'+kolok_kadis)
    // }

    function myModalLevel2(){
    	// var action = 'insert';
        tabel_kabag();
        tabel_kasubag();
        tabel_pegawai();
        // $('#action_kabid').val(action);
        $('#myModalLevel2').modal('show');
    }


    function myModalLevel2Ubah(nip_old,nama_old){
    	// alert('ddd');
    	$('#nip_kabag_old').val(nip_old);
    	$('#kabid_old').html('Pengganti '+nama_old+' ('+nip_old+')');
    	tabel_kabag_ubah();
        $('#myModalLevel2Ubah').modal('show');
    }

    function tabel_kabag(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_kabag').DataTable( {
                // "columns": [
                //           null,
                //           null,
                //           null,
                //           null,
                //           null,
                //           null
                //           ],
                responsive: false,
                bAutoWidth: true, 
                destroy: true,
                // "bProcessing": true,
                "scrollX": true,
                "serverSide": true,
                "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                "ajax":{
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_kabag')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_pimpinan = $('#spmu_pimpinan2').val();
                        d.kolok1 = $('#kolok2').val();
                        d.nip_kadis = $('#nip_kadis2').val();
                        d.kolok_kadis = $('#kolok_kadis2').val();
                        d.kojab_kadis = $('#kojab_kadis2').val();
                        d.nrk_kadis = $('#nrk_kadis2').val();

                    },
                    beforeSend: function(){
                        $('#spinner_tabel_kabag').html(spinner);
                    },complete: function(){
                             $("#spinner_tabel_kabag").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_kabag-error").html("");
                        $("#tabel_kabag").append('<tbody class="tabel_kabag-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_kabag_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_kabag input').unbind();
            $('#tabel_kabag input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function tabel_kabag_ubah(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_kabag_ubah').DataTable( {
                // "columns": [
                //           null,
                //           null,
                //           null,
                //           null,
                //           null,
                //           null
                //           ],
                responsive: false,
                bAutoWidth: true, 
                destroy: true,
                // "bProcessing": true,
                "scrollX": true,
                "serverSide": true,
                "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                "ajax":{
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_kabag_ubah')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_pimpinan = $('#spmu_pimpinan2_ubah_kabag').val();
                        d.nip_kabag_old = $('#nip_kabag_old').val();

                    },
                    beforeSend: function(){
                        $('#spinner_tabel_kabag_ubah').html(spinner);
                    },complete: function(){
                             $("#spinner_tabel_kabag_ubah").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_kabag_ubah-error").html("");
                        $("#tabel_kabag_ubah").append('<tbody class="tabel_kabag_ubah-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_kabag_ubah_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_kabag_ubah input').unbind();
            $('#tabel_kabag_ubah input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_kabid(nip_kadis,kolok_kadis,kojab_kadis,nrk_kadis,nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kadis,spmu_kepala){
        // alert('pilih kabid 1: '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_kabid')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,kolok_kadis:kolok_kadis,kojab_kadis:kojab_kadis ,nrk_kadis:nrk_kadis,nip18_kepala:nip18_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala,nrk_kepala:nrk_kepala,spmu_kadis:spmu_kadis,spmu_kepala:spmu_kepala},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }

    function pilih_kabid_ubah(nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kepala,nip_kabag_old){
    	// alert(nip18_kepala+' : '+kolok_kepala+' : '+kojab_kepala+' : '+nrk_kepala+' : '+spmu_kepala+' : '+nip_kabag_old);
    	$.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_kabid_ubah')?>",
            type: "POST",
            data: {nip18_kepala:nip18_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala,nrk_kepala:nrk_kepala,spmu_kepala:spmu_kepala,nip_kabag_old:nip_kabag_old},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


    function tabel_kasubag(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_kasubag').DataTable( {
                // "columns": [
                //           null,
                //           null,
                //           null,
                //           null,
                //           null,
                //           null
                //           ],
                responsive: false,
                bAutoWidth: true, 
                destroy: true,
                // "bProcessing": true,
                "scrollX": true,
                "serverSide": true,
                "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                "ajax":{
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_kasubag')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_pimpinan = $('#spmu_pimpinan3').val();
                        d.kolok1 = $('#kolok3').val();
                        d.nip_kadis = $('#nip_kadis3').val();
                        d.kolok_kadis = $('#kolok_kadis3').val();
                        d.kojab_kadis = $('#kojab_kadis3').val();
                        d.nrk_kadis = $('#nrk_kadis3').val();

                    },
                    beforeSend: function(){
                        $('#spinner_tabel_kasubag').html(spinner);
                    },complete: function(){
                             $("#spinner_tabel_kasubag").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_kasubag-error").html("");
                        $("#tabel_kasubag").append('<tbody class="tabel_kasubag-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_kasubag_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_kasubag input').unbind();
            $('#tabel_kasubag input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_kasi(nip_kadis,kolok_kadis,kojab_kadis,nrk_kadis,nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kadis,spmu_kepala){
        // alert('pilih kasi: '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_kasi')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,kolok_kadis:kolok_kadis,kojab_kadis:kojab_kadis ,nrk_kadis:nrk_kadis,nip18_kepala:nip18_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala,nrk_kepala:nrk_kepala,spmu_kadis:spmu_kadis,spmu_kepala:spmu_kepala},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });

    }


    function tabel_pegawai(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_pegawai').DataTable( {
                // "columns": [
                //           null,
                //           null,
                //           null,
                //           null,
                //           null,
                //           null
                //           ],
                responsive: false,
                bAutoWidth: true, 
                destroy: true,
                // "bProcessing": true,
                "scrollX": true,
                "serverSide": true,
                "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                "ajax":{
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_pegawai')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_pimpinan = $('#spmu_pimpinan4').val();
                        d.kolok1 = $('#kolok4').val();
                        d.nip_kadis = $('#nip_kadis4').val();
                        d.kolok_kadis = $('#kolok_kadis4').val();
                        d.kojab_kadis = $('#kojab_kadis4').val();
                        d.nrk_kadis = $('#nrk_kadis4').val();

                    },
                    beforeSend: function(){
                        $('#spinner_tabel_pegawai').html(spinner);
                    },complete: function(){
                             $("#spinner_tabel_pegawai").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_pegawai-error").html("");
                        $("#tabel_pegawai").append('<tbody class="tabel_pegawai-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_pegawai_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_pegawai input').unbind();
            $('#tabel_pegawai input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_pegawai(nip_kepala,kolok_kepala,kojab_kepala,nrk_kepala,nip18_staff,kolok_staff,kojab_staff,nrk_staff,spmu_kepala,spmu_staff){
        // alert('pilih pegawai: '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_pegawai')?>",
            type: "POST",
            data: {nip_kepala:nip_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala ,nrk_kepala:nrk_kepala,nip18_staff:nip18_staff,kolok_staff:kolok_staff,kojab_staff:kojab_staff,nrk_staff:nrk_staff,spmu_kepala:spmu_kepala,spmu_staff:spmu_staff},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });

    }

    function hapus_kepala(nip_kadis,nip_kepala){
    	var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/hapus_kepala')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,nip_kepala:nip_kepala},
            dataType: "JSON",
            beforeSend: function() {
                $('#spinner_tabel_kabag').html(spinner);
            },
            success: function(data)
            {
            	$('#spinner_tabel_kabag').html();
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
            	$('#spinner_tabel_kabag').html();
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


    function hapus_staff(nip_kadis,nip_kepala){
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/hapus_staff')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,nip_kepala:nip_kepala},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                location.reload();                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


    function tampil_kasi(nip18,target_kabid,spmu_kadis,kolok){
        // alert(target_kabid);
        $('#'+target_kabid).show();
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/tampil_kasi')?>",
            type: "POST",
            data: {nip18:nip18,target_kabid:target_kabid,spmu_kadis:spmu_kadis,kolok:kolok},
            dataType: "JSON",
            beforeSend: function() {
                $('#'+target_kabid).html(spinner);
            },
            success: function(data)
            {
                $('#'+target_kabid).html('');
                // location.reload(); 
                // alert(data.response);
                if(data.response=='SUKSES'){
                    // alert(data.result);

                    $('#'+target_kabid).html(data.result);
                }                    
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#'+target_kabid).html('');
                // swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }

    function tutup_kasi(target_kabid){
        $('#'+target_kabid).hide();
    }


    
    	




    </script>
    


    



