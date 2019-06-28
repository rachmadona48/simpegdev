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
        <h2>Libur Nasional</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Master Libur</strong>
            </li>
        </ol>
         <small><i>(Menu untuk data master libur nasional)</i></small>
    </div>
</div>




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Libur Nasional</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                <div class='pull-right'><button type='button' class='btn btn-primary btn-sm btn-block m-t' onclick="form_libur()"><i class='fa fa-plus'></i> Tambah Data</button></div>

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_libur" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="left" width="3%"><b>No</b></td>
                                            <td align="left" width="22%"><b>Tanggal</b></td>
                                            <td align="left" width="60%"><b>Keterangan</b></td>
                                            <td align="left" width="15%"><b>Aksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tbl_cuti"></div>
                                    </tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->




</div>


<!-- Start Modal -->


<div class="modal fade" id="modal_libur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Form Libur Nasional</h4>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    <div class="col-md-12">
                        <!-- <div class="form-group">
                            <label class="col-sm-4 control-label"><font color="blue">NRK</font></label>
                            <div class="col-sm-7">
                                <input type="text" id="nrk" name="nrk" placeholder="NRK" class="form-control" value="<?php echo isset($nrk) ? $nrk : '' ?>" readOnly="true">
                            </div>
                        </div> -->
                        <!-- <div class="hr-line-dashed"></div> -->

                        

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Tanggal</font></label>
                            <div class="input-group col-sm-7 date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgl"  name="tgl" placeholder="Tanggal" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><font color="blue">Keterangan</font></label>
                            <div class="input-group col-sm-7">
                                <textarea class="form-control" rows="5" id="ket" name="ket"></textarea>
                            </div>
                        </div>


                        <!-- <div class="hr-line-dashed"></div> -->
                    </div>
                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg text-success"></label>
                <label class="err text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>



<div class="modal fade" id="modal_libur_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <form id="defaultForm2_update" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save_update();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Form Update Libur Nasional</h4>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    <div class="col-md-12">
                        <!-- <div class="form-group">
                            <label class="col-sm-4 control-label"><font color="blue">NRK</font></label>
                            <div class="col-sm-7">
                                <input type="text" id="nrk" name="nrk" placeholder="NRK" class="form-control" value="<?php echo isset($nrk) ? $nrk : '' ?>" readOnly="true">
                            </div>
                        </div> -->
                        <!-- <div class="hr-line-dashed"></div> -->

                        
                        <input type="hidden" id="id_update"  name="id_update" class="form-control" readonly="">
                        <div class="form-group pickerpicker" id="data_update1">
                            <label class="col-sm-3 control-label"><font color="blue">Tanggal</font></label>
                            <div class="input-group col-sm-7 date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgl_update"  name="tgl_update" placeholder="Tanggal" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><font color="blue">Keterangan</font></label>
                            <div class="input-group col-sm-7">
                                <textarea class="form-control" rows="5" id="ket_update" name="ket_update"></textarea>
                            </div>
                        </div>


                        <!-- <div class="hr-line-dashed"></div> -->
                    </div>
                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_update text-success"></label>
                <label class="err_update text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- End Modal -->

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
            }).on('changeDate', function(e) {
            // Revalidate the date field
            $('#defaultForm2').bootstrapValidator('revalidateField', 'tgl');
            // $('#defaultForm2_update').bootstrapValidator('revalidateField', 'tgl_update');
            }); 


            $('#data_update1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd-mm-yyyy"
            }).on('changeDate', function(e) {
            // Revalidate the date field
            // $('#defaultForm2').bootstrapValidator('revalidateField', 'tgl');
            $('#defaultForm2_update').bootstrapValidator('revalidateField', 'tgl_update');
            }); 

           tabel_libur();
           //tabel_tkd_gr();


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


            $('#defaultForm2').bootstrapValidator({
                    live: 'enabled',
                    excluded : 'disabled',
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        tgl: {
                            validators: {
                                date: {
                                        format: 'DD-MM-YYYY',
                                        message: 'Date is not valid'
                                },
                                notEmpty: {
                                    message: 'Tanggal tidak boleh kosong'
                                }
                            }
                        // },jensk: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Jenis SK tidak boleh kosong'
                        //         }
                        //     }
                        },ket: {
                            validators: {
                                notEmpty: {
                                    message: 'Keterangan tidak boleh kosong'
                                }
                            }
                        }
                    }
                });


            $('#defaultForm2_update').bootstrapValidator({
                    live: 'enabled',
                    excluded : 'disabled',
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        tgl_update: {
                            validators: {
                                date: {
                                        format: 'DD-MM-YYYY',
                                        message: 'Date is not valid'
                                },
                                notEmpty: {
                                    message: 'Tanggal tidak boleh kosong'
                                }
                            }
                        // },jensk: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Jenis SK tidak boleh kosong'
                        //         }
                        //     }
                        },ket_update: {
                            validators: {
                                notEmpty: {
                                    message: 'Keterangan tidak boleh kosong'
                                }
                            }
                        }
                    }
                });


       });
    </script>
   

    <script type="text/javascript">

        // function show_data(){
        //     // alert('showdata')
            

        //      var tahun = $('#tahun').val();

        //     if(tahun!=''){
        //         $('#V_data').show();
        //         tabel_gaji();
        //     }else{
        //         $('#V_data').hide();
        //     }
        // }


    	function tabel_libur(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_libur').DataTable( {
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
                        url :"<?php echo site_url('index.php/master_libur/data_libur_nas')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_cuti').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_cuti").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_libur-error").html("");
                            $("#tbl_libur").append('<tbody class="tbl_libur-error"><tr><div colspan=4>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_libur_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_cuti input').unbind();
                $('#tbl_cuti input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }


        function form_libur(){
        	$('.msg').html('');
            $('.err').html('');

       		$('#tgl').val('');
       		$('#ket').html('');
            $('#modal_libur').modal('show'); 
        }

        function save(){
            // alert('simpan')
            $.ajax({
                    url : "<?php echo site_url('index.php/master_libur/ajax_add_data_libur')?>",
                    type: "POST",
                    data: $('#defaultForm2').serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        $('.msg').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                        $('.err').html("");
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                            $('.msg').html('<small>Data berhasil disimpan.</small>');
                            $('.err').html('');

                            $('#modal_libur').modal('hide');
                            tabel_libur();
                            // setTimeout(function () {
                            //     reload();
                            // }, 1000);                        

                        }else{
                            $('.msg').html('');
                            $('.err').html('');
                            swal({type:"warning",title:"DATA GAGAL DISIMPAN", text:"TANGGAL SUDAH DIGUNAKAN, MOHON PERIKSA KEMBALI DATA YANG DIINPUT"});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                    },
                    complete: function() {                            

                    }
                });
        }

        function hapus_data(id){
            // alert('hapus '+id)

            swal({
	          title: "Peringatan",
	          text: "Apakah anda ingin menghapus data ini?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Ya, Hapus!",
	          cancelButtonText: "Tidak!",
	          closeOnConfirm: false,
	          closeOnCancel: false
	        },
	        function(isConfirm){
	          if (isConfirm) {
	            hapus_data_exc(id);
	          } else {
	                swal("BATAL", "Proses dibatalkan", "error");
	          }
	        });
        }

        function hapus_data_exc(id){
        	

        	$.ajax({
                    url : "<?php echo site_url('index.php/master_libur/delete_libur')?>",
                    type: "POST",
                    data: {id:id},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                       		tabel_libur();
                       		swal("BERHASIL", "Data berhasil dihapus", "success");                  

                        }else{
                            swal("GAGAL", "Data gagal dihapus", "error");
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("GAGAL", "Data gagal dihapus", "error");
                    },
                    complete: function() {                            

                    }
                });
        }

        function ubah_data(id){
            // $('#modal_libur_update').modal('show');


            $.ajax({
                    url : "<?php echo site_url('index.php/master_libur/get_data_update')?>",
                    type: "POST",
                    data: {id:id},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                       		$('.msg_update').html('');
                            $('.err_update').html('');

                       		$('#id_update').val(id);
                       		$('#tgl_update').val(data.tgl);
                       		$('#ket_update').html(data.ket);
                            $('#modal_libur_update').modal('show');                   

                        }else{
                            $('#modal_libur_update').modal('hide'); 
                            swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
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


        function save_update(){
            // alert('simpan')
            $.ajax({
                    url : "<?php echo site_url('index.php/master_libur/ajax_update_data_libur')?>",
                    type: "POST",
                    data: $('#defaultForm2_update').serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        $('.msg_update').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                        $('.err_update').html("");
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                            $('.msg_update').html('<small>Data berhasil diubah.</small>');
                            $('.err_update').html('');

                            $('#modal_libur_update').modal('hide');
                            tabel_libur();
                            // setTimeout(function () {
                            //     reload();
                            // }, 1000);                        

                        }else{
                            $('.msg_update').html('');
                            $('.err_update').html('');
                            swal({type:"warning",title:"GAGAL", text:"TANGGAL SUDAH DIGUNAKAN, MOHON PERIKSA KEMBALI DATA YANG DIINPUT"});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                    },
                    complete: function() {                            

                    }
                });
        }


    </script>


    



