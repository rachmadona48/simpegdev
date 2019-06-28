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
        <h2>Cuti</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Cuti</strong>
            </li>
        </ol>
         <small><i>(Menu untuk proses cuti pimpinan)</i></small>
    </div>
</div>


<!-- validasi cuti pimpinan -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi Cuti Pimpinan</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row">
		            <div class="col-lg-12">
		                <div class="tabs-container">
		                    <ul class="nav nav-tabs">
		                        <li class="active"><a data-toggle="tab" href="#tab-1">Belum Validasi</a></li>
		                        <li class=""><a data-toggle="tab" href="#tab-2">Sudah Validasi</a></li>
		                    </ul>
		                    <div class="tab-content">
		                        <div id="tab-1" class="tab-pane active">
		                            <div class="panel-body">
		                            	<center><h3>Cuti Yang Belum Divalidasi</h3></center>
		                                <table id="tbl_atasan" class="table table-bordered table-striped table-hover">
		                                    <thead>
		                                        <tr>
		                                            <td align="left" width="3%"><b>No</b></td>
		                                            <td align="left" width="5%"><b>NRK</b></td>
		                                            <td align="left" width="10%"><b>NAMA</b></td>
		                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
		                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
		                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
		                                            <td align="left" width="10%"><b>Status</b></td>
		                                            <td align="left" width="20%"><b>Aksi</b></td>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <div id="spinner_tbl_atasan"></div>
		                                    </tbody>
		                                </table>
		                            </div>
		                        </div>
		                        <div id="tab-2" class="tab-pane">
		                            <div class="panel-body">
		                                <center><h3>Cuti Yang Sudah Divalidasi</h3></center>
		                                <table id="tbl_atasan_2" class="table table-bordered table-striped table-hover">
		                                    <thead>
		                                        <tr>
		                                            <td align="left" width="3%"><b>No</b></td>
		                                            <td align="left" width="5%"><b>NRK</b></td>
		                                            <td align="left" width="10%"><b>NAMA</b></td>
		                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
		                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
		                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
		                                            <td align="left" width="10%"><b>Status</b></td>
		                                            <td align="left" width="20%"><b>Aksi</b></td>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <div id="spinner_tbl_atasan_2"></div>
		                                    </tbody>
		                                </table>
		                            </div>
		                        </div>
		                    </div>

		                </div>
		            </div>
		        </div>
            </div> 
        </div> 

      </div> 
    </div>

</div>






<!-- start modal verif perubahan -->
<div class="modal fade" id="modal_verif_perubahan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <!-- <form id="defaultForm_verif_perubahan" name="defaultForm_verif_perubahan" enctype="multipart/form-data" method="post" class="form-horizontal"  action="javascript:save_verif_perubahan();" data-remote="true" data-toggle="validator" role="form"> -->
        <!-- <form id="defaultForm_verif_perubahan" enctype="multipart/form-data" method="post" class="form-horizontal" data-remote="true" data-toggle="validator" role="form"> -->
        <form class="form-horizontal" id="defaultForm_verif_perubahan" role="form" enctype="multipart/form-data" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Validasi untuk perubahan</h3>
            </div>
            <div class="modal-body">
                
                    <div class="row">
                        <!-- START SIDE 1 -->
                        



                        <div class="col-md-12">

                            <div class="form-group">
                              <label class="col-sm-4 control-label">Keterangan</label>
                              <div class="input-group col-sm-7">
                                    <input type="hidden" id="id_hist_verif_perubahan" name="id_hist_verif_perubahan" class="form-control">
                                    <input type="hidden" id="jencuti_verif_perubahan" name="jencuti_verif_perubahan" class="form-control">
                                    <textarea class="form-control" rows="5" id="ket_verif_perubahan" name="ket_verif_perubahan" placeholder="Keterangan"></textarea>
                                    

                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label">Nota Dinas</label>
                              <div class="input-group col-sm-7">
                              		<input type="file" id="gambar_verif_perubahan" name="gambar_verif_perubahan" class="form-control">

                                    <!-- <input type="file" id="nodin_verif_perubahan" name="nodin_verif_perubahan" class="form-control" onchange="base64_perubahan()"> -->
                                    <!-- <textarea class="form-control" rows="5" id="base64_verif_perubahan" name="base64_verif_perubahan" readonly="" style="display: none;"></textarea> -->
                              </div>
                            </div>

                        </div>

                        <!-- END SIDE 1 -->            
                    </div>                                                              
                   
                
            </div>
            <div class="modal-footer">
                <span class="pull-left">
                    <label class="msg_verif_perubahan text-success"></label>
                    <label class="err_verif_perubahan text-danger"></label>
                </span>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <!-- <button type="submit" class="btn btn-primary" id="btn_save_verif_perubahan" >Simpan</button> -->
                <button class="btn btn-primary" id="btn_save_verif_perubahan" type="submit">Simpan</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<!-- end modal verif perubahan -->

<!-- start modal ditangguhkan -->
<div class="modal fade" id="modal_verif_ditangguhkan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <!-- <form id="defaultForm_verif_ditangguhkan" name="defaultForm_verif_ditangguhkan" method="post" class="form-horizontal"  action="javascript:save_verif_ditangguhkan();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form"> -->
        <form class="form-horizontal" id="defaultForm_verif_ditangguhkan" role="form" enctype="multipart/form-data" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi untuk ditangguhkan</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_ditangguhkan" name="id_hist_verif_ditangguhkan" class="form-control">
                                <input type="hidden" id="jencuti_verif_ditangguhkan" name="jencuti_verif_ditangguhkan" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_ditangguhkan" name="ket_verif_ditangguhkan" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nota Dinas</label>
                          <div class="input-group col-sm-7">
                                <input type="file" id="gambar_verif_ditangguhkan" name="gambar_verif_ditangguhkan" class="form-control">

                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_ditangguhkan text-success"></label>
                <label class="err_verif_ditangguhkan text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_ditangguhkan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal ditangguhkan -->


<!-- start modal disetujui atasan -->
<div class="modal fade" id="modal_verif_setujui_atasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <!-- <form id="defaultForm_verif_setujui_atasan" name="defaultForm_verif_setujui_atasan" method="post" class="form-horizontal"  action="javascript:save_verif_setujui_atasan();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form"> -->

        <form class="form-horizontal" id="defaultForm_verif_setujui_atasan" role="form" enctype="multipart/form-data" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi disetujui</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_setujui_atasan" name="id_hist_verif_setujui_atasan" class="form-control">
                                <input type="hidden" id="jencuti_verif_setujui_atasan" name="jencuti_verif_setujui_atasan" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_setujui_atasan" name="ket_verif_setujui_atasan" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nota Dinas</label>
                          <div class="input-group col-sm-7">
                                <input type="file" id="gambar_verif_setujui_atasan" name="gambar_verif_setujui_atasan" class="form-control">

                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_setujui_atasan text-success"></label>
                <label class="err_verif_setujui_atasan text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_setujui_atasan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal disetujui atasan -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div id="widthForm" class="modal-dialog modal-lg" role="document" style="width: 80%;">
    <div class="modal-content animated fadeInUp" id="modal_content_detail">
        
    </div>
  </div>
</div>


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
    	$(document).ready(function (e) {

	        $("#defaultForm_verif_perubahan").on('submit',(function(e) {

	            e.preventDefault();
	            $.ajax({
	                url : '<?php echo site_url("cuti/save_verif_perubahan_pimpinan"); ?>',
	                type : 'post',
	                // data : {'nrk':nrk, 'id_lemari':id_lemari, 'gambar':gambar},
	                dataType : "JSON",
	                data:  new FormData(this),
	                contentType: false,
	                cache: false,
	                processData:false,
	                beforeSend : function(){

	                },
	                success : function(data){
	                    if(data.respone == 'SUKSES'){
                            $('#modal_verif_perubahan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_pimpinan();
                            tabel_pimpinan_2();    

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        } 
	                    
	                },
	                error : function (jqXHR, textStatus, errorThrown){
	                   swal("Gagal", "Proses Gagal", "error");
	                   // tabel_kategori1();
	                },
	                complete : function(data){
	                    // alert(data.response);
	                }
	            });
	        }));


	    });


        $(document).ready(function (e) {

            $("#defaultForm_verif_ditangguhkan").on('submit',(function(e) {

                // alert('tangguhkan')

                e.preventDefault();
                $.ajax({
                    url : '<?php echo site_url("cuti/save_verif_ditangguhkan_pimpinan"); ?>',
                    type : 'post',
                    // data : {'nrk':nrk, 'id_lemari':id_lemari, 'gambar':gambar},
                    dataType : "JSON",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function(){

                    },
                    success : function(data){
                        if(data.respone == 'SUKSES'){
                            $('#modal_verif_ditangguhkan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_pimpinan();
                            tabel_pimpinan_2();    

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        } 
                        
                    },
                    error : function (jqXHR, textStatus, errorThrown){
                       swal("Gagal", "Proses Gagal", "error");
                       // tabel_kategori1();
                    },
                    complete : function(data){
                        // alert(data.response);
                    }
                });
            }));


        });

        $(document).ready(function (e) {

            $("#defaultForm_verif_setujui_atasan").on('submit',(function(e) {

                // alert('tangguhkan')

                e.preventDefault();
                $.ajax({
                    url : '<?php echo site_url("cuti/save_verif_setujui_atasan_pimpinan"); ?>',
                    type : 'post',
                    // data : {'nrk':nrk, 'id_lemari':id_lemari, 'gambar':gambar},
                    dataType : "JSON",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function(){

                    },
                    success : function(data){
                        if(data.respone == 'SUKSES'){
                            $('#modal_verif_setujui_atasan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_pimpinan();
                            tabel_pimpinan_2();    

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        } 
                        
                    },
                    error : function (jqXHR, textStatus, errorThrown){
                       swal("Gagal", "Proses Gagal", "error");
                       // tabel_kategori1();
                    },
                    complete : function(data){
                        // alert(data.response);
                    }
                });
            }));


        });

    	


        $(document).ready(function(){



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

           
           tabel_pimpinan();
           tabel_pimpinan_2();
           


           /*START CHOSEN*/
            var config = {
              // '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              // '.chosen-pejtt'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
              // '.chosen-jensk'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"}

              '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              '.chosen-jbt_plt_plh'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              '.chosen-klk_plt_plh'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            /*END CHOSEN*/

       });
    </script>


   

    <script type="text/javascript">

        function tabel_pimpinan(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_atasan').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pimpinan')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_atasan').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_atasan").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_atasan-error").html("");
                            $("#tbl_atasan").append('<tbody class="tbl_atasan-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_atasan_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_atasan input').unbind();
                $('#tbl_atasan input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_pimpinan_2(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_atasan_2').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],

                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pimpinan_sudah_validasi')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_atasan_2').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_atasan_2").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_atasan_2-error").html("");
                            $("#tbl_atasan_2").append('<tbody class="tbl_atasan_2-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_atasan_2_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_atasan_2 input').unbind();
                $('#tbl_atasan_2 input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }


        function detail_cuti(id_hist,jencuti){
            // $('#modal_cuti').modal('show'); 
            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/detail_cuti')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti},
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#myModal').modal('toggle');
                         $('body').css('overflow', 'scroll');
                        $("#modal_content_detail").html('<div class="sk-spinner sk-spinner-three-bounce" style="width:110px;"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div></div>');
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){   
                            // alert(data.result);         
                            $("#modal_content_detail").html(data.result);
                            // $('input').attr('readonly', 'readonly');
                            if(data.widthForm == 'one'){
                                $('#widthForm').removeAttr('class').attr('class', '');                                
                                $('#widthForm').addClass('modal-dialog');
                            }else{
                                $('#widthForm').removeAttr('class').attr('class', '');
                                $('#widthForm').addClass('modal-dialog');
                                $('#widthForm').addClass('modal-lg');                                
                            }
                        }else{
                            // swal({type:"warning",title:"GAGAL", text:data.pesan});
                            $("#modal_content_detail").html('');
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            

                    }
                });
        }


        function verif_setujui_atasan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_setujui_atasan').val(id_hist); 
            $('#jencuti_verif_setujui_atasan').val(jencuti); 
            $('#modal_verif_setujui_atasan').modal('show'); 
        }

        function save_verif_setujui_atasan(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_setujui_atasan2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_setujui_atasan2(){
            var id_hist = $('#id_hist_verif_setujui_atasan').val(); 
            var jencuti = $('#jencuti_verif_setujui_atasan').val(); 
            var ket = $('#ket_verif_setujui_atasan').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_setujui_atasan')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_setujui_atasan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            // tabel_cuti();   
                            tabel_atasan(); 
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi();    
                            tabel_pyb_lokasi_luar_negeri();  
                            tabel_pyb_lokasi_luar_negeri_validasi();

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            

                    }
                });
        }


        function cetak_sk_cuti(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);

            window.open('<?=site_url('cuti')?>/cetak_sk/'+id_hist+'/'+jencuti);

        }



    </script>

    <script type="text/javascript">
        

        function verif_perubahan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_perubahan').val(id_hist); 
            $('#jencuti_verif_perubahan').val(jencuti); 
            $('#modal_verif_perubahan').modal('show'); 
        }

        function verif_ditangguhkan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_ditangguhkan').val(id_hist); 
            $('#jencuti_verif_ditangguhkan').val(jencuti); 
            $('#modal_verif_ditangguhkan').modal('show'); 
        }

        

        // function save_verif_perubahan(){

        //     swal({
        //       title: "Peringatan",
        //       text: "Apakah anda sudah yakin?",
        //       type: "warning",
        //       showCancelButton: true,
        //       confirmButtonColor: "#DD6B55",
        //       confirmButtonText: "Ya, Simpan!",
        //       cancelButtonText: "Tidak!",
        //       closeOnConfirm: false,
        //       closeOnCancel: false
        //     },
        //     function(isConfirm){
        //       if (isConfirm) {
        //         save_verif_perubahan2();
        //       } else {
        //             swal("BATAL", "Proses dibatalkan", "error");
        //       }
        //     });
        // }

        
        // function base64_perubahan(){
        //     var selectedFile = document.getElementById("nodin_verif_perubahan").files;
        //     if (selectedFile.length > 0) {
        //         var fileToLoad = selectedFile[0];
        //         var fileReader = new FileReader();
        //         var base64;
        //         fileReader.onload = function(fileLoadedEvent) {
        //             base64 = fileLoadedEvent.target.result;
        //             $('#base64_verif_perubahan').val(base64);
        //         };
        //         fileReader.readAsDataURL(fileToLoad);
        //     }
        // }

       

        // function save_verif_perubahan2(){
        //     var id_hist = $('#id_hist_verif_perubahan').val(); 
        //     var jencuti = $('#jencuti_verif_perubahan').val(); 
        //     var ket = $('#ket_verif_perubahan').val(); 
        //     var nodin = $('#nodin_verif_perubahan').val(); 

        //     var base64 = $('#base64_verif_perubahan').val();
    
        //     $.ajax({
        //             url : "<?php echo site_url('index.php/cuti/save_verif_perubahan_pimpinan')?>",
        //             type: "POST",
        //             data: {id_hist:id_hist,jencuti:jencuti,ket:ket,base64:base64},
        //             dataType: "JSON",
        //             beforeSend: function() {
        //                 if(id_hist == ""){
        //                     swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
        //                     return false;
        //                 }else{
        //                     // $("#errUsergruble").html();                    
        //                 }  

        //                 if(jencuti == ""){
        //                     swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
        //                     return false;
        //                 }else{
        //                     // $("#errUsergruble").html();                    
        //                 }

        //                 if(ket == ""){
        //                     swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
        //                     return false;
        //                 }else{
        //                     // $("#errUsergruble").html();                    
        //                 } 

        //                 if(nodin == "" ||base64 == ""){
        //                     swal({type:"warning",title:"GAGAL", text:"Nota dinas belum dipilih"})
        //                     return false;
        //                 }else{
        //                     // $("#errUsergruble").html();                    
        //                 } 

                        

        //             },
        //             success: function(data)
        //             {
                       
        //                if(data.respone == 'SUKSES'){
        //                     $('#modal_verif_perubahan').modal('hide'); 
        //                     swal({type:"success",title:"BERHASIL", text:data.pesan});
        //                     tabel_pimpinan();
        //                     tabel_pimpinan_2();    

        //                 }else{
                            
        //                     swal({type:"warning",title:"GAGAL", text:data.pesan});
        //                 }                       
                       
        //             },
        //             error: function (jqXHR, textStatus, errorThrown)
        //             {
        //                 swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
        //             },
        //             complete: function() {                            

        //             }
        //         });
        // }

        
    </script>


    



